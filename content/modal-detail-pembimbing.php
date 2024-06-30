<?php
$pembimbing_id = $_POST['pembimbing_id'];
if ($pembimbing_id != 0) {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    require_once '../classes/Pembimbing.php';
    $pembimbing = new Pembimbing();
    $pembimbing = $pembimbing->getPembimbingById($pembimbing_id);
} else {
    $pembimbing = [];
}

?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"><?= ucwords($_POST['action']) ?> Pembimbing
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form-pembimbing">
                <input type="hidden" name="action" value="<?= $_POST['action'] == 'edit' ? 'update' : $_POST['action'] ?>">
                <input type="hidden" name="pembimbing_id" value="<?= $_POST['pembimbing_id'] ?>">
                <input type="hidden" name="user_id" value="<?= $pembimbing_id != 0 ? $pembimbing['user_id'] : 0 ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username" value="<?= $pembimbing_id != 0 ? $pembimbing['username'] : '' ?>" name="username" aria-describedby="emailHelp" placeholder="Masukkan username ...">
                            <small id="emailHelp" class="form-text text-muted">username digunakan untuk login.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" value="<?= $pembimbing_id != 0 ? $pembimbing['email'] : '' ?>" name="email" id="email" placeholder="Masukkan email ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" aria-describedby="passwordHelp" name="password" id="password" value="123" <?= $pembimbing_id != 0 ? 'disabled' : '' ?>>
                            <small id="passwordHelp" class="form-text text-danger">password default 123.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $pembimbing_id != 0 ? $pembimbing['nama_lengkap'] : '' ?>" id="nama_lengkap" placeholder="Masukkan nama lengkap ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="no">No</label>
                            <input type="text" class="form-control" name="no" id="no" placeholder="Masukkan nomer ..." value="<?= $pembimbing_id != 0 ? $pembimbing['no'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" aria-label="Default select example">
                                <option value="">Pilih jenis kelamin ...</option>
                                <option value="Laki-laki" <?= $pembimbing_id != 0 && $pembimbing['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $pembimbing_id != 0 && $pembimbing['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="savePembimbing()"><?= ucwords($_POST['action']) ?></button>
        </div>
    </div>
</div>