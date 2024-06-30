<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Log Book</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=logbook">Logbook Siswa</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/Logbook.php';

$logbook = new Logbook();
$logbook = $logbook->getLogbookTodayBySiswaId($_SESSION['the_id']);
// echo '<pre>';
// print_r($logbook);
// echo '</pre>';
?>
<div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-uppercase" id="logbook-tab" data-bs-toggle="tab" href="#logbook" role="tab" aria-controls="logbook" aria-selected="true">Logbook</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" id="riw_logbook-tab" data-bs-toggle="tab" href="#riw_logbook" role="tab" aria-controls="riw_logbook" aria-selected="false">Riwayat Logbook</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- [ user card1 ] start -->
            <div class="tab-pane fade show active" id="logbook" role="tabpanel" aria-labelledby="logbook-tab">
                <input type="hidden" name="status_logbook" id="status_logbook" value="<?= $logbook ? 'edit' : 'add' ?>">
                <?php if ($logbook) : ?>
                    <div class="row mb-4">
                        <div class="col-sm-7">
                            <label class="form-label" for="catatan-kegiatan">Catatan</label>
                            <textarea class="form-control" aria-describedby="catatan" id="catatan-kegiatan" onchange="cekCatatan()" rows="10"><?= $logbook['catatan'] ?></textarea>
                            <small id="catatan" class="form-text">*anda masih bisa melakukan edit untuk pengisian logbook dihari yang sama <br><span class="text-warning">Catatan : <b>waktu pengupdatean akan selalu terekam.</b></span></small>
                        </div>
                        <div class="col-sm-5 mt-4">
                            <div class="form-group">
                                <center>
                                    <img src="lampiran/logbook/<?= $logbook['lampiran'] ?>" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                </center>
                                <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <button class="btn btn-secondary col-md-12" id="btn-logbook" onclick="logBook('edit', '<?= $logbook['logbook_id'] ?>', '<?= $logbook['lampiran'] ?>')">Update</button>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row mb-4">
                        <div class="col-sm-7">
                            <label class="form-label" for="catatan-kegiatan">Catatan</label>
                            <textarea class="form-control" id="catatan-kegiatan" onchange="cekCatatan()" rows="10"></textarea>
                        </div>
                        <div class="col-sm-5 mt-4">
                            <div class="form-group">
                                <center>
                                    <img src="assets/images/image-placeholder.jpg" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                </center>
                                <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <button class="btn btn-primary col-md-12" disabled id="btn-logbook" onclick="logBook('add')">Simpan</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- [ user card1 ] end -->
            <!-- varient [ 2 ][ cover shape ] card Start -->
            <div class="tab-pane fade" id="riw_logbook" role="tabpanel" aria-labelledby="riw_logbook-tab">
                <div class="row mb-4">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class='input-group' id='search-logbook-siswa'>
                            <input type='text' class="form-control" placeholder="Select Date" />
                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-1">
                        <div class="form-group">
                            <button class="btn btn-info btn-icon" id="btn-search-logbook" type="button" onclick="contentRiwayatLogbook('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mb-4" id="list-logbook"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-search-logbook').click();
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
            let catatan = $('#catatan-kegiatan').val();
            let status_logbook = $('#status_logbook').val();
            if (status_logbook == 'add') {
                if (catatan != '') {
                    $('#btn-logbook').attr('disabled', false);
                }
            }
        }
    }

    function cekCatatan() {
        let catatan = $('#catatan-kegiatan').val();
        let foto = $('#foto').prop('files')[0];
        let status_logbook = $('#status_logbook').val();
        if (status_logbook == 'add') {
            if (catatan != '' && foto != undefined) {
                $('#btn-logbook').attr('disabled', false);
            } else {
                $('#btn-logbook').attr('disabled', true);
            }
        }
    }

    function logBook(status, logbook_id = '', lampiran_lama = '') {
        let foto = $('#foto').prop('files')[0];
        let catatan = $('#catatan-kegiatan').val();
        let form_data = new FormData();
        form_data.append('foto', foto);
        form_data.append('action', `writeLogbook`);
        form_data.append('catatan', catatan);
        form_data.append('logbook_id', logbook_id);
        form_data.append('lampiran_lama', lampiran_lama);
        form_data.append('status', status);
        $.ajax({
            url: 'classes/Logbook.php',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
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

    function contentRiwayatLogbook(siswa_id) {
        let search = $('#search-logbook-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-logbook-siswa-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                siswa_id: siswa_id,
                action: 'searchLogbook'
            },
            success: function(response) {
                $('#list-logbook').html(response);
            }
        });
    }
</script>