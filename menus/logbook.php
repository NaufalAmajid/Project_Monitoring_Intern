<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Log Book</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=logbook">Logbook Siswa</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/Absensi.php';

$absensi = new Absensi();
$absensi = $absensi->getAbsensiTodayBySiswaId($_SESSION['the_id']);
?>
<div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-uppercase" id="logbook-tab" data-bs-toggle="tab" href="#logbook" role="tab" aria-controls="logbook" aria-selected="true">Logbook</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" id="riw_logbook-tab" data-bs-toggle="tab" href="#riw_logbook" role="tab" aria-controls="riw_logbook" aria-selected="false">Riwayat Logbook</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- [ user card1 ] start -->
            <div class="tab-pane fade show active" id="logbook" role="tabpanel" aria-labelledby="logbook-tab">
                <div class="row mb-4">
                    <div class="col-sm-7">
                        <label class="form-label" for="catatan-kegiatan">Catatan</label>
                        <textarea class="form-control" id="catatan-kegiatan" rows="10"></textarea>
                    </div>
                    <div class="col-sm-5 mt-4">
                        <div class="form-group">
                            <center>
                                <img src="assets/images/image-placeholder.jpg" onclick="triggerClick(this)" alt="image-placeholder" id="image-placeholder" class="img-thumbnail">
                            </center>
                            <input type="file" class="form-control d-none" onchange="displayImage(this)" id="foto" name="foto">
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <button class="btn btn-primary col-md-12" id="btn-logbook" onclick="logBook()">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- [ user card1 ] end -->
            <!-- varient [ 2 ][ cover shape ] card Start -->
            <div class="tab-pane fade" id="riw_logbook" role="tabpanel" aria-labelledby="riw_logbook-tab">
                <h1>Riwayat Logbook</h1>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-search-absensi').click();
    });

    function triggerClick(e) {
        document.querySelector('#foto').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#image-placeholder').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
            $('#btn-absensi').prop('disabled', false);
        }
    }

    function absensiSiswa(status) {
        let foto = $('#foto').prop('files')[0];
        let form_data = new FormData();
        form_data.append('foto', foto);
        form_data.append('action', 'absensiSiswa');
        form_data.append('status', status);
        $.ajax({
            url: 'classes/Absensi.php',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                let res = JSON.parse(response);
                swal({
                    title: res.title,
                    text: res.message,
                    icon: res.status,
                    button: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                })
            }
        });
    }

    function repeatAbsen(absensi_id, lampiran_masuk) {
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan mengulang absen",
            icon: "info",
            buttons: true,
            dangerMode: true,
        }).then((willLogout) => {
            if (willLogout) {
                $.ajax({
                    url: 'classes/Absensi.php',
                    type: 'post',
                    data: {
                        absensi_id: absensi_id,
                        lampiran_masuk: lampiran_masuk,
                        action: 'repeatAbsen'
                    },
                    success: function(response) {
                        if (response == 'success') {
                            swal("Berhasil!", "Silahkan mengulang absensi!", "info", {
                                button: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            swal("Gagal!", "Anda gagal mengulang", "error", {
                                button: false,
                                timer: 2000
                            });
                        }
                    }
                });
            } else {
                swal("Anda tidak jadi mengulang absensi", {
                    icon: "info",
                    button: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    function searchAbsensi(siswa_id) {
        $('#table-list-riwayat').DataTable().destroy();
        let search = $('#search-absensi-siswa input').val();
        let tgl1 = search.split(' / ')[0];
        let tgl2 = search.split(' / ')[1];
        $.ajax({
            url: 'content/riwayat-absensi-siswa-page.php',
            type: 'post',
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                siswa_id: siswa_id,
                action: 'searchAbsensi'
            },
            beforeSend: function() {
                $('#list-riwayat').html('<tr><td colspan="5" class="text-center">Loading ...</td></tr>');
            },
            success: function(response) {
                $('#list-riwayat').html(response);
                $('#table-list-riwayat').DataTable();
            }
        });
    }
</script>