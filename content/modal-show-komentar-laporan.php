<?php
require_once '../classes/Siswa.php';
$siswa_id = $_POST['siswa_id'];
$komentar = $siswa->getSiswaById($siswa_id);
?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Komentar Logbook
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <form id="form-komentar">
                    <div class="mb-2">
                        <center>
                            <img src="assets/images/laporan-placeholder.png" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail mb-3" style="width: 120px; height: 100px;">
                            <?php if (is_null($komentar['revisi_laporan'])) : ?>
                                <label for="file_revisi" id="label-laporan">Upload Revisi Laporan</label>
                            <?php else : ?>
                                <label for="file_revisi" id="label-laporan"><a href="lampiran/revisian/<?= $komentar['revisi_laporan'] ?>" target="_blank"><?= $komentar['revisi_laporan'] ?></a></label>
                            <?php endif; ?>
                        </center>
                        <input type="file" class="form-control d-none" onchange="displayFile(this)" id="file_revisi" name="file_revisi">
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3"><?= $komentar['komentar'] ?></textarea>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveKomentar('<?= $siswa_id ?>')">Simpan</button>
        </div>
    </div>
</div>
<script>
    function triggerClick(e) {
        document.querySelector('#file_revisi').click();
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
                    document.querySelector('#file_revisi').value = '';
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
                document.querySelector('#file_revisi').value = '';
                document.querySelector('#image-placeholder').src = 'assets/images/laporan-placeholder.png';
            });
        }
    }

    function saveKomentar(siswa_id) {
        var file_revisi = $('#file_revisi').prop('files')[0];
        var komentar = $('#komentar').val();
        var formData = new FormData();
        formData.append('siswa_id', siswa_id);
        formData.append('komentar', komentar);
        formData.append('file_revisi', file_revisi);
        formData.append('action', 'saveKomentar');
        $.ajax({
            url: 'classes/Siswa.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                // let res = JSON.parse(response);
                // swal({
                //     title: res.title,
                //     text: res.message,
                //     icon: res.status,
                //     button: false,
                //     timer: 2000
                // })
            }
        });
    }
</script>