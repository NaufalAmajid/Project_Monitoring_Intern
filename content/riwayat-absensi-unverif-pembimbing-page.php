<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/RiwayatAbsensi.php';

$pembimbing_id = $_POST['pembimbing_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$riwayatAbsensi = new RiwayatAbsensi();
$riwayatAbsensiUnverif = $riwayatAbsensi->getAbsensiSiswaUnverif($pembimbing_id, $tgl1, $tgl2);
$func = new Functions();
$no = 1;
?>
<?php foreach ($riwayatAbsensiUnverif as $unverif) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $unverif['nama_siswa'] ?></td>
        <td><?= $unverif['nis'] ?></td>
        <td><?= $unverif['nama_kelas'] ?></td>
        <td><?= $unverif['nama_jurusan'] ?></td>
        <td><?= $func->dateIndonesia($unverif['hari']) ?></td>
        <td>
            <center>
                <div><?= $unverif['masuk'] ?></div>
                <div>
                    <img src="lampiran/absensi/<?= $unverif['lampiran_masuk'] ?>" alt="<?= $unverif['lampiran_masuk'] ?>" class="img-thumbnail">
                </div>
            </center>
        </td>
        <td>
            <center>
                <div><?= $unverif['keluar'] ?></div>
                <?php if ($unverif['lampiran_keluar']) : ?>
                    <div>
                        <img src="lampiran/absensi/<?= $unverif['lampiran_keluar'] ?>" alt="<?= $unverif['lampiran_masuk'] ?>" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </center>
        </td>
        <td>
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-info custom-control-input" id="customswitchv2-6" <?= $unverif['is_verified'] == 1 ? 'checked disabled' : '' ?> onchange="verifAbsensi('<?= $unverif['absensi_id'] ?>')">
                <label class="form-check-label align-text-top" for="customswitchv2-6"><?= $unverif['is_verified'] == 1 ? 'Terverifikasi' : 'Belum diverifikasi' ?></label>
            </div>
        </td>
    </tr>
<?php endforeach; ?>