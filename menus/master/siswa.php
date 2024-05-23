<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Siswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=master&sub=siswa">Daftar Siswa</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<?php
require_once 'classes/Siswa.php';

$siswa = new Siswa();
$siswa = $siswa->getAllSiswa();
?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header table-card-header">
            <h5>List Siswa Aktif</h5>
            <div class="card-header-right">
                <button type="button" class="btn shadow-1 btn-info" onclick="tambahSiswa()">
                    <i class="feather icon-file-plus"></i>Tambah Siswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="table-siswa" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nis</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Nama Pembimbing</th>
                            <th>Tempat PKL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($siswa as $sis) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $sis['username'] ?></td>
                                <td><?= $sis['email'] ?></td>
                                <td><?= $sis['nis'] ?></td>
                                <td><?= $sis['nama_lengkap'] ?></td>
                                <td><?= $sis['jenis_kelamin'] ?></td>
                                <td><?= $sis['nama_kelas'] ?></td>
                                <td><?= $sis['nama_jurusan'] ?></td>
                                <td><?= $sis['nama_pembimbing'] ?></td>
                                <td><?= $sis['tempat_pkl'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-rounded btn-outline-primary" onclick="editPembimbing('<?= $sis['siswa_id'] ?>')"><i class="feather icon-edit"></i></button>
                                    <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" onclick="removePembimbing('<?= $sis['user_id'] ?>')"><i class="feather icon-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nis</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Nama Pembimbing</th>
                            <th>Tempat PKL</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="modal-siswa" class="modal fade modal-lg"></div>
<script>
    $(document).ready(function() {
        $('#table-siswa').DataTable({
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
            ]
        });
    });

    function tambahPembimbing() {
        $.ajax({
            url: 'content/modal-detail-pembimbing.php',
            type: 'post',
            data: {
                action: 'tambah',
                pembimbing_id: 0
            },
            success: function(response) {
                $('#modal-pembimbing').html(response);
                $('#modal-pembimbing').modal('show');
            }
        });
    }

    function editPembimbing(pembimbing_id) {
        $.ajax({
            url: 'content/modal-detail-pembimbing.php',
            type: 'post',
            data: {
                action: 'edit',
                pembimbing_id: pembimbing_id
            },
            success: function(response) {
                $('#modal-pembimbing').html(response);
                $('#modal-pembimbing').modal('show');
            }
        });
    }

    function savePembimbing() {
        let form = $('#form-pembimbing').serializeArray();
        let data = {};
        form.map(item => {
            data[item.name] = item.value;
        });
        if (data['jenis_kelamin'] == '') {
            notifier.show(
                'Perhatian!',
                'Jenis kelamin harus diisi.',
                'warning',
                'assets/images/notification/medium_priority-48.png',
                3000
            );
            return;
        }

        $.ajax({
            url: 'classes/Pembimbing.php',
            type: 'post',
            data: data,
            success: function(response) {
                if (response == 'success') {
                    notifier.show(
                        'Sukses!',
                        'Pembimbing berhasil ditambahkan.',
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
                        'Pembimbing gagal ditambahkan.',
                        'danger',
                        'assets/images/notification/high_priority-48.png',
                        3000
                    );
                }
            }
        });
    }

    function removePembimbing(user_id) {
        swal({
                title: "Apakah anda yakin?",
                text: "pembimbing yang sudah dihapus tidak bisa login kembali!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'classes/Pembimbing.php',
                        type: 'post',
                        data: {
                            action: 'delete',
                            user_id: user_id
                        },
                        success: function(response) {
                            if (response == 'success') {
                                notifier.show(
                                    'Sukses!',
                                    'Data pembimbing berhasil dihapus.',
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
                                    'Data pembimbing gagal dihapus.',
                                    'danger',
                                    'assets/images/notification/high_priority-48.png',
                                    3000
                                );
                            }
                        }
                    });
                } else {
                    swal("Data pembimbing tidak jadi dihapus!", {
                        icon: "info",
                    });
                }
            });
    }
</script>