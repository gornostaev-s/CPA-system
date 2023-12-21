<?php
/**
 * @var array $data
 */

use App\Entities\Company;

include __DIR__ . '/../header.php';
?>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" href="index.html">Компании</a>
        </nav>
    </div>
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    <div class="nav-left-sidebar sidebar-dark">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item ">
                            <a class="nav-link active" href="/">
                                Компании
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="/import">
                                Импорт
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
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
                            <h2 class="pageheader-title">Импорт компаний из excel файла</h2>
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
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Импорт файла excel</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">ИНН</th>
                                            <th class="border-0">ФИО</th>
                                            <th class="border-0">Дата создания</th>
                                            <th class="border-0">Статус</th>
<!--                                            <th>Действия</th>-->
                                        </tr>
                                        </thead>
                                        <tbody class="js-orders">
                                            <?php foreach ($data['companies'] as $company) { ?>
                                                <tr>
                                                    <td class="modal-table-primary__col text-left"><?= $company->id ?></td>
                                                    <td class="modal-table-primary__col text-left"><?= $company->inn ?></td>
                                                    <td class="modal-table-primary__col text-left"><?= $company->fio ?></td>
                                                    <td class="modal-table-primary__col text-left"><?= $company->created_at ?></td>
                                                    <td class="modal-table-primary__col text-left"><?= Company::getStatusLabel($company->status)?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <script src="/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
                <!-- bootstap bundle js -->
                <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
                <!-- slimscroll js -->
                <script src="/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
                <!-- main js -->
                <script src="/assets/libs/js/main-js.js"></script>
                <!-- chart chartist js -->
                <script src="/assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
                <!-- sparkline js -->
                <script src="/assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
                <!-- morris js -->
                <script src="/assets/vendor/charts/morris-bundle/raphael.min.js"></script>
                <script src="/assets/vendor/charts/morris-bundle/morris.js"></script>
                <!-- chart c3 js -->
                <script src="/assets/vendor/charts/c3charts/c3.min.js"></script>
                <script src="/assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
                <script src="/assets/vendor/charts/c3charts/C3chartjs.js"></script>
                <script src="/assets/libs/js/dashboard-ecommerce.js"></script>
            </div>
        </div>
    </div>
</div>

                <?php
                include __DIR__ . '/../footer.php';
                ?>


