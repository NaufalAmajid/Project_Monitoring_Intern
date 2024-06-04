<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/LaporanLogbook.php';

$siswa_id = $_POST['siswa_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$logbook = new LaporanLogbook();
$logbookSiswa = $logbook->getAllLogbookBySiswaId($siswa_id, $tgl1, $tgl2);
$func = new Functions();
$no = 1;
?>

<?php foreach ($logbookSiswa as $logbook) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $func->dateIndonesia($logbook['hari']) ?> <?= $logbook['jam'] ?></td>
        <td><textarea rows="3" readonly><?= $logbook['catatan'] ?></textarea></td>
        <td>
            <?php if ($logbook['lampiran'] != '') : ?>
                <a href="lampiran/logbook/<?= $logbook['lampiran'] ?>" target="_blank">Lihat Lampiran</a>
            <?php else : ?>
                -
            <?php endif; ?>
        </td>
        <td>
            <?php if ($logbook['is_verified'] == 0) : ?>
                <span class="badge rounded-pill text-bg-primary">Belum Diverifikasi</span>
            <?php else : ?>
                <span class="badge rounded-pill text-bg-success">Sudah Diverifikasi</span>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>