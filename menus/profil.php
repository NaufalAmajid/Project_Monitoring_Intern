<?php
require_once 'classes/User.php';
?>
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Profile</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=profil">Detail Profile User</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Detail User</h5>
        </div>
        <div class="card-body">
            <form id="form-edit-user">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" value="<?= $_SESSION['username'] ?>" class="form-control" id="username" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" name="email" class="form-control" value="<?= $_SESSION['email'] ?>" id="email" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="password">Password Lama</label>
                            <input type="password" name="password" aria-describedby="status_cekPassword" class="form-control" onchange="cekPassword(this, '<?= $_SESSION['user_id'] ?>')" id="password" placeholder="masukkan password lama ...">
                            <small id="status_cekPassword" class="form-text"></small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="password1">Ganti Password</label>
                            <input type="password" name="password1" class="form-control" id="password1" disabled placeholder="ganti password ...">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="password2">Konfirm Password</label>
                            <input type="password" name="password2" class="form-control" id="password2" disabled placeholder="konfirmasi password baru ...">
                            <small id="status_konfirmPassword" class="form-text"></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-3">
                        <div class="mb-3">
                            <button type="button" id="btn-edit-user" onclick="changePassword('<?= $_SESSION['user_id'] ?>')" class="btn btn-info col-md-12"><i class="feather icon-info"></i>Edit Autentikasi</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <h5 class="mb-3">Detail <?= ucwords($_SESSION['nama_status_user']) ?></h5>
            <?php if ($_SESSION['status_user_id'] == 2) : ?>
            <?php else : ?>
                <?php
                $siswa = new User();
                $siswa = $siswa->getSiswaById($_SESSION['the_id']);
                ?>
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?= $siswa['nama_siswa'] ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="nis">NIS</label>
                            <input type="text" name="nis" class="form-control" value="<?= $siswa['nis'] ?>" id="nis" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="nis">No</label>
                            <input type="text" name="no" class="form-control" id="no" value="<?= $siswa['no'] ?>" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" class="form-control" value="<?= $siswa['jenis_kelamin'] ?>" id="jenis_kelamin" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="kelas">Kelas</label>
                            <input type="text" name="kelas" class="form-control" id="kelas" value="<?= $siswa['nama_kelas'] ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" id="jurusan" value="<?= $siswa['nama_jurusan'] ?>" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="tempat_pkl">Tempat PKL</label>
                            <input type="text" name="tempat_pkl" class="form-control" id="tempat_pkl" value="<?= $siswa['tempat_pkl'] ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="nama_pembimbing">Pembimbing</label>
                            <input type="text" name="nama_pembimbing" class="form-control" id="nama_pembimbing" value="<?= $siswa['nama_pembimbing'] ?>" readonly disabled>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
        </div>
    </div>
    <script>
        function cekPassword(el, user_id) {
            let password = el.value;
            $.ajax({
                url: 'classes/User.php',
                type: 'POST',
                data: {
                    password: password,
                    user_id: user_id,
                    action: 'cekPassword'
                },
                success: function(data) {
                    let res = JSON.parse(data);
                    if (res.status == 'success') {
                        $('#status_cekPassword').html('Password benar');
                        $('#status_cekPassword').addClass('text-success');
                        $('#password1').removeAttr('disabled');
                        $('#password2').removeAttr('disabled');
                        $('#password1').focus();
                    } else {
                        $('#status_cekPassword').html('Password salah');
                        $('#status_cekPassword').addClass('text-danger');
                        $('#password1').attr('disabled', 'disabled');
                        $('#password2').attr('disabled', 'disabled');
                    }
                }
            });
        }

        function changePassword(user_id) {
            let data = $('#form-edit-user').serializeArray();
            let send = {};
            data.map(item => {
                send[item.name] = item.value;
            });
            send['action'] = 'changePassword';
            send['user_id'] = user_id;
            if (send.password1 == '' || send.password2 == '') {
                notifier.show(
                    'Gagal!',
                    'Password tidak boleh kosong.',
                    'danger',
                    'assets/images/notification/high_priority-48.png',
                    3000
                );
                return;
            }
            if (send.password1 != send.password2) {
                $('#status_konfirmPassword').html('Password tidak sama');
                $('#status_konfirmPassword').addClass('text-danger');
                $('#btn-edit-user').attr('disabled', 'disabled');
            } else {
                $('#status_konfirmPassword').html('');
                $('#btn-edit-user').removeAttr('disabled');
                $.ajax({
                    url: 'classes/User.php',
                    type: 'POST',
                    data: send,
                    success: function(data) {
                        if (data == 'success') {
                            notifier.show(
                                'Sukses!',
                                'Password berhasil diubah.',
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
                                'Password gagal diubah.',
                                'danger',
                                'assets/images/notification/high_priority-48.png',
                                3000
                            );
                        }
                    }
                });
            }
        }
    </script>