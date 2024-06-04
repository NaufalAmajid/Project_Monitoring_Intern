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
                            <th>Absensi <br> Terverifikasi</th>
                            <th>Absensi <br> Belum Diverifikasi</th>
                            <th>Logbook <br> Terverifikasi</th>
                            <th>Logbook <br> Belum Diverifikasi</th>
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
                                <td><?= $siswa['jumlah_absensi_verified'] ?></td>
                                <td class="bg-danger"><?= $siswa['jumlah_absensi_unverified'] ?></td>
                                <td><?= $siswa['jumlah_logbook_verified'] ?></td>
                                <td class="bg-danger"><?= $siswa['jumlah_logbook_unverified'] ?></td>
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
                            <th>Absensi <br> Terverifikasi</th>
                            <th>Absensi <br> Belum Diverifikasi</th>
                            <th>Logbook <br> Terverifikasi</th>
                            <th>Logbook <br> Belum Diverifikasi</th>
                            <th>Nilai</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
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
</script>