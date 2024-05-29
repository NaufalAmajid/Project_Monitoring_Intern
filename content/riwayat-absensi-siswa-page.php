<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/Absensi.php';

$siswa_id = $_POST['siswa_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$absensi = new Absensi();
$absensiSiswa = $absensi->getAllAbsensiBySiswaId($siswa_id, $tgl1, $tgl2);
$func = new Functions();
$no = 1;
?>

<?php foreach ($absensiSiswa as $absensi) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $func->dateIndonesia($absensi['hari']) ?></td>
        <td>
            <center>
                <div><?= $absensi['masuk'] ?></div>
                <div>
                    <img src="lampiran/absensi/<?= $absensi['lampiran_masuk'] ?>" alt="<?= $absensi['lampiran_masuk'] ?>" class="img-thumbnail">
                </div>
            </center>
        </td>
        <td>
            <center>
                <div><?= $absensi['keluar'] ?></div>
                <div>
                    <img src="lampiran/absensi/<?= $absensi['lampiran_keluar'] ?>" alt="<?= $absensi['lampiran_keluar'] ?>" class="img-thumbnail">
                </div>
            </center>
        </td>
        <td>
            <?php if ($absensi['is_verified'] == 0) : ?>
                <span class="badge rounded-pill text-bg-primary">Belum Diverifikasi</span>
            <?php else : ?>
                <span class="badge rounded-pill text-bg-success">Sudah Diverifikasi</span>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>