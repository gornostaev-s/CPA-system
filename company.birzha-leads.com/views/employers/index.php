<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\EmployersStatus;
use App\Entities\Enums\OperationType;
use App\Entities\User;

include __DIR__ . '/../header.php';
?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Сотрудники</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card button-container">
                        <div class="button-container__item">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployer">
                                Добавить сотрудника
                            </button>
                        </div>
                        <div class="button-container__item">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployer">
                                Поменять пароль
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-10"></div>
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Сотрудники</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <form action="/v1/employers/update" class="table-form">
                                        <table class="table js-table">
                                            <thead class="bg-light js-tableHead">
                                            <tr class="border-0">
                                                <th class="border-0 column-num">#</th>
                                                <th class="border-0">Фамилия имя</th>
                                                <th class="border-0">Статус</th>
                                                <th class="border-0">Почта</th>
                                                <th class="border-0">Количество клиентов</th>
                                                <th class="border-0">Количество открытых счетов</th>
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
                                                        <input type="text" name="name" value="<?= $employer->name ?>" class="table-form__text">
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <select class="table-form__select" name="status">
                                                            <?php foreach (EmployersStatus::cases() as $case) { ?>
                                                                <option <?= ($case->value == $employer->status) ? 'selected' : '' ?> value="<?= $case->value ?>"><?= EmployersStatus::getLabel($case->value) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <input type="text" name="inn" value="<?= $employer->email ?>" class="table-form__text">
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        0
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        0
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

<script>
    document.addEventListener('DOMContentLoaded', function () {

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
    })
</script>

<?php
include __DIR__ . '/../footer.php';
?>


