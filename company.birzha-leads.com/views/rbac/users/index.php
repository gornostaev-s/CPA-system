<?php
/**
 * @var array $data
 */

use App\Entities\Company;
use App\Entities\Enums\EmployersStatus;
use App\Entities\Enums\OperationType;
use App\Entities\User;
use App\Helpers\AttributeCheckHelper;
use App\Helpers\BillHelper;
use App\Helpers\ClientHelper;
use App\RBAC\Entities\Role;
use App\RBAC\Managers\PermissionManager;

/** @var PermissionManager $permissionManager */
$permissionManager = $data['permissionManager'];

/** @var Role[] $roles */
$roles = $data['roles'];

include __DIR__ . '/../../header.php';
?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Роли пользователей</h2>
                    </div>
                </div>
<!--                <div class="col-md-12">-->
<!--                    <div class="card button-container">-->
<!--                        123-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-md-10"></div>
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Роли пользователей</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <form action="/v1/rbac/users/update" class="table-form">
                                        <table class="table js-table">
                                            <thead class="bg-light js-tableHead">
                                            <tr class="border-0">
                                                <th class="border-0 column-num">#</th>
                                                <th class="border-0">Фамилия имя</th>
                                                <th class="border-0">Роль</th>
                                            </tr>
                                            </thead>
                                            <tbody class="js-orders">
                                            <?php foreach ($data['users'] as $user) {
                                                /** @var $user User */
                                                ?>
                                                <tr class="js-dataRow" data-id="<?= $user->id ?>">
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $user->id ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <?= $user->name ?>
                                                    </td>
                                                    <td class="modal-table-primary__col text-left">
                                                        <select class="table-form__select" name="role_id">
                                                            <option value="0"> - </option>
                                                            <?php foreach ($roles as $role) { ?>
                                                                <option <?= ($role->id == $permissionManager->getUserRole($user->id)?->id) ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->name ?></option>
                                                            <?php } ?>
                                                        </select>
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

            values['user_id'] = $row.data('id');
            values[$input.attr('name')] = inputValue;

            if (timerId) {
                clearTimeout(timerId);
            }

            timerId = setTimeout(function() {
                if (performance.now() - lastTime > 1500 && inputValue) {
                    jQuery.ajax({
                        url: '/v1/rbac/users/update',
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
include __DIR__ . '/../../footer.php';
?>


