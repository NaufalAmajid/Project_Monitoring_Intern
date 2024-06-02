<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan & Riwayat Absensi Siswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=riwayat&sub=absensi">Laporan & Riwayat Absensi</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
include 'classes/RiwayatAbsensi.php';
$riwayatAbsensi = new RiwayatAbsensi();
?>
<div class="row mb-4">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li><a class="nav-link text-start active" id="v-pills-home-tab" data-bs-toggle="pill" href="#today">Hari Ini <?= $func->dateIndonesia(date('Y-m-d')) ?></a></li>
                    <li><a class="nav-link text-start" id="v-pills-profile-tab" data-bs-toggle="pill" href="#unverified">Belum Diverifikasi</a>
                    </li>
                    <li><a class="nav-link text-start" id="v-pills-messages-tab" data-bs-toggle="pill" href="#all">Semua</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="today">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $riwayatAbsensiToday = $riwayatAbsensi->getAbsensiSiswaToday($_SESSION['the_id']);
                                    $no = 1;
                                    ?>
                                    <?php foreach ($riwayatAbsensiToday as $today) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $today['nama_siswa'] ?></td>
                                            <td><?= $today['nis'] ?></td>
                                            <td><?= $today['nama_kelas'] ?></td>
                                            <td><?= $today['nama_jurusan'] ?></td>
                                            <td>
                                                <center>
                                                    <div><?= $today['masuk'] ?></div>
                                                    <div>
                                                        <img src="lampiran/absensi/<?= $today['lampiran_masuk'] ?>" alt="<?= $today['lampiran_masuk'] ?>" class="img-thumbnail">
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div><?= $today['keluar'] ?></div>
                                                    <?php if ($today['lampiran_keluar']) : ?>
                                                        <div>
                                                            <img src="lampiran/absensi/<?= $today['lampiran_keluar'] ?>" alt="<?= $today['lampiran_masuk'] ?>" class="img-thumbnail">
                                                        </div>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch custom-switch-v1 mb-2">
                                                    <input type="checkbox" class="form-check-input input-info custom-control-input" id="customswitchv2-6" <?= $today['is_verified'] == 1 ? 'checked disabled' : '' ?> onchange="verifAbsensi('<?= $today['absensi_id'] ?>')">
                                                    <label class="form-check-label align-text-top" for="customswitchv2-6"><?= $today['is_verified'] == 1 ? 'Terverifikasi' : 'Belum diverifikasi' ?></label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="unverified">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class='input-group' id='search-riwabsensi-unverif-siswa'>
                                    <input type='text' class="form-control" placeholder="Select Date" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <div class="form-group">
                                    <button class="btn btn-info btn-icon" id="btn-search-riwabsensi-unverif" type="button" onclick="searchRiAbsensiUnverif('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-riwabsensi-unverified">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Hari</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-riwabsensi-unverified"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="all">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class='input-group' id='search-riwabsensi-all-siswa'>
                                    <input type='text' class="form-control" placeholder="Select Date" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <div class="form-group">
                                    <button class="btn btn-info btn-icon" id="btn-search-riwabsensi-all" type="button" onclick="searchRiAbsensiAll('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-riwabsensi-all">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Hari</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-riwabsensi-all"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-search-riwabsensi-unverif, #btn-search-riwabsensi-all').click();
    });

    function verifAbsensi(absensi_id) {
        $.ajax({
            url: 'classes/RiwayatAbsensi.php',
            type: 'POST',
            data: {
                absensi_id: absensi_id,
                action: 'verif'
            },
            success: function(data) {
                let res = JSON.parse(data);
                swal({
                    title: res.title,
                    text: res.message,
                    icon: res.status,
                    button: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                })
            }
        });
    }

    function searchRiAbsensiUnverif(pembimbing_id) {
        $('#table-riwabsensi-unverified').DataTable().destroy();
        let search = $('#search-riwabsensi-unverif-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-absensi-unverif-pembimbing-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                pembimbing_id: pembimbing_id,
                action: 'searchAbsensiUnverif'
            },
            beforeSend: function() {
                $('#list-riwabsensi-unverified').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#list-riwabsensi-unverified').html(response);
                $('#table-riwabsensi-unverified').DataTable({
                    paging: true,
                    searching: false,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Riwayat Absensi Siswa Belum Diverifikasi',

                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Riwayat Absensi Siswa Belum Diverifikasi',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Riwayat Absensi Siswa Belum Diverifikasi',
                        }
                    ]
                });
            }
        });
    }

    function searchRiAbsensiAll(pembimbing_id) {
        $('#table-riwabsensi-all').DataTable().destroy();
        let search = $('#search-riwabsensi-all-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-absensi-all-pembimbing-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                pembimbing_id: pembimbing_id,
                action: 'searchAbsensiAll'
            },
            beforeSend: function() {
                $('#list-riwabsensi-all').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#list-riwabsensi-all').html(response);
                $('#table-riwabsensi-all').DataTable({
                    paging: true,
                    searching: false,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Riwayat Absensi Siswa',

                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Riwayat Absensi Siswa',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Riwayat Absensi Siswa',
                        }
                    ]
                });
            }
        });
    }
</script>