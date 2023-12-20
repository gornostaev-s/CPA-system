<?php
include 'header.php';
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
                            <a class="nav-link" href="/">
                                Компании
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="/import">
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
            </div>

            <div class="modal" data-modal="revert">
                <!--                style="display: block"-->
                <div class="modal__overflow">

                </div>
                <div class="modal-small">
                    <h3 class="modal-small__title">
                        Подтверждение
                    </h3>
                    <p class="modal-small__text">
                        Возврат по заказу: №<span class="js-revertNum">123234</span>
                    </p>

                    <table class="js-revertTable modal-table-primary w-100">
                    </table>

                    <div class="js-revertErrors mt-4 text-left text-danger">

                    </div>

                    <div class="modal-small-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="#" class="modal-button js-refund">Возврат</a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="modal-button js-close">Отмена</a>
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
                include 'footer.php';
                ?>


