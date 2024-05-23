<?php
require_once '../config/database.php';
require_once '../classes/DB.php';
require_once '../classes/Jurusan.php';
require_once '../classes/Pembimbing.php';

$jurusan = new Jurusan();
$jurusans = $jurusan->getAllJurusan($_GET['search']);

$pembimbing = new Pembimbing();
$pembimbings = $pembimbing->getAllPembimbing();
?>
<div class="row">
    <?php foreach ($jurusans as $jurusan_id => $jurusan) : ?>
        <div class="col-sm-4">
            <div class="card shadow-2">
                <div class="card-header <?= $jurusan['is_active'] == 0 ? 'bg-danger' : '' ?>">
                    <h5><input type="text" class="input-without-border" size="<?= strlen($jurusan['nama_jurusan']) ?>" value="<?= $jurusan['nama_jurusan'] ?>" id="nama_jurusan_<?= $jurusan_id ?>" onchange="editJurusan(this, '<?= $jurusan_id ?>')"></h5>
                    <div class="card-header-right">
                        <div class="form-check form-switch custom-switch-v1 mt-2">
                            <input type="checkbox" class="form-check-input input-success custom-control-input" onchange="editAktifJurusan(this, '<?= $jurusan_id ?>')" value="<?= $jurusan['is_active'] ?>" id="switch-<?= $jurusan_id ?>" <?= $jurusan['is_active'] == 1 ? 'checked' : '' ?>>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div class="stock-scroll" style="height:386px;position:relative;">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <th>Pembimbing</th>
                                        <th>Jumlah Siswa</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($jurusan['kelas'])) : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php
                                        $no = 1;
                                        foreach ($jurusan['kelas'] as $kelas) : ?>
                                            <tr>
                                                <td><input type="text" class="input-border-bottom" id="nama_kelas_<?= $kelas['kelas_id'] ?>" size="<?= strlen($kelas['nama_kelas']) ?>" value="<?= $kelas['nama_kelas'] ?>" onchange="editKelas('<?= $kelas['kelas_id'] ?>')" <?= $jurusan['is_active'] == 0 ? 'disabled' : '' ?>></td>
                                                <td>
                                                    <select class="select-without-border" id="pembimbing_<?= $kelas['kelas_id'] ?>" onchange="editKelas('<?= $kelas['kelas_id'] ?>')" <?= $jurusan['is_active'] == 0 ? 'disabled' : '' ?>>
                                                        <?php foreach ($pembimbings as $pembimbing) : ?>
                                                            <option value="<?= $pembimbing['pembimbing_id'] ?>" <?= $kelas['pembimbing_id'] == $pembimbing['pembimbing_id'] ? 'selected' : '' ?>><?= $pembimbing['nama_lengkap'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td align="center"><?= $kelas['jumlah_siswa'] ?></td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input input-info" <?= $jurusan['is_active'] == 0 ? 'disabled' : '' ?> id="switch-<?= $kelas['kelas_id'] ?>" value="<?= $kelas['is_active'] ?>" onchange="editAktifKelas(this, '<?= $kelas['kelas_id'] ?>')" <?= $kelas['is_active'] == 1 ? 'checked' : '' ?>>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="right-icon-control <?= $jurusan['is_active'] == 0 ? 'd-none' : '' ?>">
                        <div class="input-group">
                            <select class="form-control form-control-lg" id="pembimbing_<?= $jurusan_id ?>">
                                <option value="">Pilih Pembimbing</option>
                                <?php foreach ($pembimbings as $pembimbing) : ?>
                                    <option value="<?= $pembimbing['pembimbing_id'] ?>"><?= $pembimbing['nama_lengkap'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="nama_kelas_baru_<?= $jurusan_id ?>" placeholder="Tambah Kelas">
                            <button class="btn btn-primary" type="button" onclick="tambahKelas('<?= $jurusan_id ?>')"><i class="feather icon-plus m-0"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>