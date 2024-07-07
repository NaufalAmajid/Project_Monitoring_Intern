<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Rekap Sistem</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=rekap_sistem">Rekap Seluruh Aktivitas Sistem</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/Rekap.php';
$rekap = new Rekap();
$rekaps = $rekap->getRekap();
$no = 1;
echo '<pre>';
print_r($rekaps);
echo '</pre>';
?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header table-card-header">
            <h5>List Rekap Aktifitas Sistem</h5>
            <div class="card-header-right">
                <form id="form-search-rekam">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class='input-group' id='search-date-rekap'>
                                <input type='text' class="form-control" placeholder="Pilih Tanggal" />
                                <button class="btn btn-primary btn-sm" type="button" onclick="searchRekap()"><i class="feather icon-search fs-4 ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="table-pembimbing" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Jurusan</th>
                            <th rowspan="2">Kelas</th>
                            <th rowspan="2">Nama Pembimbing</th>
                            <th colspan="2">Logbook</th>
                            <th colspan="2">Absensi</th>
                            <th colspan="2">Laporan</th>
                            <th rowspan="2">Jumlah Siswa</th>
                        </tr>
                        <tr>
                            <th>Logbook Belum Diverifikasi</th>
                            <th>Logbook Terverifikasi</th>
                            <th>Absensi Belum Diverifikasi</th>
                            <th>Absensi Terverifikasi</th>
                            <th>Laporan Belum Diverifikasi</th>
                            <th>Laporan Terverifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rekaps as $rek) : ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $rek['nama_jurusan'] ?></td>
                                <td><?= $rek['nama_kelas'] ?></td>
                                <td><?= $rek['nama_pembimbing'] ?></td>
                                <td><?= $rek['jumlah_logbook_unverif'] ?></td>
                                <td><?= $rek['jumlah_logbook_verif'] ?></td>
                                <td><?= $rek['jumlah_absensi_unverif'] ?></td>
                                <td><?= $rek['jumlah_absensi_verif'] ?></td>
                                <td><?= $rek['jumlah_laporan_unverif'] ?></td>
                                <td><?= $rek['jumlah_laporan_verif'] ?></td>
                                <td><?= $rek['jumlah_siswa'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table-pembimbing').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Data Rekap Monitoring PKL',
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Data Rekap Monitoring PKL',
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: 'Data Rekap Monitoring PKL',
                }
            ]
        });
    });
</script>