<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\BillType;
use App\Entities\Enums\EmployersStatus;
use App\Entities\Enums\OperationType;
use App\Entities\User;
use App\Helpers\AttributeCheckHelper;
use App\Helpers\BillHelper;
use App\Helpers\ClientHelper;
use App\Helpers\DateTimeInputHelper;

/** @var BillHelper $billHelper */
$billHelper = $data['billHelper'];

/** @var ClientHelper $clientHelper */
$clientHelper = $data['clientHelper'];

include __DIR__ . '/../header.php';
?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Статистика</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="header-container">
                        <div class="card button-container">
                            <div class="button-container__item button-container_search">
                                <form class="search-panel" method="GET" action="/stat">
                                    <div class="search-panel__group">
                                        <input type="text" class="js-date search-panel__text" value="<?= !empty($_GET['datetime']) ? $_GET['datetime'] : null ?>" name="datetime" />
                                    </div>
                                    <div class="search-panel__group">
                                        <button type="submit" class="btn btn-primary">
                                            Показать
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-12">-->
<!--                    <div class="card button-container">-->
<!--                        <div class="button-container__item">-->
<!--                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployer">-->
<!--                                Добавить сотрудника-->
<!--                            </button>-->
<!--                        </div>-->
<!--                        <div class="button-container__item">-->
<!--                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePassword">-->
<!--                                Поменять пароль-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-md-10"></div>
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Статистика</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <form action="/v1/employers/update" class="table-form">
                                        <table class="table js-table">
                                            <thead class="bg-light js-tableHead">
                                            <tr class="border-0">
                                                <th class="border-0 column-num">#</th>
                                                <th class="border-0">Фамилия имя</th>
                                                <th class="border-0">Количество клиентов</th>
                                                <th class="border-0">Количество открытых счетов</th>
                                                <th class="border-0">Альфа</th>
                                                <th class="border-0">Альфа ИП</th>
                                                <th class="border-0">Тин</th>
                                                <th class="border-0">Тин ИП</th>
                                                <th class="border-0">Сбер</th>
                                                <th class="border-0">Сбер ИП</th>
                                                <th class="border-0">А+Т+С</th>
                                                <th class="border-0">День(А+Т+С)</th>
                                                <th class="border-0">Неделя(А+Т+С)</th>
                                            </tr>
                                            </thead>
                                            <tbody class="js-orders">
                                            <?php foreach ($data['employers'] as $employer) {
                                                /** @var $employer User */
                                                ?>
                                                <tr class="js-dataRow" data-id="<?= $employer->id ?>">
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $employer->id ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $employer->name ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $clientHelper->getClientsCountByUserId($employer->id) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getOpenBillsCountByUserId($employer->id) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::alfabank->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::alfabank->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::tinkoff->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::tinkoff->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::sberbank->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $billHelper->getBillsCountByUserId($employer->id, BillType::sberbank->value) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= empty($data['period'])
                                                            ? $clientHelper->getOperationTypeCountByUserId($employer->id, OperationType::TYPE1->value)
                                                            : $clientHelper->getOperationTypeCountByUserIdAndPeriod($employer->id, OperationType::TYPE1->value, $data['period'])
                                                        ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $clientHelper->getOperationTypeCountByUserIdAndPeriod($employer->id, OperationType::TYPE1->value, $data['dayPeriod']) ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $clientHelper->getOperationTypeCountByUserIdAndPeriod($employer->id, OperationType::TYPE1->value, $data['weekPeriod']) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addEmployer" tabindex="-1" role="dialog" aria-labelledby="Добавить сотрудника" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="js-authForm" action="/v1/register" data-redirect="/employers">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить сотрудника</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="name" placeholder="Введите имя">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="email" placeholder="Введите email">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="password" name="password" placeholder="Введите пароль">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="password" name="passwordConfirm" placeholder="Повторите пароль">
                    </div>
                    <div class="input-group">
                        <div class="response-errors">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="notAuth" value="1">

                    <button type="submit" class="btn btn-primary">Зарегистрировать</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="Поменять пароль" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="js-changePassword" action="/v1/change-employer-password" data-redirect="/employers">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Поменять пароль сотрудника</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <select name="id" class="input-group__select">
                            <option value="">Выберите сотрудника</option>
                            <?php foreach ($data['employers'] as $employer) { ?>
                                <option value="<?= $employer->id ?>"><?= $employer->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="password" name="password" placeholder="Введите пароль">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="password" name="passwordConfirm" placeholder="Повторите пароль">
                    </div>
                    <div class="input-group">
                        <div class="response-success">

                        </div>
                        <div class="response-errors">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Поменять пароль</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        jQuery('.js-date').daterangepicker({
            locale: {
                format: 'DD.MM.YYYY'
            }
        });

        function afterUpdate ($row, $input, inputValue) {
            console.log($row, $input, inputValue)
        }

        let timerId = null;

        jQuery('.js-table').on('input', function (e) {
            jQuery('.js-tableHead').addClass('table-wait')
            const $input = jQuery(e.target);
            const $row = jQuery(e.target).parents('.js-dataRow');

            let inputValue = $input.val();
            let lastTime = performance.now();
            let values = {};

            values['id'] = $row.data('id');
            values[$input.attr('name')] = inputValue;

            if (timerId) {
                clearTimeout(timerId);
            }

            timerId = setTimeout(function() {
                if (performance.now() - lastTime > 1500 && inputValue) {
                    jQuery.ajax({
                        url: '/v1/employers/update',
                        method: 'POST',
                        data: values,
                        success: function (data) {
                            jQuery('.js-tableHead').removeClass('table-wait')
                            afterUpdate($row, $input, inputValue);
                        }
                    })
                }
            }, 1500);
        })

        jQuery('.js-changePassword').on('submit', function (e) {
            e.preventDefault();
            var form = jQuery(e.target);
            var redirect = form.data('redirect')

            jQuery.ajax({
                type: 'post',
                url: form.attr('action'),
                data : form.serialize(),
                success: function(data){
                    jQuery('.response-errors').html("")
                    jQuery('.response-success').html("")
                    // console.log(data)
                    if(!data.success){
                        var text = '';
                        for (var prop in data.errors) {
                            text += '<p>'+data.errors[prop]+'</p>';
                        }
                        if (!text) {
                            jQuery('.response-errors').html("Возникла ошибка!")
                        } else {
                            jQuery('.response-errors').html(text)
                        }
                    } else {
                        form[0].reset();
                        form.find('button[type=submit]').hide();
                        form.find('.response-success').html('<p>Пароль успешно изменен</p>');
                    }
                },
            })
        })
    })
</script>

<?php
include __DIR__ . '/../footer.php';
?>