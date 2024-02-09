<?php
/**
 * @var array $data
 */

use App\Entities\Company;

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
                                    <table class="table">
                                        <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">ИНН</th>
                                            <th class="border-0">ФИО</th>
                                            <th class="border-0">Дата создания</th>
                                            <th class="border-0">Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody class="js-orders">
                                        <?php foreach ($data['companies'] as $company) { ?>
                                            <tr data-id="<?= $company->id ?>">
                                                <td class="modal-table-primary__col text-left"><?= $company->id ?></td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="inn" value="<?= $company->inn ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left">
                                                    <input type="text" name="fio" value="<?= $company->fio ?>" class="table-form__text">
                                                </td>
                                                <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                <td class="modal-table-primary__col text-left">
                                                    <select name="status" class="table-form__select">
                                                        <?php foreach (Company::STATUSES as $key => $status) { ?>
                                                            <option value="<?= $key ?>" <?= ($company->status == $key) ?: 'selected'?>> <?= $status ?></option>
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

                <?php
                include __DIR__ . '/../footer.php';
                ?>


