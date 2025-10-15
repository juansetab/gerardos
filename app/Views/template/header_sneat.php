<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= CORE_NAME ?></title>
    <meta name="description" content="" />
    <link rel="shortcut icon" href="<?= base_url("public/images") ?>/morelab.ico" type="image/ico" />
    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/css/demo.css" />
    <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url("public/library/sweetalert2") ?>/bootstrap-4.css">
    <link rel="stylesheet" href="<?= base_url("public/library/simpledatatable") ?>/simpledatatable.css">
    <script src="<?= base_url("public/library/sneat_template") ?>/vendor/js/helpers.js"></script>
    <script src="<?= base_url("public/library/sneat_template") ?>/js/config.js"></script>
    <script src="<?= base_url("public/library/sweetalert2") ?>/sweetalert2.js"></script>
    <script src="<?= base_url("public/library/sneat_template") ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url("public/library/simpledatatable") ?>/simpledatatable.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="<?= base_url() ?>" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img style="max-width: 10%; height : auto;" src="<?= base_url("public/images") ?>/logo_solo_letras.jpg">
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item <?= CORE_CONTROLLER . "/" . CORE_METHOD == "Portal/inicio" ? "active" : "" ?>">
                        <a href="<?= base_url() ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Inicio</div>
                        </a>
                    </li>
                    <li class="menu-item <?= CORE_CONTROLLER == "Constancias" ? "active open" : "" ?>">
                        <a href=" javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Layouts">Constancias</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?= CORE_CONTROLLER . "/" . CORE_METHOD == "Muestras/index" ? "active" : "" ?>">
                                <a href="<?= base_url("constancias/") ?>" class="menu-link">
                                    <div>Todas las constancias</div>
                                </a>
                            </li>
                            <li class="menu-item <?= CORE_CONTROLLER . "/" . CORE_METHOD == "Constancias/nueva" ? "active" : "" ?>">
                                <a href="<?= base_url("constancias/nueva") ?>" class="menu-link">
                                    <div>Capturar constancia</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item <?= CORE_CONTROLLER == "Catalogos" ? "active open" : "" ?>">
                        <a href=" javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-list-ul"></i>
                            <div data-i18n="Layouts">Catalogos</div>
                        </a>
                        <ul class="menu-sub">
                            <?php
                            $finded = array_search("Catalogosusuarios", array_column(session()->get("user_permissions"), "search_key"));
                            if ($finded !== false) {
                                echo '<li class="menu-item ' . (CORE_CONTROLLER . "/" . CORE_METHOD == "Catalogos/usuarios" ? "active" : "") . '">
                                <a href="' . base_url("catalogos/usuarios")  . '" class="menu-link">
                                    <div>Usuarios</div>
                                </a>
                            </li>';
                            }
                            $finded = array_search("Catalogosinstructores", array_column(session()->get("user_permissions"), "search_key"));
                            if ($finded !== false) {
                                echo '<li class="menu-item ' . (CORE_CONTROLLER . "/" . CORE_METHOD == "Catalogos/instructores" ? "active" : "") . '">
                                <a href="' . base_url("catalogos/instructores")  . '" class="menu-link">
                                    <div>Instructores</div>
                                </a>
                            </li>';
                            } ?>
                        </ul>
                    </li>

                </ul>
            </aside>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url("public/images") ?>/user.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="<?= base_url("public/images") ?>/user.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= session("user_data")["username"] ?></span>
                                                    <small class="text-muted"><?= session("user_data")["name"] ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url("login/logout") ?>">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Cerrar sesión</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">