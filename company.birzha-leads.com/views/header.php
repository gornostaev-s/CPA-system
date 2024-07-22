<?php

use App\Helpers\ActivePageHelper;
use App\Helpers\AuthHelper;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;

?>
<!doctype html>
<html lang="ru">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css?v=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="/assets/libs/css/style.css">
    <link rel="stylesheet" href="/assets/libs/css/main.css?v=6">
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
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                        PermissionsEnum::viewClients->value, PermissionsEnum::editClients->value, PermissionsEnum::clients->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/', 'active') ?>" href="/">
                                Клиенты
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                        PermissionsEnum::ViewRkoAlfa->value, PermissionsEnum::EditRkoAlfa->value, PermissionsEnum::DemoAlfa->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/alfa', 'active') ?>" href="/alfa">
                                Альфа
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                        PermissionsEnum::ViewRkoTinkoff->value, PermissionsEnum::EditRkoTinkoff->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/tinkoff', 'active') ?>" href="/tinkoff">
                                Тинькофф
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                            PermissionsEnum::ViewRkoSber->value, PermissionsEnum::EditRkoSber->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/sber', 'active') ?>" href="/sber">
                                Сбер
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->has('editUsers')) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/employers', 'active') ?>" href="/employers">
                                Сотрудники
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::editUserPermissions->value)) { ?>
                        <li>
                            <a class="nav-link <?= ActivePageHelper::check('/user-roles', 'active') ?>" href="/user-roles">
                                Доступы
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                        PermissionsEnum::allStat->value, PermissionsEnum::viewStat->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/stat', 'active') ?>" href="/stat">
                                Статистика
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->hasPermissions([
                        PermissionsEnum::EditFunnel->value, PermissionsEnum::EditAllFunnel->value
                    ])) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/stat', 'active') ?>" href="/stat">
                                Статистика
                            </a>
                        </li>
                    <?php }?>
                    <li class="nav-item ">
                        <a class="nav-link <?= ActivePageHelper::check('/funnel', 'active') ?>" href="/funnel">
                            Воронка
                        </a>
                    </li>
                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::importClients->value)) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/import', 'active') ?>" href="/import">
                                Импорт
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::viewSkorozvonTable->value)) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/skorozvon-integration', 'active') ?>" href="/skorozvon-integration">
                                Звонок
                            </a>
                        </li>
                    <?php }?>
                    <?php if (PermissionManager::getInstance()->has(PermissionsEnum::viewSkorozvonTable->value)) { ?>
                        <li class="nav-item ">
                            <a class="nav-link <?= ActivePageHelper::check('/commands', 'active') ?>" href="/commands">
                                Команды
                            </a>
                        </li>
                    <?php }?>
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