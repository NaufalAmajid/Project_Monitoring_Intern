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
// echo '<pre>';
// print_r($absensi);
// echo '</pre>';
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
                                        <div class="form-group">
                                            <center>
                                                <img src="assets/images/image-placeholder.jpg" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                            </center>
                                            <label for="foto">Bukti Absensi</label>
                                            <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                                        </div>
                                    </div>
                                    <?php if ($absensi) : ?>
                                        <button class="btn btn-warning col-md-12" id="btn-absensi" disabled type="button" onclick="absensiSiswa('keluar')">Keluar</button>
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
                                                <div style="font-size: 10px;"><a href=""><i class="feather icon-grid"></i> foto</a>
                                            </th>
                                            <th>
                                                <div><?= $absensi['keluar'] ?></div>
                                                <div style="font-size: 10px;"><a href=""><i class="feather icon-grid"></i> foto</a>
                                            </th>
                                            <th><button class="btn btn-sm btn-info" type="button"><i class="feather icon-back"></i></button></th>
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
                <div class="row mb-n4">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Picture</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
    document.querySelector('#foto').addEventListener('change', function() {
        displayImage(this);
    });

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
</script>