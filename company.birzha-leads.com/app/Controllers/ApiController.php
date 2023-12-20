<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use App\Helpers\ApiHelper;
use App\Services\TinkoffService;
use App\Utils\ValidationUtil;

class ApiController extends Controller{
    protected $tinkoff;
    public function __construct()
    {
        $this->tinkoff = new TinkoffService();
    }

    public function index()
    {
        $orders = (new Order())
            ->setSelect([
                'id',
                'created_at',
                'order_data',
                'order_id',
                'status'
            ])
            ->setOrder([
                'sortField' => 'created_at',
                'sortDirection' => 'DESC'
            ])
            ->get()
        ;

        foreach ($orders as $key => $order) {
            $data = json_decode($order['order_data'], true);
            $orders[$key]['amount'] = $data['order']['amount'];
            $orders[$key]['phone'] = $data['client_info']['phone'];
            $orders[$key]['email'] = $data['client_info']['email'];
        }

        return ApiHelper::sendSuccess($orders);
    }

    public function create()
    {
        $request = $_POST;
        $data = TinkoffService::prepareCartData($request);
        $data['notification_url'] = 'https://api.moon-store.com/v1/orders/notifications?id=' . $request['order_id'];

        $response = $this
            ->tinkoff
            ->createQuery('https://partner.dolyame.ru/v1/orders/create', $data)
        ;

        Order::create([
            'order_id' => $request['order_id'],
            'order_data' => json_encode($data),
            'status' => 'created',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        header("Location: {$response['link']}");
    }

    public function refund()
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'required',
            "returned_items" => 'required',
        ]);

        $id = $_POST['id'] ?? 0;
        if (empty($id)) {
            return false;
        }

        $amount = 0;

        foreach ($request['returned_items'] as $item) {
            $amount += $item['price'];
        }

        $data['amount'] = $amount;
        $data['returned_items'] = $request['returned_items'];

        if (empty($data['returned_items'])) {
            return ApiHelper::sendError('Должна быть выбрана хотя бы одна товарная позиция для возврата');
        }

        $response = $this
            ->tinkoff
            ->createQuery('https://partner.dolyame.ru/v1/orders/'.$id.'/refund', $data)
        ;

        $order = (new Order())
            ->setFilter([
                'order_id' => $id
            ])
            ->get();

        if (!empty($response['refund_id'])) {
            Order::update($order[0]['id'], ['status' => 'refund']);
        } else {
            $mess = $response['message'] ?? 'Во время выполнения возврата возникла ошибка';
            return ApiHelper::sendError($mess);
        }

        return ApiHelper::sendSuccess($response);
    }

    public function notifications()
    {
        $id = $_GET['id'] ?? 0;
        if (empty($id)) {
            return false;
        }
        $response = $this
            ->tinkoff
            ->createQuery('https://partner.dolyame.ru/v1/orders/'.$id.'/info', [], 'GET')
        ;

        $order = (new Order())
            ->setFilter([
                'order_id' => $id
            ])
            ->get();

        if (!empty($response)) {
            Order::update($order[0]['id'], ['status' => $response['status']]);
        }

        $orderData = json_decode($order[0]['order_data'], true);

        if (!empty($response) && in_array($response['status'], TinkoffService::WAIT_STATUSES)) {
            $data = [
                'orderId' => $_GET['id'],
                'amount' => $orderData['order']['amount'],
                'items' => $orderData['order']['items']
            ];

            $res = $this
                ->tinkoff
                ->createQuery('https://partner.dolyame.ru/v1/orders/'.$_GET['id'].'/commit', $data);


            if (!empty($res)) {
                Order::update($order[0]['id'], ['status' => $res['status']]);
            }
        }

        return ApiHelper::sendSuccess($order);
    }

    public function orderDetail()
    {
        $request = ValidationUtil::validate($_GET,[
            "id" => 'required',
        ]);

        return ApiHelper::sendSuccess(json_decode((new Order())
            ->setSelect([
                'order_data'
            ])
            ->setFilter([
                'order_id' => $request['id']
            ])
            ->get()[0]['order_data'],true)['order']['items']);
    }
}