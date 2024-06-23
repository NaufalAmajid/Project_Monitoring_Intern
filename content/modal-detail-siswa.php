<?php
$siswa_id = $_POST['siswa_id'];
require_once '../config/database.php';
require_once '../classes/DB.php';
require_once '../classes/Siswa.php';
$siswa = new Siswa();
$jurusan = $siswa->getAllJurusan();
if ($siswa_id != 0) {
    $detailSiswa = $siswa->getSiswaById($siswa_id);
} else {
    $siswa = [];
}

?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"><?= ucwords($_POST['action']) ?> Siswa
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form-siswa">
                <input type="hidden" name="action" value="<?= $_POST['action'] == 'edit' ? 'update' : 'add' ?>">
                <input type="hidden" name="siswa_id" value="<?= $_POST['siswa_id'] ?>">
                <input type="hidden" name="user_id" value="<?= $siswa_id != 0 ? $detailSiswa['user_id'] : 0 ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username" value="<?= $siswa_id != 0 ? $detailSiswa['username'] : '' ?>" name="username" aria-describedby="emailHelp" placeholder="Masukkan username ...">
                            <small id="emailHelp" class="form-text text-muted">username digunakan untuk login.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" value="<?= $siswa_id != 0 ? $detailSiswa['email'] : '' ?>" name="email" id="email" placeholder="Masukkan email ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" aria-describedby="passwordHelp" name="password" id="password" value="123" <?= $siswa_id != 0 ? 'disabled' : '' ?>>
                            <small id="passwordHelp" class="form-text text-danger">password default 123.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $siswa_id != 0 ? $detailSiswa['nama_siswa'] : '' ?>" id="nama_lengkap" placeholder="Masukkan nama lengkap ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="no">No</label>
                            <input type="text" class="form-control" name="no" id="no" placeholder="Masukkan nomer ..." value="<?= $siswa_id != 0 ? $detailSiswa['no'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" aria-label="Default select example">
                                <option value="">Pilih jenis kelamin ...</option>
                                <option value="Laki-laki" <?= $siswa_id != 0 && $detailSiswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $siswa_id != 0 && $detailSiswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="nis">Nis</label>
                            <input type="text" class="form-control" name="nis" id="nis" value="<?= $siswa_id != 0 ? $detailSiswa['nis'] : '' ?>" placeholder="Masukkan nis ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="tempat_pkl">Tempat PKL</label>
                            <input type="text" class="form-control" name="tempat_pkl" id="tempat_pkl" value="<?= $siswa_id != 0 ? $detailSiswa['tempat_pkl'] : '' ?>" placeholder="Masukkan tempat pkl ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="pimpinan_pkl">Pimpinan PKL</label>
                            <input type="text" class="form-control" name="pimpinan_pkl" id="pimpinan_pkl" value="<?= $siswa_id != 0 ? $detailSiswa['pimpinan_pkl'] : '' ?>" placeholder="Masukkan pemimpin pkl ...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="kelas_id">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" aria-label="Default select example" onchange="pilihKelas(this)">
                                <option value="">Pilih kelas ...</option>
                                <?php foreach ($jurusan as $jur) : ?>
                                    <optgroup label="<?= $jur['nama_jurusan'] ?>">
                                        <?php foreach ($jur['kelas'] as $kel) : ?>
                                            <option value="<?= $kel['kelas_id'] ?>" <?= $siswa_id != 0 && $detailSiswa['kelas_id'] == $kel['kelas_id'] ? 'selected' : '' ?> data-pembimbing="<?= $kel['nama_pembimbing'] ?>"><?= $kel['nama_kelas'] ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="jurusan">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" id="jurusan" value="<?= $siswa_id != 0 ? $detailSiswa['nama_jurusan'] : '' ?>" placeholder="Pilih Kelas Terlebih Dahulu ..." readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="pembimbing">Pembimbing</label>
                            <input type="text" class="form-control" name="pembimbing" id="pembimbing" value="<?= $siswa_id != 0 ? $detailSiswa['nama_pembimbing'] : '' ?>" placeholder="Pilih Kelas Terlebih Dahulu ..." readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveSiswa()"><?= ucwords($_POST['action']) ?></button>
        </div>
    </div>
</div>
<script>
    function pilihKelas(e) {
        var kelas_id = $(e).find(':selected').val();
        if (kelas_id != '') {
            $('#jurusan').val($(e).find(':selected').parent().attr('label'));
            $('#pembimbing').val($(e).find(':selected').attr('data-pembimbing'));
        } else {
            $('#jurusan').val('');
            $('#pembimbing').val('');
        }
    }
</script>