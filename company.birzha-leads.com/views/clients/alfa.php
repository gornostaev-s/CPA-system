<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\EmplStatus;
use App\Entities\Enums\NpdStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
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
$isAlfa = PermissionManager::getInstance()->has(PermissionsEnum::DemoAlfa->value);

$showFields = $_GET['fields'] ?? [];
?>
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">РКО Альфа</h2>
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
                                <div class="button-container__item button-container_search">
                                    <form class="search-panel" method="GET" action="/alfa">
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
                                                            'style' => 'width: 85px; min-width: 85px;'
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
                                                            'style' => 'width: 85px; min-width: 85px;'
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
                                                    <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата с.</span></th>
                                                    <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата вых</span></th>
                                                    <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Партнерка</span></th>
                                                    <!--                                                <th rowspan="2" class="border-0" style="min-width: min-content;"><span>Дата с.</span></th>-->
                                                    <th rowspan="2" class="border-0" style="min-width: 75px;"><span>Статус</span></th>
                                                    <th rowspan="2" class="border-0" style="min-width: 75px;"><span>Статус Альфа</span></th>
                                                    <th rowspan="2" class="border-0" style="min-width: 80px;"><span>Комментарий альфа</span></th>
                                                    <th rowspan="2" class="border-0" style="min-width: 100px;"><span>Комментарий (адм)</span></th>
                                                    <!--                                                <th rowspan="2" class="border-0" style="min-width: 90px;">Дата пер</th>-->
                                                    <th rowspan="2" class="border-0" style="min-width: 150px;"><span>Комм (МП)</span></th>
                                                </tr>
                                                </thead>
                                                <tbody class="js-orders">
                                                <?php foreach ($data['companies'] as $company) {
                                                    /** @var $company Company */
                                                    ?>
                                                    <tr class="js-dataRow" data-id="<?= $company->id ?>" style="background-color: <?= CompanyColorHelper::getColorByMode($company->mode) ?>">
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
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin) { ?>
                                                                <input style="width: 49px;" type="date" name="alfabank[date]" class="table-form__text" <?php if (!empty($company->alfabank->date)) { ?>value="<?= (new DateTime($company->alfabank->date))->format('Y-m-d') ?>"<?php } ?>>
                                                            <?php } else { ?>
                                                                <?= $company->alfabank->date ? (new DateTime($company->alfabank->date))->format('m-d') : '' ?>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin) { ?>
                                                                <input style="width: 49px;" type="date" name="registration_exit_date" class="table-form__text" <?php if (!empty($company->registration_exit_date)) { ?>value="<?= (new DateTime($company->registration_exit_date))->format('Y-m-d') ?>"<?php } ?>>
                                                            <?php } else { ?>
                                                                <?= $company->registration_exit_date ?(new DateTime($company->registration_exit_date))->format('Y-m-d') : '' ?>
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
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin) { ?>
                                                                <select name="alfabank[status]" class="table-form__select">
                                                                    <?php foreach (BillStatus::cases() as $item) { ?>
                                                                        <option value="<?= $item->value ?>" <?= ($company->alfabank->status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <?= BillStatus::getLabel($company->alfabank->status) ?>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin || $isAlfa) { ?>
                                                                <select name="alfabank[bank_status]" class="table-form__select">
                                                                    <?php foreach (BillStatus::cases() as $item) { ?>
                                                                        <option value="<?= $item->value ?>" <?= ($company->alfabank->bank_status == $item->value) ? 'selected' : ''?>> <?= BillStatus::getLabel($item->value) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <?= BillStatus::getLabel($company->alfabank->bank_status) ?>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin || $isAlfa) { ?>
                                                                <input type="text" name="alfabank[bank_comment]" value="<?= $company->alfabank->bank_comment ?>" class="table-form__text">
                                                            <?php } else { ?>
                                                                <?= $company->alfabank->bank_comment ?>
                                                            <?php } ?>
                                                        </td>
                                                        <?= TableColumnHelper::make()
                                                            ->setTag('td')
                                                            ->setAttributes([
                                                                'class' => 'modal-table-primary__col text-left'
                                                            ])
                                                            ->setData(!$isAdmin ? ($company->alfabank->comment ?: '') :'<input type="text" name="alfabank[comment]" value="' . $company->alfabank->comment . '" class="table-form__text">')
                                                            ->isHide((!empty($showFields) && !in_array('alfabank[comment]', $showFields)))
                                                            ->build()
                                                        ?>
                                                        <td class="modal-table-primary__col text-left">
                                                            <?php if ($isAdmin) { ?>
                                                                <input type="text" name="comment_mp" value="<?= $company->comment_mp ?>" class="table-form__text">
                                                            <?php } else { ?>
                                                                <?= $company->comment_mp ?>
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