<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan PKL</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=laporan&sub=laporan_pkl">Laporan PKL</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/LaporanPKL.php';
$laporanPKL = new LaporanPKL();

$dataSiswa = $laporanPKL->getSiswaById($_SESSION['the_id']);
?>
<div class="row mb-n4 mt-4 justify-content-center">
    <div class="col-sm-12 col-md-4">
        <div class="card text-center">
            <div class="card-body shadow-2">
                <h5 class="card-title mb-3">Laporan PKL</h5>
                <?php if ($dataSiswa['selesai_pkl'] == 1) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (is_null($dataSiswa['laporan'])) : ?>
                                <div class="form-group">
                                    <center>
                                        <img src="assets/images/laporan-placeholder.png" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                                    </center>
                                    <label for="file_laporan" id="label-laporan">Upload Laporan Diatas</label>
                                    <input type="file" class="form-control d-none" onchange="displayFile(this)" id="file_laporan" name="file_laporan">
                                </div>
                                <button class="btn btn-primary col-md-12" id="btn-upload-laporan" type="button" onclick="laporanPKLSiswa()">Kumpulkan</button>
                            <?php else : ?>
                                <div class="form-group">
                                    <center>
                                        <img src="assets/images/laporan_selesai.png" alt="image-placeholder" id="laporan-selesai" class="img-thumbnail">
                                    </center>
                                    <span>File Laporan PKL Sudah DiUpload</span>
                                    <br>
                                    <a href="lampiran/laporan/<?= $dataSiswa['laporan'] ?>" target="_blank"><i class="feather icon-link"></i> Lihat Laporan</a>
                                </div>
                                <button class="btn btn-info col-md-12" id="btn-upload-laporan" type="button" onclick="uploadUlang('<?= $dataSiswa['laporan'] ?>', '<?= $_SESSION['the_id'] ?>')">Upload Ulang</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <center>
                            <h5>Anda belum bisa upload file laporan, Silahkan hubungi pembimbing anda agar melakukan update status PKL anda.</h5>
                        </center>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function triggerClick(e) {
        document.querySelector('#file_laporan').click();
    }

    function displayFile(e) {
        //just file .pdf or .docx or .doc allowed
        if (e.files[0].type == 'application/pdf' || e.files[0].type == 'application/msword' || e.files[0].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            if (e.files[0].size > 10000000) {
                swal({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Ukuran file maksimal 10MB',
                    timer: 2000
                }).then(() => {
                    document.querySelector('#file_laporan').value = '';
                    document.querySelector('#image-placeholder').src = 'assets/images/laporan-placeholder.png';
                });
            } else {
                //if file .pdf display pdf icon else display word icon
                if (e.files[0].type == 'application/pdf') {
                    document.querySelector('#image-placeholder').src = 'assets/images/pdf-icon.png';
                    document.querySelector('#label-laporan').innerHTML = e.files[0].name;
                } else {
                    document.querySelector('#image-placeholder').src = 'assets/images/word-icon.png';
                    document.querySelector('#label-laporan').innerHTML = e.files[0].name;
                }
            }
        } else {
            swal({
                icon: 'error',
                title: 'Gagal',
                text: 'File yang diupload harus berformat .pdf, .docx, atau .doc',
            }).then(() => {
                document.querySelector('#file_laporan').value = '';
                document.querySelector('#image-placeholder').src = 'assets/images/laporan-placeholder.png';
            });
        }
    }

    function laporanPKLSiswa() {
        var file = document.querySelector('#file_laporan').files[0];
        var formData = new FormData();
        formData.append('file_laporan', file)
        formData.append('action', 'addLaporan');

        $.ajax({
            url: 'classes/LaporanPKL.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let res = JSON.parse(response);
                notifier.show(
                    `${res.title}`,
                    `${res.msg}`,
                    `${res.status}`,
                    `${res.icon}`,
                    3000
                );
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        });
    }

    function uploadUlang(file, siswa_id) {
        $.ajax({
            url: 'classes/LaporanPKL.php',
            type: 'POST',
            data: {
                file_laporan: file,
                siswa_id: siswa_id,
                action: 'reupload'
            },
            success: function(response) {
                let res = JSON.parse(response);
                notifier.show(
                    `${res.title}`,
                    `${res.msg}`,
                    `${res.status}`,
                    `${res.icon}`,
                    3000
                );
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        });
    }
</script>