<?php
/**
 * @var array $data
 */

use App\Entities\Challenger;
use App\Entities\Company;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\ProcessStatus;
use App\Helpers\AttributeCheckHelper;
use App\Helpers\AuthHelper;

include __DIR__ . '/../header.php';
?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Воронка клиентов</h2>
                    </div>
                </div>
                <?php if (!empty($data['ownerId'])) { ?>
                    <div class="col-md-12">
                        <div class="card button-container">
                            <div class="button-container__item">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChallenger">
                                    Добавить клиента
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-10"></div>
            </div>
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>Воронка клиентов</h5>
                            </div>
                            <div class="col-6 text-right">
                                <form action="/funnel" class="js-employerSelect">
                                    <select class="table-form__select employer-select" name="ownerId">
                                        <option value="0">Выберите сотрудника</option>
                                        <?php foreach ($data['employers'] as $employer) { ?>
                                            <option <?= $data['ownerId'] == $employer->id ? 'selected' : ''?> value="<?= $employer->id ?>"><?= $employer->name ?></option>
                                        <?php } ?>
                                    </select>
                                </form>
                            </div>
                            <div class="col-12">
                                <div class="response-errors"></div>
                                <div class="response-success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <form action="/funnel" class="table-form">
                                    <table class="table js-table">
                                        <thead class="bg-light js-tableHead">
                                        <tr class="border-0">
                                            <th class="border-0 column-num">#</th>
                                            <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                <th class="border-0">Перенести</th>
                                            <?php } ?>
                                            <th class="border-0" style="min-width: 190px;">ФИО</th>
                                            <th class="border-0" style="min-width: 100px;">Телефон</th>
                                            <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                <th class="border-0">Сотрудник</th>
                                            <?php } ?>
                                            <th class="border-0" style="min-width: 90px;">Тип операции</th>
                                            <th class="border-0">Адрес</th>
                                            <th class="border-0">Дата создания</th>
                                            <th class="border-0" style="min-width: 75px;">Статус</th>
                                            <th class="border-0">Статус переноса</th>
                                            <th class="border-0">Комментарий</th>
                                            <th class="border-0">Комментарий (адм)</th>
                                        </tr>
                                        </thead>
                                        <tbody class="js-orders">
                                        <?php foreach ($data['challengers'] as $challenger) {
                                            /** @var $challenger Challenger */
                                            ?>
                                            <tr class="js-dataRow" data-id="<?= $challenger->id ?>">
                                                <td class="modal-table-primary__col text-left"><?= $challenger->id ?></td>
                                                <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                <td class="modal-table-primary__col text-center">
                                                    <?php if ($challenger->process_status == ProcessStatus::wait->value) { ?>
                                                        <a class="move-link js-moveChallenger" data-id="<?= $challenger->id ?>" href="#">
                                                            ⇒
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="fio" value="<?= $challenger->fio ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="inn" value="<?= $challenger->inn ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="phone" value="<?= $challenger->phone ?>" class="table-form__text">
                                                </td>
                                                <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                                                    <td class="modal-table-primary__col text-left">
                                                        Иванов Иван
                                                    </td>
                                                <?php } ?>
                                                <td class="modal-table-primary__col text-left">
                                                    <select <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> name="operation_type" class="table-form__select">
                                                        <?php foreach (OperationType::cases() as $case) { ?>
                                                            <option value="<?= $case->value ?>" <?= AttributeCheckHelper::checkEqual($challenger->operation_type, $case->value, 'selected') ?>><?= OperationType::getLabel($case->value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="address" value="<?= $challenger->address ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left"><?= (new DateTime($challenger->created_at))->format('d.m.Y') ?></td>
                                                <td class="modal-table-primary__col text-left">
                                                    <select <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> name="status" class="table-form__select">
                                                        <?php foreach (Company::STATUSES as $key => $status) { ?>
                                                            <option value="<?= $key ?>" <?= ($challenger->status == $key) ? 'selected' : ''?>> <?= $status ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <select <?= AttributeCheckHelper::checkEqual($challenger->process_status, ProcessStatus::moved->value, 'disabled') ?> name="process_status" class="table-form__select">
                                                        <?php foreach (ProcessStatus::cases() as $case) { ?>
                                                            <option value="<?= $case->value ?>" <?= ($challenger->process_status == $case->value) ? 'selected' : ''?>> <?= ProcessStatus::getLabel($case->value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="comment" value="<?= $challenger->comment ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input <?= AttributeCheckHelper::checkNotEqual($challenger->process_status, ProcessStatus::default->value, 'disabled') ?> type="text" name="comment_adm" value="<?= $challenger->comment_adm ?>" class="table-form__text">
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

    <!-- Modal -->
    <div class="modal fade" id="addChallenger" tabindex="-1" role="dialog" aria-labelledby="Добавить клиента" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="js-challengerCreateForm" action="/v1/challengers/add">
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
                            <input required class="input-group__text" type="text" name="phone" placeholder="Телефон">
                        </div>
                        <div class="input-group">
                            <input required class="input-group__text" type="text" name="address" placeholder="Адрес">
                        </div>
                        <div class="input-group">
                            <label for="operationType">Тип операции</label>
                            <select id="operationType" name="operationType" class="input-group__select">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {

        jQuery('.js-moveChallenger').on('click', function () {
            jQuery.ajax({
                type: 'get',
                url: '/v1/challengers/move?id=' + jQuery(this).data('id'),
                success: function(data){

                    console.log(data, data.success)

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

        jQuery('.js-challengerCreateForm').on('submit', function (e) {
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

        jQuery('.js-employerSelect').on('input', function () {
            jQuery(this).submit();
        })

        let timerId = null;

        jQuery('.js-table').on('input', function (e) {
            const $input = jQuery(e.target);
            const $row = jQuery(e.target).parents('.js-dataRow');

            jQuery('.js-tableHead').addClass('table-wait')

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
                        url: '/v1/challengers/update',
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