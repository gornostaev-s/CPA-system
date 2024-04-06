<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Helpers\AttributeCheckHelper;
use App\Helpers\AuthHelper;
use App\Helpers\TableColumnHelper;

include __DIR__ . '/../header.php';

$showFields = $_GET['fields'] ?? [];
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
                <div class="col-md-12">
                    <div class="card button-container">
                        <div class="button-container__item">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fieldFilter">
                                Фильтр полей
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Клиенты</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <form action="/clients" class="table-form">
                                        <table class="table js-table">
                                            <thead class="bg-light js-tableHead">
                                            <tr class="border-0">
                                                <th rowspan="2" class="border-0 column-num">#</th>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0'
                                                    ])
                                                    ->setData('ФИО')
                                                    ->isHide((!empty($showFields) && !in_array('fio', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0'
                                                    ])
                                                    ->setData('ИНН')
                                                    ->isHide((!empty($showFields) && !in_array('inn', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0'
                                                    ])
                                                    ->setData('Телефон')
                                                    ->isHide((!empty($showFields) && !in_array('phone', $showFields)))
                                                    ->build()
                                                ?>
                                                <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('th')
                                                        ->setAttributes([
                                                            'rowspan' => 2,
                                                            'class' => 'border-0'
                                                        ])
                                                        ->setData('Сотрудник')
                                                        ->isHide((!empty($showFields) && !in_array('employer', $showFields)))
                                                        ->build()
                                                    ?>
                                                <?php } ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0'
                                                    ])
                                                    ->setData('Тип операции')
                                                    ->isHide((!empty($showFields) && !in_array('operation_type', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0'
                                                    ])
                                                    ->setData('Адрес')
                                                    ->isHide((!empty($showFields) && !in_array('address', $showFields)))
                                                    ->build()
                                                ?>
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

                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData('<input type="text" name="fio" value="' . $company->fio . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('fio', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData('<input type="text" name="inn" value="' . $company->inn . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('inn', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData('<input type="text" name="phone" value="' . $company->phone . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('phone', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                        <?= TableColumnHelper::make()
                                                            ->setTag('td')
                                                            ->setAttributes([
                                                                'class' => 'modal-table-primary__col text-left'
                                                            ])
                                                            ->setData($company->owner->name)
                                                            ->isHide((!empty($showFields) && !in_array('employer', $showFields)))
                                                            ->build()
                                                        ?>
                                                    <?php } ?>
                                                    <?php if (!(!empty($showFields) && !in_array('operation_type', $showFields))) { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <select name="operation_type" class="table-form__select">
                                                                <?php foreach (OperationType::cases() as $case) { ?>
                                                                    <option value="<?= $case->value ?> <?= AttributeCheckHelper::checkEqual($company->operation_type, $case->value, 'selected') ?>" <?= ($company->operation_type == $case->value) ? 'selected' : ''?>><?= OperationType::getLabel($case->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    <?php } ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData('<input type="text" name="address" value="' . $company->address . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('address', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <select name="status" class="table-form__select">
                                                            <?php foreach (BillStatus::cases() as $item) { ?>
                                                                <option value="<?= $item->value ?>" <?= ($company->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
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
                                                    <td class="modal-table-primary__col text-left">
                                                        <select name="tinkoff[status]" class="table-form__select">
                                                            <?php foreach (BillStatus::cases() as $item) { ?>
                                                                <option value="<?= $item->value ?>" <?= ($company->tinkoff->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="date" name="tinkoff[date]" class="table-form__text" value="<?= (new DateTime($company->tinkoff->date))->format('Y-m-d') ?>">
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="text" name="tinkoff[comment]" value="<?= $company->tinkoff->comment ?>" class="table-form__text">
                                                    </td>
                                                    <!-- Сбербанк -->
                                                    <td class="modal-table-primary__col text-left">
                                                        <select name="sberbank[status]" class="table-form__select">
                                                            <?php foreach (BillStatus::cases() as $item) { ?>
                                                                <option value="<?= $item->value ?>" <?= ($company->sberbank->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="date" name="sberbank[date]" class="table-form__text" value="<?= (new DateTime($company->sberbank->date))->format('Y-m-d') ?>">
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="text" name="sberbank[comment]" value="<?= $company->sberbank->comment ?>" class="table-form__text">
                                                    </td>
                                                    <!-- ПСБ -->
                                                    <td class="modal-table-primary__col text-left">
                                                        <select name="psb[status]" class="table-form__select">
                                                            <?php foreach (BillStatus::cases() as $item) { ?>
                                                                <option value="<?= $item->value ?>" <?= ($company->psb->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="date" name="psb[date]" class="table-form__text" value="<?= (new DateTime($company->psb->date))->format('Y-m-d') ?>">
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="text" name="psb[comment]" value="<?= $company->psb->comment ?>" class="table-form__text">
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

<?php
$fields = $_GET['fields'] ?? [];
?>
<!-- Modal -->
<div class="modal fade" id="fieldFilter" tabindex="-1" role="dialog" aria-labelledby="Фильтр полей" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/">
                <div class="modal-header">
                    <h5 class="modal-title">Фильтр полей</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="id" name="fields[]">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('fio', $fields) ? 'checked' : ''?> value="fio" type="checkbox" name="fields[]">
                                    <span>
                                        ФИО
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('inn', $fields) ? 'checked' : ''?> value="inn" type="checkbox" name="fields[]">
                                    <span>
                                        ИНН
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('phone', $fields) ? 'checked' : ''?> value="phone" type="checkbox" name="fields[]">
                                    <span>
                                        Телефон
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('employer', $fields) ? 'checked' : ''?> value="employer" type="checkbox" name="fields[]">
                                    <span>
                                        Сотрудник
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('operation_type', $fields) ? 'checked' : ''?> value="operation_type" type="checkbox" name="fields[]">
                                    <span>
                                        Тип операции
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="">
                                    <input <?= empty($fields) || in_array('address', $fields) ? 'checked' : ''?> value="address" type="checkbox" name="fields[]">
                                    <span>
                                        Адрес
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Применить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
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
                if (performance.now() - lastTime > 500 && inputValue) {
                    console.log(values);
                    jQuery.ajax({
                        url: '/v1/clients/update',
                        method: 'POST',
                        data: values,
                        success: function (data) {
                            jQuery('.js-tableHead').removeClass('table-wait')
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


