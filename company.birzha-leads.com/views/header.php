<?php

use App\Helpers\ActivePageHelper;
use App\Helpers\AuthHelper;

?>
<!doctype html>
<html lang="ru">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css?v=1">
    <link rel="stylesheet" href="/assets/libs/css/style.css">
    <link rel="stylesheet" href="/assets/libs/css/main.css?v=5">
    <title>Панель администратора</title>
</head>
<body>

<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <div class="dashboard-header__logoContainer">
                <a class="navbar-brand" href="/">
                    <img class="dashboard-header__logo" src="/assets/images/logo.png" alt="">
                </a>
            </div>
            <div class="top-menu">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link <?= ActivePageHelper::check('/', 'active') ?>" href="/">
                            Клиенты
                        </a>
                    </li>
                    <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/employers', 'active') ?>" href="/employers">
                                Сотрудники
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item ">
                        <a class="nav-link <?= ActivePageHelper::check('/stat', 'active') ?>" href="/stat">
                            Статистика
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= ActivePageHelper::check('/funnel', 'active') ?>" href="/funnel">
                            Воронка
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= ActivePageHelper::check('/import', 'active') ?>" href="/import">
                            Импорт клиентов
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link js-logout" href="#">
                            Выйти
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    <div class="nav-left-sidebar sidebar-dark" style="display: none;">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/', 'active') ?>" href="/">
                                Клиенты
                            </a>
                        </li>
                        <?php if (AuthHelper::getAuthUser()?->isAdmin()) { ?>
                            <li class="nav-item ">
                                <a class="nav-link <?= ActivePageHelper::check('/employers', 'active') ?>" href="/employers">
                                    Сотрудники
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/stat', 'active') ?>" href="/stat">
                                Статистика
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/funnel', 'active') ?>" href="/funnel">
                                Воронка
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/import', 'active') ?>" href="/import">
                                Импорт клиентов
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link js-logout" href="#">
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>