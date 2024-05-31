<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: index.php');
    exit;
}

date_default_timezone_set('Asia/Jakarta');

require_once 'config/database.php';
require_once 'config/functions.php';
require_once 'classes/DB.php';
require_once 'classes/Menu.php';

$func = new Functions();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sistem Informasi Monitoring PKL</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">

    <!-- notification css -->
    <link rel="stylesheet" href="assets/plugins/notification/css/notification.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">

    <!-- notification css -->
    <link rel="stylesheet" href="assets/css/plugins/notifier.css">

    <!-- data tables css -->
    <link rel="stylesheet" href="assets/plugins/data-tables/css/datatables.min.css">

    <!-- modal-window-effects css  -->
    <link rel="stylesheet" href="assets/plugins/modal-window-effects/css/md-modal.css">

    <!-- daterangepicker css -->
    <link rel="stylesheet" href="assets/css/plugins/daterangepicker.css">

    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <style>
        .input-border-bottom {
            border: none;
            border-bottom: 1px solid #000;
            border-radius: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
        }

        .input-without-border {
            border: none;
            border-radius: 0;
            background-color: transparent;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
        }

        .select-without-border {
            border: none;
            border-bottom: 1px solid #000;
            border-radius: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
        }

        #image-placeholder {
            cursor: pointer;
            width: 100%;
            height: auto;
            display: block;
        }

        .header-logbook {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menupos-fixed menu-dark menu-item-icon-style6 ">
        <div class="navbar-wrapper ">
            <div class="navbar-brand header-logo">
                <a href="index.html" class="b-brand">
                    <img src="assets/images/logo.svg" alt="logo" class="logo images">
                    <img src="assets/images/logo-icon.svg" alt="logo" class="logo-thumb images">
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            </div>
            <div class="navbar-content scroll-div   " id="layout-sidenav">
                <ul class="nav pcoded-inner-navbar sidenav-inner">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu</label>
                    </li>
                    <?php
                    $menu = new Menu();
                    $mymenu = $menu->read($_SESSION['status_user_id']);
                    ?>
                    <li class="nav-item <?= isset($_GET['mydashboard']) ? 'active' : '' ?>"><a href="?mydashboard" class="nav-link" id="btn-mydashboard"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>
                    <?php foreach ($mymenu as $menuId => $menus) : ?>
                        <?php if (isset($menus['submenu'])) : ?>
                            <li class="nav-item pcoded-hasmenu <?= isset($_GET['sub']) && $_GET['page'] == $menus['nama_menu'] ? 'active pcoded-trigger' : '' ?>">
                                <a href="#" class="nav-link"><span class="pcoded-micon"><i class="feather icon-grid"></i></span><span class="pcoded-mtext"><?= ucwords($menus['nama_menu']) ?></span></a>
                                <ul class="pcoded-submenu">
                                    <?php foreach ($menus['submenu'] as $submenu) : ?>
                                        <li class="<?= isset($_GET['sub']) && $_GET['sub'] == $submenu['direktori'] && $_GET['page'] == $menus['nama_menu'] ? 'active' : '' ?>"><a href="?page=<?= $menus['nama_menu'] ?>&sub=<?= $submenu['direktori'] ?>" class=""><?= ucwords($submenu['nama_submenu']) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item <?= isset($_GET['page']) && $_GET['page'] == $menus['nama_menu'] ? 'active' : '' ?>"><a href="?page=<?= $menus['direktori'] ?>" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext"><?= ucwords($menus['nama_menu']) ?></span></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="nav-item"><a href="#" onclick="Logout()" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Keluar</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->



    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">

        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
            <a href="index.html" class="b-brand">

                <img src="assets/images/logo.svg" alt="" class="logo images">
                <img src="assets/images/logo-icon.svg" alt="" class="logo-thumb images">
            </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="#!">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-notification">
                            <div class="pro-head">
                                <img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
                                <span>
                                    <span class="text-muted"><?= ucwords($_SESSION['nama_status_user']) ?></span>
                                    <span class="h6"><?= ucwords($_SESSION['nama']) ?></span>
                                </span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="?page=profil" class="dropdown-item"><i class="feather icon-user"></i> Profile</a>
                                <li><a href="#" onclick="Logout()" class="dropdown-item"><i class="feather icon-power text-danger"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </header>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <?php
                            $page = isset($_GET['page']) ? $_GET['page'] : '';
                            $sub = isset($_GET['sub']) ? $_GET['sub'] : '';
                            if ($page == '') {
                                include 'menus/main.php';
                            } else if (isset($_GET['mydashboard'])) {
                                include 'menus/main.php';
                            } else {
                                if ($sub == '') {
                                    include 'menus/' . $page . '.php';
                                } else {
                                    include 'menus/' . $page . '/' . $sub . '.php';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/plugins/notifier.js"></script>
    <script src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
    <script src="assets/js/pages/ac-alert.js"></script>

    <!-- datatable Js -->
    <script src="assets/plugins/data-tables/js/datatables.min.js"></script>
    <script src="assets/plugins/data-tables/js/buttons.colVis.min.js"></script>

    <!-- modal-window-effects Js -->
    <script src="assets/plugins/modal-window-effects/js/classie.js"></script>
    <script src="assets/plugins/modal-window-effects/js/modalEffects.js"></script>

    <!-- datepicker -->
    <script src="assets/js/plugins/moment.min.js"></script>
    <script src="assets/js/plugins/daterangepicker.js"></script>

    <script>
        $(document).ready(function() {
            if (window.location.href.indexOf('page') == -1) {
                $('#btn-mydashboard').click();
            }
        });

        $('#search-absensi-siswa').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary'
        }, function(start, end, label) {
            $('#search-absensi-siswa .form-control').val(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
        });

        $('#search-logbook-siswa').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary'
        }, function(start, end, label) {
            $('#search-logbook-siswa .form-control').val(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
        });


        function Logout(changePassword = false) {
            if (changePassword) {
                $.ajax({
                    url: 'classes/Login.php',
                    type: 'post',
                    data: {
                        action: 'logout'
                    },
                    success: function(response) {
                        if (response == 'success') {
                            swal("Berhasil!", "Anda berhasil mengganti password, silahkan login kembali", "info", {
                                button: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = 'index.php';
                            });
                        } else {
                            swal("Gagal!", "Anda gagal keluar", "error", {
                                button: false,
                                timer: 2000
                            });
                        }
                    }
                });
            } else {
                swal({
                    title: "Apakah anda yakin?",
                    text: "Anda akan keluar dari sistem",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willLogout) => {
                    if (willLogout) {
                        $.ajax({
                            url: 'classes/Login.php',
                            type: 'post',
                            data: {
                                action: 'logout'
                            },
                            success: function(response) {
                                if (response == 'success') {
                                    swal("Berhasil!", "Anda berhasil keluar", "info", {
                                        button: false,
                                        timer: 2000
                                    }).then(() => {
                                        window.location.href = 'index.php';
                                    });
                                } else {
                                    swal("Gagal!", "Anda gagal keluar", "error", {
                                        button: false,
                                        timer: 2000
                                    });
                                }
                            }
                        });
                    } else {
                        swal("Anda tidak jadi keluar", {
                            icon: "info",
                            button: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        }
    </script>

</body>

</html>