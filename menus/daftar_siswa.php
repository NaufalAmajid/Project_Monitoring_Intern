<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Daftar Siswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=daftar_siswa">List Daftar Siswa Pembimbing <?= ucwords($_SESSION['nama']) ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/DaftarSiswa.php';
$listSiswa = new DaftarSiswa();
$listSiswa = $listSiswa->getAllSiswaByPembimbingId($_SESSION['the_id']);
$no = 1;
?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header table-card-header">
            <h5>List Siswa Aktif</h5>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="table-daftar-siswa" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tempat PKL</th>
                            <th>Pimpinan PKL</th>
                            <th>Status PKL</th>
                            <th>Absensi <br> Terverifikasi</th>
                            <th>Absensi <br> Belum Diverifikasi</th>
                            <th>Logbook <br> Terverifikasi</th>
                            <th>Logbook <br> Belum Diverifikasi</th>
                            <th>Laporan PKL</th>
                            <th>Catatan Laporan</th>
                            <th>Verifikasi Laporan PKL</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listSiswa as $siswa) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $siswa['nama_siswa'] ?></td>
                                <td><?= $siswa['jenis_kelamin'] ?></td>
                                <td><?= $siswa['nis'] ?></td>
                                <td><?= $siswa['nama_kelas'] ?></td>
                                <td><?= $siswa['nama_jurusan'] ?></td>
                                <td><?= $siswa['tempat_pkl'] ?></td>
                                <td><?= $siswa['pimpinan_pkl'] ?></td>
                                <td>
                                    <?php if ($siswa['selesai_pkl'] == 1) : ?>
                                        <span class="badge badge-light-success">PKL Telah Selesai</span>
                                    <?php else : ?>
                                        <span class="badge badge-light-danger">PKL Belum Selesai</span>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input input-success" type="checkbox" id="status_pkl_<?= $siswa['siswa_id'] ?>" onchange="changeStatusPKL('<?= $siswa['siswa_id'] ?>')">
                                            <label class="form-check-label" for="status_pkl_<?= $siswa['siswa_id'] ?>">checklist disini untuk merubah status pkl siswa</label>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= $siswa['jumlah_absensi_verified'] ?></td>
                                <td class="bg-danger"><?= $siswa['jumlah_absensi_unverified'] ?></td>
                                <td><?= $siswa['jumlah_logbook_verified'] ?></td>
                                <td class="bg-danger"><?= $siswa['jumlah_logbook_unverified'] ?></td>
                                <td>
                                    <?php if (is_null($siswa['laporan'])) : ?>
                                        <span class="badge badge-light-danger">Belum Mengumpulkan</span>
                                    <?php else : ?>
                                        <a href="lampiran/laporan/<?= $siswa['laporan'] ?>" target="_blank" class="badge badge-light-success"><?= $siswa['laporan'] ?></a>
                                    <?php endif; ?>
                                </td>
                                <td><a href="javascript:void(0)" onclick="showModalKomentar('<?= $siswa['siswa_id'] ?>')"><span class="badge badge-light-warning">+ catatan</span></a></td>
                                <td>
                                    <?php if (is_null($siswa['laporan'])) : ?>
                                        <span class="badge badge-light-warning">Tunda Verifikasi</span>
                                    <?php else : ?>
                                        <?php if ($siswa['verif_laporan'] == 1) : ?>
                                            <span class="badge badge-light-success">Terverifikasi</span>
                                        <?php else : ?>
                                            <span class="badge badge-light-danger">Belum Terverifikasi</span>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input input-success" type="checkbox" id="verif_laporan_<?= $siswa['siswa_id'] ?>" onchange="verifLaporan('<?= $siswa['siswa_id'] ?>')">
                                                <label class="form-check-label" for="verif_laporan_<?= $siswa['siswa_id'] ?>">checklist disini untuk melakukan verifikasi laporan</label>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input type="text" name="nilai_<?= $siswa['siswa_id'] ?>" id="nilai_<?= $siswa['siswa_id'] ?>" class="input-border-bottom" size="3" onchange="addNilai('<?= $siswa['siswa_id'] ?>', this)" value="<?= $siswa['nilai'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Tempat PKL</th>
                            <th>Pimpinan PKL</th>
                            <th>Status PKL</th>
                            <th>Absensi <br> Terverifikasi</th>
                            <th>Absensi <br> Belum Diverifikasi</th>
                            <th>Logbook <br> Terverifikasi</th>
                            <th>Logbook <br> Belum Diverifikasi</th>
                            <th>Laporan PKL</th>
                            <th>Catatan Laporan</th>
                            <th>Verifikasi Laporan PKL</th>
                            <th>Nilai</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="modal-show-laporan" class="modal fade modal-lg"></div>
<script>
    $(document).ready(function() {
        $('#table-daftar-siswa').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                }
            ],
            responsive: true
        });
    });

    function addNilai(siswa_id, el) {
        var nilai = $(el).val();
        $.ajax({
            url: 'classes/DaftarSiswa.php',
            type: 'POST',
            data: {
                siswa_id: siswa_id,
                nilai: nilai,
                action: 'addNilai'
            },
            success: function(data) {
                if (data == 'success') {
                    notifier.show(
                        'Sukses!',
                        'Nilai berhasil ditambahkan.',
                        'success',
                        'assets/images/notification/ok-48.png',
                        3000
                    );
                } else {
                    notifier.show(
                        'Gagal!',
                        'Nilai gagal ditambahkan.',
                        'danger',
                        'assets/images/notification/high_priority-48.png',
                        3000
                    );
                }
            }
        });
    }

    function changeStatusPKL(siswa_id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah diubah, status PKL siswa tidak dapat dikembalikan lagi!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((responsSwal) => {
            if (responsSwal) {
                $.ajax({
                    url: 'classes/DaftarSiswa.php',
                    type: 'POST',
                    data: {
                        siswa_id: siswa_id,
                        action: 'changeStatusPKL'
                    },
                    success: function(data) {
                        if (data == 'success') {
                            notifier.show(
                                'Sukses!',
                                'Status PKL berhasil diubah.',
                                'success',
                                'assets/images/notification/ok-48.png',
                                3000
                            );
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            notifier.show(
                                'Gagal!',
                                'Status PKL gagal diubah.',
                                'danger',
                                'assets/images/notification/high_priority-48.png',
                                3000
                            );
                        }
                    }
                });
            } else {
                location.reload();
            }
        });
    }

    function verifLaporan(siswa_id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah diverifikasi, laporan PKL siswa tidak dapat dikembalikan lagi",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((responsSwal) => {
            if (responsSwal) {
                $.ajax({
                    url: 'classes/DaftarSiswa.php',
                    type: 'POST',
                    data: {
                        siswa_id: siswa_id,
                        action: 'verifLaporan'
                    },
                    success: function(data) {
                        if (data == 'success') {
                            notifier.show(
                                'Sukses!',
                                'Laporan PKL berhasil diverifikasi',
                                'success',
                                'assets/images/notification/ok-48.png',
                                3000
                            );
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            notifier.show(
                                'Gagal!',
                                'Laporan PKL gagal diverifikasi',
                                'danger',
                                'assets/images/notification/high_priority-48.png',
                                3000
                            );
                        }
                    }
                });
            } else {
                location.reload();
            }
        });
    }

    function showModalKomentar(siswa_id) {
        $.ajax({
            url: 'content/modal-show-komentar-laporan.php',
            type: 'POST',
            data: {
                siswa_id: siswa_id,
                action: 'getKomentar'
            },
            success: function(data) {
                $('#modal-show-laporan').html(data);
                $('#modal-show-laporan').modal('show');
            }
        });
    }
</script>