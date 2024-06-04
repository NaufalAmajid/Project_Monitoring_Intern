<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan Absensi <?= ucwords($_SESSION['nama']) ?></h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=laporan&sub=laporan_absensi">Laporan Absensi</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header table-card-header">
            <h5>List Absensi <?= ucwords($_SESSION['nama']) ?></h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class='input-group' id='search-absensi-siswa'>
                        <input type='text' class="form-control" placeholder="Select Date" />
                        <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                    <div class="form-group">
                        <button class="btn btn-info btn-icon" id="btn-search-laporan-absensi" type="button" onclick="searchLaporanAbsensi('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="dt-responsive table-responsive">
                <table id="table-laporan-absensi" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody id="list-laporan-absensi">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Verifikasi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-search-laporan-absensi').click();
    });

    function searchLaporanAbsensi(siswa_id) {
        $('#table-laporan-absensi').DataTable().destroy();
        let search = $('#search-absensi-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/laporan-absensi-siswa-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                siswa_id: siswa_id
            },
            beforeSend: function() {
                $('#list-laporan-absensi').html('<tr><td colspan="5" class="text-center">Loading ...</td></tr>');
            },
            success: function(response) {
                $('#list-laporan-absensi').html(response);
                $('#table-laporan-absensi').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Laporan Absensi <?= ucwords($_SESSION['nama']) ?>',
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Laporan Absensi <?= ucwords($_SESSION['nama']) ?>',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Laporan Absensi <?= ucwords($_SESSION['nama']) ?>',
                        }
                    ],
                });
            }
        });
    }
</script>