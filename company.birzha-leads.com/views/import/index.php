<?php

use App\Entities\Enums\BillStatus;
use App\Entities\Enums\BillType;

include __DIR__ . '/../header.php';

$inns = !empty($data['inns']) ? $data['inns'] : [];

?>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Импорт клиентов из excel файла</h2>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->

            <!-- ============================================================== -->

            <!-- recent orders  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h5 class="card-header">Импорт файла excel</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="/import-process" method="post" enctype="multipart/form-data">
                                    <label for=""><div style="padding-bottom: 10px">Выберите файл</div>
                                        <input type="file" name="excel">
                                    </label>

                                    <div>
                                        <input type="submit" value="Загрузить" class="button-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h5 class="card-header">Обновить статусы банков excel</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="/update-bills-process" method="post" enctype="multipart/form-data">
                                    <div class="d-flex">
                                        <div class="col-6">
                                            <label for=""><div style="padding-bottom: 10px">Выберите файл</div>
                                                <input type="file" name="excel">
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <label for="status">
                                                Статус
                                            </label>
                                            <select id="status" name="status" class="input-group__select">
                                                <?php foreach (BillStatus::cases() as $case) { ?>
                                                    <option value="<?= $case->value ?>"><?= BillStatus::getLabel($case->value) ?></option><?php ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="bank_id">
                                                Банк
                                            </label>
                                            <select id="status" name="bank_id" class="input-group__select">
                                                <?php foreach (BillType::cases() as $case) { ?>
                                                    <option value="<?= $case->value ?>"><?= BillStatus::getLabel($case->value) ?></option><?php ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <input type="submit" value="Загрузить" class="button-primary">
                                    </div>

                                    <?php
                                    if (!empty($inns)) { ?>
                                        <div>
                                            <br> <br>
                                            <h4>Не удалось найти следующие ИНН:</h4>
                                            <?php foreach ($inns as $inn) { ?>
                                                <span><?= $inn ?></span> <br>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                    ?>
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


