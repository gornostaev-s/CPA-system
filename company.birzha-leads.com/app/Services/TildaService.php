<?php

namespace App\Services;
ini_set('display_errors', E_ALL);

class TildaService
{
    const API_URL = 'https://store.tilda.cc/connectors/commerceml/';

    private $session;
    private $import;
    private $offers;
    private $images;
    public $response;

    public function __construct()
    {
        $this->createQuery('?type=catalog&mode=checkauth');
        $this->session = 'PHPSESSID=' . explode("\n", $this->response['?type=catalog&mode=checkauth'])[2];

        $this->createQuery('?type=catalog&mode=init');
    }

    public function setImport($import): TildaService
    {
        $this->import = $import;
        return $this;
    }

    public function setOffers($offers): TildaService
    {
        $this->offers = $offers;
        return $this;
    }

    public function files(): TildaService
    {
        $this->createQuery('?type=catalog&mode=file&filename=import.xml', $this->import);
        $this->createQuery('?type=catalog&mode=file&filename=offers.xml', $this->offers);
        return $this;
    }

    public function import(): TildaService
    {
        $this->createQuery('?type=catalog&mode=import&filename=import.xml', $this->import);
        $this->createQuery('?type=catalog&mode=import&filename=offers.xml', $this->offers);

        return $this;
    }

    private function createQuery($query, $content = ''): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::API_URL . $query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERPWD => '2702351:4e6e9ca4b53570378a1fbbd4046db5cd',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Cookie: __ddg1_=kg29G6vVgG5yIBQPV3NE; ' . $this->session
            ),
        ));

        $response = curl_exec($curl);

        if (!empty($response)) {
            $this->response[$query] = $response;
        }

        curl_close($curl);
    }

    public function importImages(array $items)
    {
        foreach ($items as $item) {
            foreach ($item->images as $image) {
                if (empty($filename = self::getImageBasename($image))) {
                    continue;
                }
                $this->createQuery('?type=catalog&mode=file&filename=' . $filename, file_get_contents($image));
                echo '<pre>';
                var_dump($filename);
                die;
            }
        }
    }

    public static function getImageBasename(string $url)
    {
        $path = parse_url($url)['path'];
        return pathinfo($path)['basename'];
    }

    public function setImages(array $images)
    {
        $this->images = $images;
        return $this;
    }
}