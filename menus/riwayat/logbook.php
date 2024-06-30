<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan & Riwayat Logbook Siswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=riwayat&sub=logbook">Laporan & Riwayat Logbook</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
include 'classes/RiwayatLogbook.php';
$riwayatLogbook = new RiwayatLogbook();
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
                            <table class="table table-striped" id="table-riwlogbook-today">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Hari</th>
                                        <th>Catatan</th>
                                        <th>Lampiran</th>
                                        <th>Catatan Logbook</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $riwayatLogbookToday = $riwayatLogbook->getLogbookSiswaToday($_SESSION['the_id']);
                                    $no = 1;
                                    ?>
                                    <?php foreach ($riwayatLogbookToday as $today) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $today['nama_siswa'] ?></td>
                                            <td><?= $today['nis'] ?></td>
                                            <td><?= $today['nama_kelas'] ?></td>
                                            <td><?= $today['nama_jurusan'] ?></td>
                                            <td><?= $func->dateIndonesia($today['hari']) . ' ' . $today['jam'] ?></td>
                                            <td><textarea rows="3" readonly><?= $today['catatan'] ?></textarea></td>
                                            <td>
                                                <?php
                                                $lampirans = json_decode($today['lampiran'], true);
                                                $lampiran = implode('#', $lampirans);
                                                ?>
                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-secondary" onclick="showModalLampiran('<?= $lampiran ?>')"><i class="feather icon-camera"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-info" onclick="showModalKomentar('<?= $today['logbook_id'] ?>')"><i class="feather icon-edit"></i></button>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch custom-switch-v1 mb-2">
                                                    <input type="checkbox" class="form-check-input input-info custom-control-input" id="customswitchv2-6" <?= $today['is_verified'] == 1 ? 'checked disabled' : '' ?> onchange="verifLogbook('<?= $today['logbook_id'] ?>')">
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
                                <div class='input-group' id='search-riwlogbook-unverif-siswa'>
                                    <input type='text' class="form-control" placeholder="Select Date" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <div class="form-group">
                                    <button class="btn btn-info btn-icon" id="btn-search-riwlogbook-unverif" type="button" onclick="searchRiLogbookUnverif('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-riwlogbook-unverified">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Hari</th>
                                        <th>Catatan</th>
                                        <th>Lampiran</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-riwlogbook-unverified"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="all">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class='input-group' id='search-riwlogbook-all-siswa'>
                                    <input type='text' class="form-control" placeholder="Select Date" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <div class="form-group">
                                    <button class="btn btn-info btn-icon" id="btn-search-riwlogbook-all" type="button" onclick="searchRiLogbookAll('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-riwlogbook-all">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Hari</th>
                                        <th>Catatan</th>
                                        <th>Lampiran</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-riwlogbook-all"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-show-lampiran-logbook" class="modal fade modal-lg"></div>
<script>
    $(document).ready(function() {
        $('#btn-search-riwlogbook-unverif, #btn-search-riwlogbook-all').click();
        $('#table-riwlogbook-today').DataTable({
            paging: true,
            searching: true,
            info: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Data Riwayat Logbook Siswa Hari Ini',

                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Data Riwayat Logbook Siswa Hari Ini',
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: 'Data Riwayat Logbook Siswa Hari Ini',
                }
            ]
        });
    });

    function verifLogbook(logbook_id) {
        $.ajax({
            url: 'classes/RiwayatLogbook.php',
            type: 'POST',
            data: {
                logbook_id: logbook_id,
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

    function searchRiLogbookUnverif(pembimbing_id) {
        $('#table-riwlogbook-unverified').DataTable().destroy();
        let search = $('#search-riwlogbook-unverif-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-logbook-unverif-pembimbing-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                pembimbing_id: pembimbing_id,
                action: 'searchLogbookUnverif'
            },
            beforeSend: function() {
                $('#list-riwlogbook-unverified').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#list-riwlogbook-unverified').html(response);
                $('#table-riwlogbook-unverified').DataTable({
                    paging: true,
                    searching: false,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Riwayat Logbook Siswa Belum Diverifikasi',

                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Riwayat Logbook Siswa Belum Diverifikasi',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Riwayat Logbook Siswa Belum Diverifikasi',
                        }
                    ]
                });
            }
        });
    }

    function searchRiLogbookAll(pembimbing_id) {
        $('#table-riwlogbook-all').DataTable().destroy();
        let search = $('#search-riwlogbook-all-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-riwlogbook-all-pembimbing-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                pembimbing_id: pembimbing_id,
                action: 'searchLogbookAll'
            },
            beforeSend: function() {
                $('#list-riwlogbook-all').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#list-riwlogbook-all').html(response);
                $('#table-riwlogbook-all').DataTable({
                    paging: true,
                    searching: false,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Riwayat Logbook Siswa',

                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Riwayat Logbook Siswa',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Riwayat Logbook Siswa',
                        }
                    ]
                });
            }
        });
    }

    function showModalLampiran(lampiran) {
        $.ajax({
            url: 'content/modal-show-lampiran-logbook.php',
            type: 'post',
            data: {
                lampiran: lampiran
            },
            success: function(response) {
                $('#modal-show-lampiran-logbook').html(response);
                $('#modal-show-lampiran-logbook').modal('show');
            }
        });
    }

    function showModalKomentar(logbook_id) {
        $.ajax({
            url: 'content/modal-show-komentar-logbook.php',
            type: 'post',
            data: {
                logbook_id: logbook_id,
                action: 'showKomentar'
            },
            success: function(response) {
                $('#modal-show-lampiran-logbook').html(response);
                $('#modal-show-lampiran-logbook').modal('show');
            }
        });
    }
</script>