<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/RiwayatLogbook.php';

$pembimbing_id = $_POST['pembimbing_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$riwayatLogbook = new RiwayatLogbook();
$riwayatLogbookUnverif = $riwayatLogbook->getLogbookSiswaUnverified($pembimbing_id, $tgl1, $tgl2);
$func = new Functions();
$no = 1;
?>
<?php foreach ($riwayatLogbookUnverif as $unverif) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $unverif['nama_siswa'] ?></td>
        <td><?= $unverif['nis'] ?></td>
        <td><?= $unverif['nama_kelas'] ?></td>
        <td><?= $unverif['nama_jurusan'] ?></td>
        <td><?= $func->dateIndonesia($unverif['hari']) . ' ' . $unverif['jam'] ?></td>
        <td><textarea rows="3" readonly><?= $unverif['catatan'] ?></textarea></td>
        <td>
            <?php
            $lampirans = json_decode($unverif['lampiran'], true);
            $lampiran = implode('#', $lampirans);
            ?>
            <button type="button" class="btn btn-icon btn-rounded btn-outline-secondary" onclick="showModalLampiran('<?= $lampiran ?>')"><i class="feather icon-camera"></i></button>
        </td>
        <td>
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-info custom-control-input" id="customswitchv2-6" <?= $unverif['is_verified'] == 1 ? 'checked disabled' : '' ?> onchange="verifLogbook('<?= $unverif['logbook_id'] ?>')">
                <label class="form-check-label align-text-top" for="customswitchv2-6"><?= $unverif['is_verified'] == 1 ? 'Terverifikasi' : 'Belum diverifikasi' ?></label>
            </div>
        </td>
    </tr>
<?php endforeach; ?>