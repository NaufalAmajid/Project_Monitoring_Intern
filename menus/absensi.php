<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Absensi</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=absensi">Absensi Siswa</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/Absensi.php';

$absensi = new Absensi();
$absensi = $absensi->getAbsensiTodayBySiswaId($_SESSION['the_id']);
?>
<div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-uppercase" id="absensi-tab" data-bs-toggle="tab" href="#absensi" role="tab" aria-controls="absensi" aria-selected="true">Absensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" id="riw_absen-tab" data-bs-toggle="tab" href="#riw_absen" role="tab" aria-controls="riw_absen" aria-selected="false">Riwayat Absen</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- [ user card1 ] start -->
            <div class="tab-pane fade show active" id="absensi" role="tabpanel" aria-labelledby="absensi-tab">
                <div class="row mb-n4 mt-4 justify-content-center">
                    <div class="col-sm-12 col-md-4">
                        <div class="card text-center">
                            <div class="card-body shadow-2">
                                <h5 class="card-title mb-3">Absensi</h5>
                                <p class="card-text"><?= $func->dateIndonesia(date('Y-m-d')) ?></p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if ($absensi) : ?>
                                            <?php if (!$absensi['lampiran_keluar']) : ?>
                                                <div class="form-group">
                                                    <center>
                                                        <img src="assets/images/image-placeholder.jpg" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                                    </center>
                                                    <label for="foto">Bukti Absensi</label>
                                                    <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                                                </div>
                                            <?php else : ?>
                                                <div class="form-group">
                                                    <center>
                                                        <img src="assets/images/checklist_warning.png" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                                    </center>
                                                    <span class="text-muted">Anda sudah melakukan absensi untuk hari ini, Silahkan kembali lagi besok.</span>
                                                </div>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="form-group">
                                                <center>
                                                    <img src="assets/images/image-placeholder.jpg" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                                </center>
                                                <label for="foto">Bukti Absensi</label>
                                                <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($absensi) : ?>
                                        <?php if (!$absensi['lampiran_keluar']) : ?>
                                            <button class="btn btn-warning col-md-12" id="btn-absensi" disabled type="button" onclick="absensiSiswa('keluar')">Keluar</button>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <button class="btn btn-primary col-md-12" id="btn-absensi" disabled type="button" onclick="absensiSiswa('masuk')">Masuk</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($absensi) : ?>
                    <div class="row mt-4 justify-content-center">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><span class="mb-4"><?= $func->dateIndonesia($absensi['hari']) ?></span></th>
                                            <th>
                                                <div><?= $absensi['masuk'] ?></div>
                                                <div style="font-size: 10px;">
                                                    <a href="lampiran/absensi/<?= $absensi['lampiran_masuk'] ?>" target="_blank">
                                                        <i class="feather icon-link"></i> foto</a>
                                                </div>
                                            </th>
                                            <th>
                                                <div><?= $absensi['keluar'] ?></div>
                                                <?php if ($absensi['lampiran_keluar']) : ?>
                                                    <div style="font-size: 10px;">
                                                        <a href="lampiran/absensi/<?= $absensi['lampiran_keluar'] ?>" target="_blank">
                                                            <i class="feather icon-link"></i> foto</a>
                                                    </div>
                                                <?php endif; ?>
                                            </th>
                                            <th>
                                                <?php if (!$absensi['lampiran_keluar']) : ?>
                                                    <button type="button" class="btn btn-icon btn-rounded btn-outline-info" onclick="repeatAbsen('<?= $absensi['absensi_id'] ?>', '<?= $absensi['lampiran_masuk'] ?>')"><i class="feather icon-refresh-ccw"></i></button>
                                                <?php endif; ?>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- [ user card1 ] end -->
            <!-- varient [ 2 ][ cover shape ] card Start -->
            <div class="tab-pane fade" id="riw_absen" role="tabpanel" aria-labelledby="riw_absen-tab">
                <div class="row mb-4">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class='input-group' id='search-absensi-siswa'>
                            <input type='text' class="form-control" placeholder="Select Date" />
                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <div class="form-group">
                            <button class="btn btn-info btn-icon" id="btn-search-absensi" type="button" onclick="searchAbsensi('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mb-n4">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-list-riwayat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody id="list-riwayat"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-search-absensi').click();
    });

    function triggerClick(e) {
        document.querySelector('#foto').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#image-placeholder').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
            $('#btn-absensi').prop('disabled', false);
        }
    }

    function absensiSiswa(status) {
        let foto = $('#foto').prop('files')[0];
        let form_data = new FormData();
        form_data.append('foto', foto);
        form_data.append('action', 'absensiSiswa');
        form_data.append('status', status);
        $.ajax({
            url: 'classes/Absensi.php',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                let res = JSON.parse(response);
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

    function repeatAbsen(absensi_id, lampiran_masuk) {
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan mengulang absen",
            icon: "info",
            buttons: true,
            dangerMode: true,
        }).then((willLogout) => {
            if (willLogout) {
                $.ajax({
                    url: 'classes/Absensi.php',
                    type: 'post',
                    data: {
                        absensi_id: absensi_id,
                        lampiran_masuk: lampiran_masuk,
                        action: 'repeatAbsen'
                    },
                    success: function(response) {
                        if (response == 'success') {
                            swal("Berhasil!", "Silahkan mengulang absensi!", "info", {
                                button: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            swal("Gagal!", "Anda gagal mengulang", "error", {
                                button: false,
                                timer: 2000
                            });
                        }
                    }
                });
            } else {
                swal("Anda tidak jadi mengulang absensi", {
                    icon: "info",
                    button: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    function searchAbsensi(siswa_id) {
        $('#table-list-riwayat').DataTable().destroy();
        let search = $('#search-absensi-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-absensi-siswa-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                siswa_id: siswa_id,
                action: 'searchAbsensi'
            },
            beforeSend: function() {
                $('#list-riwayat').html('<tr><td colspan="5" class="text-center">Loading ...</td></tr>');
            },
            success: function(response) {
                $('#list-riwayat').html(response);
                $('#table-list-riwayat').DataTable();
            }
        });
    }
</script>