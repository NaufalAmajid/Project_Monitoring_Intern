<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Home</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard <?= ucwords($_SESSION['nama_status_user']) ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<!-- [ Main Content ] start -->
<?php
require_once 'classes/Main.php';
$main = new Main();
?>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <?php
        if ($_SESSION['status_user_id'] == 3) {
            $absensis = $main->getAbsensi($_SESSION['the_id']);
            $logbooks = $main->getLogbook($_SESSION['the_id']);
        } else {
            $absensis = $main->getAbsensi();
            $logbooks = $main->getLogbook();
        }
        ?>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card social-widget-card">
                    <div class="card-body-big bg-facebook">
                        <h3 class="text-white m-0"><?= $absensis['jumlah_absensi_verified'] ?></h3>
                        <span class="m-t-10">Jumlah Absensi <br> Terverifikasi</span>
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
            <!-- Facebook card end -->
            <!-- Twitter card start -->
            <div class="col-md-6 col-xl-3">
                <div class="card social-widget-card">
                    <div class="card-body-big bg-twitter">
                        <h3 class="text-white m-0"><?= $absensis['jumlah_absensi_unverified'] ?></h3>
                        <span class="m-t-10">Jumlah Absensi <br>Belum Terverifikasi</span>
                        <i class="fas fa-calendar-times"></i>
                    </div>
                </div>
            </div>
            <!-- Twitter card end -->
            <!-- Linked in card start -->
            <div class="col-md-6 col-xl-3">
                <div class="card social-widget-card">
                    <div class="card-body-big bg-linkedin">
                        <h3 class="text-white m-0"><?= $logbooks['jumlah_logbook_verified'] ?></h3>
                        <span class="m-t-10">Jumlah Logbook <br> Terverifikasi</span>
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>
            <!-- Linked in card end -->
            <!-- Google-plus card start -->
            <div class="col-md-6 col-xl-3">
                <div class="card social-widget-card">
                    <div class="card-body-big bg-googleplus">
                        <h3 class="text-white m-0"><?= $logbooks['jumlah_logbook_unverified'] ?></h3>
                        <span class="m-t-10">Jumlah Logbook <br>Belum Terverifikasi</span>
                        <i class="fas fa-clipboard"></i>
                    </div>
                </div>
            </div>
            <?php
            $users = $main->getAllUser();
            ?>
            <?php if ($_SESSION['status_user_id'] != 3) : ?>
                <div class="col-md-4">
                    <div class="card table-card widget-primary-card bg-c-blue">
                        <div class="row-table">
                            <div class="col-4 card-body-big">
                                <i class="fas fa-user-alt"></i>
                            </div>
                            <div class="col-8">
                                <h4><?= $users['jumlah_user'] ?></h4>
                                <h6>Jumlah User</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card table-card widget-purple-card bg-c-yellow">
                        <div class="row-table">
                            <div class="col-4 card-body-big">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="col-8">
                                <h4><?= $users['jumlah_pembimbing'] ?></h4>
                                <h6>Jumlah Pembimbing</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card table-card widget-purple-card bg-c-red">
                        <div class="row-table">
                            <div class="col-4 card-body-big">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="col-8">
                                <h4><?= $users['jumlah_siswa'] ?></h4>
                                <h6>Jumlah Siswa</h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
$jurusans = $main->getJurusanKelas();
$colors = ['primary', 'success', 'danger', 'warning', 'info', 'dark'];
?>
<?php if ($_SESSION['status_user_id'] != 3) : ?>
    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="campaign-scroll" style="height:370px;position:relative;">
                <table class="table table-hover m-b-0 without-header">
                    <tbody>
                        <?php foreach ($jurusans as $key => $jurusan) : ?>
                            <tr>
                                <td>
                                    <p class="m-0"><?= $jurusan['nama_jurusan'] ?></p>
                                </td>
                                <td class="text-end">
                                    <label class="badge badge-light-<?= $colors[rand(0, 5)] ?>"><?= $jurusan['jumlah_kelas'] ?> Kelas</label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php
    $siswa = $main->getDetailSiswa($_SESSION['the_id']);
    ?>
    <center>
        <h3>Selamat Datang <?= $_SESSION['nama'] ?></h3>
        <h4>Anda Login Sebagai <?= ucwords($_SESSION['nama_status_user']) ?></h4>
        <h5>Jurusan <?= ucwords($siswa['nama_jurusan']) ?> Kelas <?= ucwords($siswa['nama_kelas']) ?></h5>
        <h6>Nama Pembimbing <?= ucwords($siswa['nama_pembimbing']) ?></h6>
        <h6>Tempat PKL <?= ucwords($siswa['tempat_pkl']) ?></h6>
    </center>
<?php endif; ?>
<!-- [ Main Content ] end -->