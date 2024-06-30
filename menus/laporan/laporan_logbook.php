<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan Logbook <?= ucwords($_SESSION['nama']) ?></h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=laporan&sub=laporan_logbook">Laporan Logbook</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header table-card-header">
            <h5>List Logbook <?= ucwords($_SESSION['nama']) ?></h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class='input-group' id='search-logbook-siswa'>
                        <input type='text' class="form-control" placeholder="Select Date" />
                        <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                    <div class="form-group">
                        <button class="btn btn-info btn-icon" id="btn-search-laporan-logbook" type="button" onclick="searchLaporanLogbook('<?= $_SESSION['the_id'] ?>')"><i class="feather icon-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="dt-responsive table-responsive">
                <table id="table-laporan-logbook" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Catatan</th>
                            <th>Lampiran</th>
                            <th>Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody id="list-laporan-logbook">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Catatan</th>
                            <th>Lampiran</th>
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
        $('#btn-search-laporan-logbook').click();
    });

    function searchLaporanLogbook(siswa_id) {
        $('#table-laporan-logbook').DataTable().destroy();
        let search = $('#search-logbook-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/laporan-logbook-siswa-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                siswa_id: siswa_id
            },
            beforeSend: function() {
                $('#list-laporan-logbook').html('<tr><td colspan="5" class="text-center">Loading ...</td></tr>');
            },
            success: function(response) {
                $('#list-laporan-logbook').html(response);
                $('#table-laporan-logbook').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Data Laporan Logbook <?= ucwords($_SESSION['nama']) ?>',
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Data Laporan Logbook <?= ucwords($_SESSION['nama']) ?>',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Data Laporan Logbook <?= ucwords($_SESSION['nama']) ?>',
                        }
                    ],
                });
            }
        });
    }
</script>