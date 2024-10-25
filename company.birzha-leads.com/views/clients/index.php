<?php
/**
 * @var array $data
 */

use App\Entities\Client;
use App\Entities\Command;
use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\EmplStatus;
use App\Entities\Enums\NpdStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Entities\Enums\SourceEnum;
use App\Entities\User;
use App\Helpers\AttributeCheckHelper;
use App\Helpers\AuthHelper;
use App\Helpers\CompanyColorHelper;
use App\Helpers\DateTimeInputHelper;
use App\Helpers\FormHelper;
use App\Helpers\TableColumnHelper;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;

include __DIR__ . '/../header.php';

$isAdmin = PermissionManager::getInstance()->has(PermissionsEnum::editClients->value);

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
                    <div class="header-container">
                        <div class="card button-container">
                            <div class="button-container__item">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fieldFilter">
                                    Отображение полей
                                </button>
                            </div>
                            <?php if (AuthHelper::getAuthUser()->isAdmin()) { ?>
                                <div class="button-container__item">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClient">
                                        Добавить клиента
                                    </button>
                                </div>
                                <div class="button-container__item">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteClient">
                                        Удалить клиента
                                    </button>
                                </div>
                            <?php } ?>
                            <div class="button-container__item button-container_search">
                                <form class="search-panel" method="GET" action="/">
                                    <?= FormHelper::formShowInputs() ?>
                                    <div class="search-panel__group">
                                        <input type="text" class="js-date search-panel__text" value="<?= !empty($_GET['datetime']) ? $_GET['datetime'] : DateTimeInputHelper::getDefaultIntervalString() ?>" name="datetime" />
                                    </div>
                                    <div class="search-panel__group">
                                        <input <?= !empty($_GET['inn']) ? "value=\"{$_GET['inn']}\"" : ''?> type="text" class="search-panel__text" name="inn" placeholder="ИНН">
                                    </div>
                                    <div class="search-panel__group">
                                        <input <?= !empty($_GET['phone']) ? "value=\"{$_GET['phone']}\"" : ''?> type="text" class="search-panel__text" name="phone" placeholder="Телефон">
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
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Клиенты</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive js-tableScroll">
                                    <form action="/" class="table-form">
                                        <table class="table js-table">
                                            <thead class="bg-light js-tableHead">
                                            <tr class="border-0">
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 67px;'
                                                    ])
                                                    ->setData('Ист')
                                                    ->isHide((!empty($showFields) && !in_array('source', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 67px;'
                                                    ])
                                                    ->setData('Режим')
                                                    ->isHide((!empty($showFields) && !in_array('mode', $showFields)))
                                                    ->build()
                                                ?>
                                                <th rowspan="2" class="border-0 column-num">
                                                    <span>
                                                        #
                                                    </span>
                                                </th>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 130px;'
                                                    ])
                                                    ->setData('ФИО')
                                                    ->isHide((!empty($showFields) && !in_array('fio', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 85px;'
                                                    ])
                                                    ->setData('ИНН')
                                                    ->isHide((!empty($showFields) && !in_array('inn', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 100px;'
                                                    ])
                                                    ->setData('Телефон')
                                                    ->isHide((!empty($showFields) && !in_array('phone', $showFields)))
                                                    ->build()
                                                ?>
                                                <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('th')
                                                        ->setAttributes([
                                                            'rowspan' => 2,
                                                            'class' => 'border-0',
                                                            'style' => 'min-width: 80px;'
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
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 90px'
                                                    ])
                                                    ->setData('Тип операции')
                                                    ->isHide((!empty($showFields) && !in_array('operation_type', $showFields)))
                                                    ->build()
                                                ?>
                                                <!--                                                <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата с.</span></th>-->
                                                <th rowspan="2" class="border-0" style="min-width: 75px;"><span>Статус ИП</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: 75px;"><span>НПД</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: 75px;"><span>Отправили <br> Самозан</span></th>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: min-content;'
                                                    ])
                                                    ->setData('Ответственный')
                                                    ->isHide((!empty($showFields) && !in_array('responsible', $showFields)))
                                                    ->build()
                                                ?>
                                                <?= TableColumnHelper::make()
                                                    ->setTag('th')
                                                    ->setAttributes([
                                                        'rowspan' => 2,
                                                        'class' => 'border-0',
                                                        'style' => 'min-width: 80px;'
                                                    ])
                                                    ->setData('Забив.')
                                                    ->isHide((!empty($showFields) && !in_array('scoring', $showFields)))
                                                    ->build()
                                                ?>
                                                <th rowspan="2" class="border-0" style="min-width: 80px;"><span>Комментарий</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: 100px;"><span>Комментарий (адм)</span></th>
                                                <!--                                                <th rowspan="2" class="border-0" style="min-width: 90px;">Дата пер</th>-->
                                                <th rowspan="2" class="border-0" style="min-width: 150px;"><span>Комм (МП)</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: 150px;"><span>Команда</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата с.</span></th>
                                                <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата вых</span></th>
                                                <th colspan="4" class="border-0"><span>Альфа банк</span></th>
                                                <th colspan="3" class="border-0"><span>Тинькофф банк</span></th>
                                                <th colspan="3" class="border-0"><span>Сбербанк</span></th>
                                                <th colspan="3" class="border-0"><span>ВТБ</span></th>
                                                <th colspan="3" class="border-0"><span>Точка</span></th>
                                            </tr>
                                            <tr>
                                                <!-- Альфа банк -->
                                                <th style="min-width: 75px;"><span>Статус</span></th>
                                                <th style="min-width: min-content;"><span>Дата</span></th>
                                                <th><span>Комментарий</span></th>
                                                <th><span>Партнерка</span></th>
                                                <!-- Тинькофф банк -->
                                                <th style="min-width: 75px;"><span>Статус</span></th>
                                                <th style="min-width: min-content;"><span>Дата</span></th>
                                                <th><span>Комментарий</span></th>
                                                <!-- Сбербанк -->
                                                <th style="min-width: 75px;"><span>Статус</span></th>
                                                <th style="min-width: min-content;"><span>Дата</span></th>
                                                <th><span>Комментарий</span></th>
                                                <!-- ВТБ -->
                                                <th style="min-width: 75px;"><span>Статус</span></th>
                                                <th style="min-width: min-content;"><span>Дата</span></th>
                                                <th><span>Комментарий</span></th>
                                                <!-- Точка -->
                                                <th style="min-width: 75px;"><span>Статус</span></th>
                                                <th style="min-width: min-content;"><span>Дата</span></th>
                                                <th><span>Комментарий</span></th>
                                            </tr>
                                            </thead>
                                            <tbody class="js-orders">
                                            <?php foreach ($data['companies'] as $company) {
                                                /** @var $company Client */
                                                ?>
                                                <tr class="js-dataRow" data-id="<?= $company->id ?>" style="background-color: <?= CompanyColorHelper::getColorByMode($company->mode) ?>">
                                                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                        <?php if (!(!empty($showFields) && !in_array('source', $showFields))) { ?>
                                                            <td class="modal-table-primary__col text-left">
                                                                <select name="source" class="table-form__select" style="width: 60px;">
                                                                    <?php foreach (SourceEnum::cases() as $case) { ?>
                                                                        <option value="<?= $case->value ?>" <?= AttributeCheckHelper::checkEqual($company->source, $case->value, 'selected') ?>><?= SourceEnum::getLabel($case->value) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?= SourceEnum::getLabel($company->source) ?>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                        <?php if (!(!empty($showFields) && !in_array('mode', $showFields))) { ?>
                                                            <td class="modal-table-primary__col text-left">
                                                                <select name="mode" class="table-form__select" style="width: 60px;">
                                                                    <?php foreach (ClientMode::cases() as $case) { ?>
                                                                        <option value="<?= $case->value ?>" <?= AttributeCheckHelper::checkEqual($company->mode, $case->value, 'selected') ?>><?= ClientMode::getLabel($case->value) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?= ClientMode::getLabel($company->mode) ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td class="modal-table-primary__col text-left">
                                                        <span class="t-small"><?= $company->id ?></span>
                                                    </td>

                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData(!$isAdmin ? $company->fio : '<input type="text" name="fio" value="' . $company->fio . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('fio', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData(!$isAdmin ? $company->inn : '<input type="text" name="inn" value="' . $company->inn . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('inn', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData(!$isAdmin ? $company->phone : '<input type="text" name="phone" value="' . $company->phone . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('phone', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                        <?php if (!(!empty($showFields) && !in_array('employer', $showFields))) { ?>
                                                            <td class="modal-table-primary__col text-left">
                                                                <select name="owner_id" class="table-form__select">
                                                                    <option value="0">-</option>
                                                                    <?php foreach ($data['employers'] as $employer) { ?>
                                                                        <option value="<?= $employer->id ?>" <?= AttributeCheckHelper::checkEqual($company->owner_id, $employer->id, 'selected') ?>><?= $employer->name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if (!(!empty($showFields) && !in_array('operation_type', $showFields))) { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin) { ?>
                                                                <select name="operation_type" class="table-form__select">
                                                                    <?php foreach (OperationType::cases() as $case) { ?>
                                                                        <option value="<?= $case->value ?>" <?= AttributeCheckHelper::checkEqual($company->operation_type, $case->value, 'selected') ?>><?= OperationType::getLabel($case->value) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <?= OperationType::getLabel($company->operation_type) ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="status" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="npd" class="table-form__select">
                                                                <?php foreach (NpdStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->npd == $item->value) ? 'selected' : ''?>> <?= NpdStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= NpdStatus::getLabel($company->npd) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="empl" class="table-form__select">
                                                                <?php foreach (EmplStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->empl == $item->value) ? 'selected' : ''?>> <?= EmplStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= EmplStatus::getLabel($company->empl) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData(!$isAdmin ? ($company->responsible ?: '') : '<input type="text" name="responsible" value="' . $company->responsible . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('responsible', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <select name="scoring" class="table-form__select">
                                                                <option value="0">-</option>
                                                                <?php foreach ($data['admins'] as $employer) { ?>
                                                                    <option value="<?= $employer->id ?>" <?= AttributeCheckHelper::checkEqual($company->scoring, $employer->id, 'selected') ?>><?= $employer->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php foreach ($data['admins'] as $admin) { ?>
                                                                <?= AttributeCheckHelper::checkEqual($company->scoring, $admin->id, 'selected') ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                    <?= TableColumnHelper::make()
                                                        ->setTag('td')
                                                        ->setAttributes([
                                                            'class' => 'modal-table-primary__col text-left'
                                                        ])
                                                        ->setData(!$isAdmin ? ($company->comment ?: '') :'<input type="text" name="comment" value="' . $company->comment . '" class="table-form__text">')
                                                        ->isHide((!empty($showFields) && !in_array('comment', $showFields)))
                                                        ->build()
                                                    ?>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="comment_adm" value="<?= $company->comment_adm ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->comment_adm ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="text" name="comment_mp" value="<?= $company->comment_mp ?>" class="table-form__text">
                                                    </td>
                                                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editClients->value)) { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <select name="command_id" class="table-form__select">
                                                                <option value="0">-</option>
                                                                <?php foreach ($data['commands'] as $command) { ?>
                                                                    <?php
                                                                    /**
                                                                     * @var Command $command
                                                                     */
                                                                    ?>
                                                                    <option value="<?= $command->id ?>" <?= AttributeCheckHelper::checkEqual($company->command_id, $command->id, 'selected') ?>><?= $command->title ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php foreach ($data['admins'] as $admin) { ?>
                                                                <?= AttributeCheckHelper::checkEqual($company->scoring, $admin->id, 'selected') ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="created_at" class="table-form__text" value="<?= (new DateTime($company->created_at))->format('Y-m-d') ?>">
                                                        <?php } else { ?>
                                                            <?= (new DateTime($company->created_at))->format('Y-m-d') ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="registration_exit_date" class="table-form__text" <?php if (!empty($company->registration_exit_date)) { ?>value="<?= (new DateTime($company->registration_exit_date))->format('Y-m-d') ?>"<?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->registration_exit_date ?(new DateTime($company->registration_exit_date))->format('Y-m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- Альфа банк -->
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->alfabank->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="alfabank[status]" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->alfabank->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->alfabank->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->alfabank->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="alfabank[date]" class="table-form__text" <?php if (!empty($company->alfabank->date)) { ?>value="<?= (new DateTime($company->alfabank->date))->format('Y-m-d') ?>"<?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->alfabank->date ? (new DateTime($company->alfabank->date))->format('m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="alfabank[comment]" value="<?= $company->alfabank->comment ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->alfabank->comment ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="alfabank[partner]" class="table-form__select">
                                                                <?php foreach (PartnerType::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->alfabank->partner == $item->value) ? 'selected' : ''?>> <?= PartnerType::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= PartnerType::getLabel($company->alfabank->partner) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- Тинькофф банк -->
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->tinkoff->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="tinkoff[status]" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->tinkoff->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->tinkoff->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->tinkoff->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="tinkoff[date]" class="table-form__text" <?php if (!empty($company->tinkoff->date)) { ?>value="<?= (new DateTime($company->tinkoff->date))->format('Y-m-d') ?>"<?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->tinkoff->date ? (new DateTime($company->tinkoff->date))->format('m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="tinkoff[comment]" value="<?= $company->tinkoff->comment ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->tinkoff->comment ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- Сбербанк -->
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->sberbank->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="sberbank[status]" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->sberbank->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->sberbank->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->sberbank->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="sberbank[date]" class="table-form__text" <?php if (!empty($company->sberbank->date)) { ?> value="<?= (new DateTime($company->sberbank->date))->format('Y-m-d') ?>" <?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->sberbank->date ? (new DateTime($company->sberbank->date))->format('m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="sberbank[comment]" value="<?= $company->sberbank->comment ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->sberbank->comment ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- ВТБ -->
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->psb->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="psb[status]" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->psb->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->psb->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->psb->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="psb[date]" class="table-form__text" <?php if (!empty($company->psb->date)) { ?>value="<?= (new DateTime($company->psb->date))->format('Y-m-d') ?>" <?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->psb->date ? (new DateTime($company->psb->date))->format('m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="psb[comment]" value="<?= $company->psb->comment ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->psb->comment ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- Точка -->
                                                    <td class="modal-table-primary__col text-left" <?php if (!$isAdmin) { ?>style="background-color: <?= CompanyColorHelper::getColorByStatus($company->psb->status) ?>"<?php } ?>>
                                                        <?php if ($isAdmin) { ?>
                                                            <select name="tochka[status]" class="table-form__select" style="background-color: <?= CompanyColorHelper::getColorByStatus($company->tochka->status) ?>">
                                                                <?php foreach (BillStatus::cases() as $item) { ?>
                                                                    <option value="<?= $item->value ?>" <?= ($company->tochka->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <?= BillStatus::getLabel($company->tochka->status) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input style="width: 49px;" type="date" name="tochka[date]" class="table-form__text" <?php if (!empty($company->tochka->date)) { ?>value="<?= (new DateTime($company->tochka->date))->format('Y-m-d') ?>" <?php } ?>>
                                                        <?php } else { ?>
                                                            <?= $company->tochka->date ? (new DateTime($company->tochka->date))->format('m-d') : '' ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?php if ($isAdmin) { ?>
                                                            <input type="text" name="tochka[comment]" value="<?= $company->tochka->comment ?>" class="table-form__text">
                                                        <?php } else { ?>
                                                            <?= $company->tochka->comment ?>
                                                        <?php } ?>
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

            <!--            <div class="card button-container">-->
            <!--                <div class="row">-->
            <!--                    <div class="col-12">-->
            <!--                        <div class="paging text_center js-paging">-->
            <!--                            <button class="paging__item active">1</button>-->
            <!--                            <button class="paging__item">2</button>-->
            <!--                            <button class="paging__item">3</button>-->
            <!--                            <button class="paging__item">4</button>-->
            <!--                            <button class="paging__item">5</button>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->

        </div>
    </div>
</div>

<?php
$fields = $_GET['fields'] ?? [];
?>

<!-- Modal -->
<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="Добавить клиента" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="js-clientCreateForm" action="/v1/clients/add">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить клиента</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="fio" placeholder="ФИО">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="inn" placeholder="ИНН">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text js-phone" type="text" name="phone" placeholder="Телефон">
                    </div>
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="comment" placeholder="Комментарий">
                    </div>
                    <div class="input-group">
                        <label for="operationType">Тип операции</label>
                        <select id="operationType" name="operation_type" class="input-group__select">
                            <?php foreach (OperationType::cases() as $case) { ?>
                                <option value="<?= $case->value ?>"><?= OperationType::getLabel($case->value) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="response-errors">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="input-group__text" type="hidden" name="owner_id" value="<?= $data['ownerId'] ?>">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteClient" tabindex="-1" role="dialog" aria-labelledby="Удалить клиента" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="js-clientDeleteForm" action="/v1/clients/delete">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удалить клиента</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input required class="input-group__text" type="text" name="id" placeholder="ID">
                    </div>
                    <div class="input-group">
                        <div class="response-errors">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="input-group__text" type="hidden" name="owner_id" value="<?= $data['ownerId'] ?>">
                    <button type="submit" class="btn btn-primary">Удалить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="fieldFilter" tabindex="-1" role="dialog" aria-labelledby="Отображение полей" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/">
                <?= FormHelper::formSearchInput() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Отображение полей</h5>
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
                                    <input <?= empty($fields) || in_array('responsible', $fields) ? 'checked' : ''?> value="responsible" type="checkbox" name="fields[]">
                                    <span>
                                        Ответственный
                                    </span>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="fields[]" value="mode">
                        <input type="hidden" name="fields[]" value="comment">
                        <input type="hidden" name="fields[]" value="comment_mp">
                        <input type="hidden" name="fields[]" value="comment_adm">
                        <input type="hidden" name="fields[]" value="npd">
                        <input type="hidden" name="fields[]" value="empl">
                        <input type="hidden" name="fields[]" value="status">
                        <input type="hidden" name="fields[]" value="scoring">

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
    document.addEventListener('DOMContentLoaded', function () {
        const $head = jQuery('.js-tableHead');
        jQuery('.js-tableScroll').on('scroll', function (e) {
            if (e.target.scrollTop > 10) {
                $head.addClass("thead-sticky");
                $head.find('span').css('top',  e.target.scrollTop + 'px')
            } else {
                $head.find('span').css('top',  0)
                $head.removeClass("thead-sticky");
            }
        })
        // window.onscroll = function() {scrollTableHeader()};
        // const $header = jQuery('thead');
        //
        // function scrollTableHeader() {
        //     $header.each(function (i, e) {
        //         console.log(jQuery(document).scrollTop())
        //         if (jQuery(document).scrollTop() > jQuery(e).offset().top) {
        //             const $win = jQuery(window);
        //             jQuery(e).addClass("thead-sticky");
        //             jQuery(e).find('span').css('top',  $win.scrollTop() - jQuery(e).offset().top + 'px')
        //         } else {
        //             jQuery(e).find('span').css('top',  0)
        //             jQuery(e).removeClass("thead-sticky");
        //         }
        //     })
        // }
    })
    document.addEventListener('DOMContentLoaded', function () {

        jQuery('.js-date').daterangepicker({
            locale: {
                format: 'DD.MM.YYYY'
            }
        });

        jQuery('.js-clientCreateForm').on('submit', function (e) {
            e.preventDefault();
            var form = jQuery(this);

            console.log(form.attr('action'));

            jQuery.ajax({
                type: 'post',
                url: form.attr('action'),
                data : form.serialize(),
                success: function(data){
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
                        window.location.reload();
                    }
                },
            })
        })

        jQuery('.js-clientDeleteForm').on('submit', function (e) {
            e.preventDefault();
            var form = jQuery(this);

            console.log(form.attr('action'));

            jQuery.ajax({
                type: 'post',
                url: form.attr('action'),
                data : form.serialize(),
                success: function(data){
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
                        window.location.reload();
                    }
                },
            })
        })

        function updateStatusColor ($input, inputValue) {
            switch (inputValue) {
                case '1':
                    $input.css('background-color', '#468e00')
                    break;
                case '2':
                case '3':
                case '4':
                    $input.css('background-color', '#ffc8aa')
                    break;
                case '5':
                case '6':
                case '7':
                    $input.css('background-color', '#b10202')
                    break;
                case '8':
                    $input.css('background-color', '#b9bc00')
                    break;
            }
        }

        function updateModeColor ($row, inputValue) {
            switch (inputValue) {
                case '0':
                case '1':
                    $row.css('background-color', 'transparent')
                    break;
                case '2':
                    $row.css('background-color', '#b1020233')
                    break;
                case '3':
                    $row.css('background-color', '#ff800042')
                    break;
                case '4':
                    $row.css('background-color', '#00d80030')
                    break;
                case '5':
                    $row.css('background-color', '#964b0052')
                    break;
                case '6':
                    $row.css('background-color', '#8000ff2b')
                    break;
                case '7':
                    $row.css('background-color', '#006ad52b')
                    break;
                case '8':
                    $row.css('background-color', '#8000ff2b')
                    break;
                case '9':
                    $row.css('background-color', '#00d80030')
                    break;
                case '10':
                    $row.css('background-color', '#ff800042')
                    break;
            }
        }

        let timerId = null;

        function afterUpdate ($row, $input, inputValue) {
            switch ($input.attr('name')) {
                case 'status':
                case 'alfabank[status]':
                case 'tinkoff[status]':
                case 'sberbank[status]':
                case 'psb[status]':
                case 'tochka[status]':
                    updateStatusColor($input, inputValue);
                    break;
                case 'mode' :
                    updateModeColor($row, inputValue);
                    break;
            }
        }

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
                    jQuery.ajax({
                        url: '/v1/clients/update',
                        method: 'POST',
                        data: values,
                        success: function (data) {
                            jQuery('.js-tableHead').removeClass('table-wait')
                            afterUpdate($row, $input, inputValue)
                        }
                    })
                }
            }, 1500);
        })
    })
</script>

<style>
    .thead-sticky {
        position: relative;
    }

    .table thead.thead-sticky th {
        padding: 0px;
    }

    .thead-sticky span {
        position: relative;
        display: block;
        background-color: #e6e6f5;
        padding-left: 3px;
        padding-bottom: 5px;
    }
</style>

<?php
include __DIR__ . '/../footer.php';
?>