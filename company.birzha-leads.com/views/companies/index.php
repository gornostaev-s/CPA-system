<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Helpers\AuthHelper;

include __DIR__ . '/../header.php';
?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Клиенты</h2>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Клиенты</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <form action="/clients" class="table-form">
                                    <table class="table js-table">
                                        <thead class="bg-light">
                                        <tr class="border-0">
                                            <th rowspan="2" class="border-0 column-num">#</th>
                                            <th rowspan="2" class="border-0">ФИО</th>
                                            <th rowspan="2" class="border-0">ИНН</th>
                                            <th rowspan="2" class="border-0">Телефон</th>
                                            <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                <th rowspan="2" class="border-0">Сотрудник</th>
                                            <?php } ?>
                                            <th rowspan="2" class="border-0">Тип операции</th>
                                            <th rowspan="2" class="border-0">Адрес</th>
                                            <th rowspan="2" class="border-0">Дата создания</th>
                                            <th rowspan="2" class="border-0">Статус</th>
                                            <th rowspan="2" class="border-0">Комментарий</th>
                                            <th rowspan="2" class="border-0">Комментарий (адм)</th>
                                            <th rowspan="2" class="border-0">Дата передачи заявки</th>
                                            <th rowspan="2" class="border-0">Дата отправки документа</th>
                                            <th rowspan="2" class="border-0">Дата выхода с регистрации</th>
                                            <th colspan="4" class="border-0">Альфа банк</th>
                                            <th colspan="3" class="border-0">Тинькофф банк</th>
                                            <th colspan="3" class="border-0">Сбербанк</th>
                                            <th colspan="3" class="border-0">ПСБ</th>
                                        </tr>
                                        <tr>
                                            <!-- Альфа банк -->
                                            <th>Статус</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Партнерка</th>
                                            <!-- Тинькофф банк -->
                                            <th>Статус</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <!-- Сбербанк -->
                                            <th>Статус</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <!-- ПСБ -->
                                            <th>Статус</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                        </tr>
                                        </thead>
                                        <tbody class="js-orders">
                                        <?php foreach ($data['companies'] as $company) {
                                            /** @var $company Company */
                                            ?>
                                            <tr class="js-dataRow" data-id="<?= $company->id ?>">
                                                <td class="modal-table-primary__col text-left"><?= $company->id ?></td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="fio" value="<?= $company->fio ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="inn" value="<?= $company->inn ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="phone" value="<?= $company->phone ?>" class="table-form__text">
                                                </td>
                                                <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                    <td class="modal-table-primary__col text-left">
                                                        Иванов Иван
                                                    </td>
                                                <?php } ?>
                                                <td class="modal-table-primary__col text-left">
                                                    <select name="operationType" class="table-form__select">
                                                        <?php foreach (OperationType::cases() as $case) { ?>
                                                            <option value="<?= $case->value ?>"><?= OperationType::getLabel($case->value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="address" value="<?= $company->address ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                <td class="modal-table-primary__col text-left">
                                                    <select name="status" class="table-form__select">
                                                        <?php foreach (Company::STATUSES as $key => $status) { ?>
                                                            <option value="<?= $key ?>" <?= ($company->status == $key) ? 'selected' : ''?>> <?= $status ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="comment" value="<?= $company->comment ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="comment_adm" value="<?= $company->comment_adm ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="date" name="submission_date" class="table-form__text" value="<?= (new DateTime($company->submission_date))->format('Y-m-d') ?>">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="date" name="sent_date" class="table-form__text" value="<?= (new DateTime($company->sent_date))->format('Y-m-d') ?>">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="date" name="registration_exit_date" class="table-form__text" value="<?= (new DateTime($company->registration_exit_date))->format('Y-m-d') ?>">
                                                </td>
                                                <!-- Альфа банк -->
                                                <td class="modal-table-primary__col text-left">
                                                    <select name="alfabank[status]" class="table-form__select">
                                                        <?php foreach (BillStatus::cases() as $item) { ?>
                                                            <option value="<?= $item->value ?>" <?= ($company->alfabank->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="date" name="alfabank[date]" class="table-form__text" value="<?= (new DateTime($company->alfabank->date))->format('Y-m-d') ?>">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="alfabank[comment]" value="<?= $company->alfabank->comment ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <select name="alfabank[partner]" class="table-form__select">
                                                        <?php foreach (PartnerType::cases() as $item) { ?>
                                                            <option value="<?= $item->value ?>" <?= ($company->alfabank->partner == $item->value) ? 'selected' : ''?>> <?= PartnerType::getLabel($item->value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <!-- Тинькофф банк -->
                                                <td class="modal-table-primary__col text-left">Создано</td>
                                                <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                <td class="modal-table-primary__col text-left">Комментарий</td>
                                                <!-- Сбербанк -->
                                                <td class="modal-table-primary__col text-left">Создано</td>
                                                <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                <td class="modal-table-primary__col text-left">Комментарий</td>
                                                <!-- ПСБ -->
                                                <td class="modal-table-primary__col text-left">Создано</td>
                                                <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                <td class="modal-table-primary__col text-left">Комментарий</td>
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

<script>
    // let target = document.querySelector('#search');
    // let timerId = null;

    // target.oninput = function () {
    //     let inputValue = this.value.trim();
    //     let lastTime = performance.now();
    //
    //     if (timerId) {
    //         clearTimeout(timerId);
    //     }
    //
    //     timerId = setTimeout(function() {
    //         if (performance.now() - lastTime > 1500 && inputValue) {
    //             console.log('Send', inputValue);
    //         }
    //     }, 1500);
    // }

    document.addEventListener('DOMContentLoaded', function () {

        let timerId = null;

        jQuery('.js-table').on('input', function (e) {
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
                    console.log(values);
                    jQuery.ajax({
                        url: '/v1/clients/update',
                        method: 'POST',
                        data: values,
                        success: function (data) {
                            // console.log(data)
                        }
                    })
                }
            }, 1500);
        })
    })
</script>

<?php
include __DIR__ . '/../footer.php';
?>


