<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/RiwayatAbsensi.php';

$pembimbing_id = $_POST['pembimbing_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$riwayatAbsensi = new RiwayatAbsensi();
$riwayatAbsensiAll = $riwayatAbsensi->getAbsensiSiswaAll($pembimbing_id, $tgl1, $tgl2);
$func = new Functions();
$no = 1;
?>
<?php foreach ($riwayatAbsensiAll as $all) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $all['nama_siswa'] ?></td>
        <td><?= $all['nis'] ?></td>
        <td><?= $all['nama_kelas'] ?></td>
        <td><?= $all['nama_jurusan'] ?></td>
        <td><?= $func->dateIndonesia($all['hari']) ?></td>
        <td>
            <center>
                <div><?= $all['masuk'] ?></div>
                <div>
                    <img src="lampiran/absensi/<?= $all['lampiran_masuk'] ?>" alt="<?= $all['lampiran_masuk'] ?>" class="img-thumbnail">
                </div>
            </center>
        </td>
        <td>
            <center>
                <div><?= $all['keluar'] ?></div>
                <?php if ($all['lampiran_keluar']) : ?>
                    <div>
                        <img src="lampiran/absensi/<?= $all['lampiran_keluar'] ?>" alt="<?= $all['lampiran_masuk'] ?>" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </center>
        </td>
        <td>
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-info custom-control-input" id="customswitchv2-6" <?= $all['is_verified'] == 1 ? 'checked disabled' : '' ?> onchange="verifAbsensi('<?= $all['absensi_id'] ?>')">
                <label class="form-check-label align-text-top" for="customswitchv2-6"><?= $all['is_verified'] == 1 ? 'Terverifikasi' : 'Belum diverifikasi' ?></label>
            </div>
        </td>
    </tr>
<?php endforeach; ?>