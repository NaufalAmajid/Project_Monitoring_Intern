<?php
require_once '../config/database.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/Logbook.php';

$siswa_id = $_POST['siswa_id'];
$tgl1 = $_POST['tgl1'] == '' ? date('Y-m-d') : $_POST['tgl1'];
$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : date('Y-m-d');
$logbook = new Logbook();
$logbookSiswa = $logbook->getAllLogbookBySiswaId($siswa_id, $tgl1, $tgl2);
$func = new Functions();
?>
<div class="col-sm-12">
    <h5 class="mb-3">Riwayat Logbook</h5>
    <span><?= $func->dateIndonesia($tgl1) ?> - <?= $func->dateIndonesia($tgl2) ?></span>
    <hr>
    <div class="accordion" id="accordionExample">
        <?php foreach ($logbookSiswa as $log) : ?>
            <div class="card shadow-2">
                <div class="card-header" id="heading_<?= $log['logbook_id']; ?>">
                    <div class="header-logbook">
                        <div class="title-logbook">
                            <h5 class="mb-0"><a href="#!" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $log['logbook_id']; ?>" aria-expanded="true" aria-controls="collapse_<?= $log['logbook_id']; ?>"><?= $func->dateIndonesia($log['hari']) ?> <?= $log['jam'] ?></a></h5>
                        </div>
                        <div class="status-logbook">
                            <?php if ($log['is_verified'] == 1) : ?>
                                <span class="badge badge-light-info">Terverifikasi</span>
                            <?php else : ?>
                                <span class="badge badge-light-secondary">Belum Diverifikasi</span>
                            <?php endif; ?>
                        </div>
                        <div class="komentar-logbook">
                            <?php if (!is_null($log['komentar'])) : ?>
                                <span class="badge badge-light-danger">Terdapat Catatan Dari Pembimbing</span>
                            <?php else : ?>
                                <span class="badge badge-light-success"><i class="feather icon-check"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div id="collapse_<?= $log['logbook_id']; ?>" class="card-body collapse" aria-labelledby="heading_<?= $log['logbook_id']; ?>" data-bs-parent="#accordionExample">
                    <div class="row mb-3">
                        <div class="col-lg-6 mb-3">
                            <p><?= $log['catatan'] ?></p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="row">
                                <?php
                                $lampirans = json_decode($log['lampiran']);
                                ?>
                                <?php foreach ($lampirans as $lampiran) : ?>
                                    <div class="col-lg-4 mb-3">
                                        <a href="lampiran/logbook/<?= $lampiran ?>" target="_blank">
                                            <img src="lampiran/logbook/<?= $lampiran ?>" class="img-thumbnail" alt="lampiran" style="width: 100%; height: 100px;">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Catatan Pembimbing</legend>
                            <div class="row">
                                <p><?= $log['komentar'] ?></p>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>