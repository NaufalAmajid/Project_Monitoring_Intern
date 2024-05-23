<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Jurusan Dan Kelas</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=master&sub=jurusan_kelas">Daftar Jurusan & Kelas</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Jurusan</h5>
                <div class="card-header-right">
                    <button type="button" class="btn shadow-1 btn-info" onclick="tambahJurusan()">
                        <i class="feather icon-file-plus"></i>Tambah Jurusan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="input-group search-form">
                            <input type="text" class="form-control" placeholder="Cari Jurusan ..." id="search-jurusan" autofocus onchange="content()">
                            <span class="input-group-text bg-default"><i class="feather icon-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div id="content"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        content();
    });

    function content() {
        var search = $('#search-jurusan').val();
        $.ajax({
            url: 'content/content_jurusan_kelas.php',
            type: 'GET',
            data: {
                search: search
            },
            success: function(response) {
                $('#content').html(response);
            }
        });
    }

    function tambahKelas(jurusan_id) {
        let nama_kelas = $('#nama_kelas_baru_' + jurusan_id).val();
        let pembimbing_id = $('#pembimbing_' + jurusan_id).find(":selected").val();
        if (nama_kelas == '' || pembimbing_id == '') {
            notifier.show(
                'Perhatian!',
                'Silahkan isi nama kelas dan pilih pembimbing terlebih dahulu.',
                'warning',
                'assets/images/notification/medium_priority-48.png',
                3000
            );
            return;
        } else {
            $.ajax({
                url: 'classes/Kelas.php',
                type: 'POST',
                data: {
                    action: 'add',
                    jurusan_id: jurusan_id,
                    pembimbing_id: pembimbing_id,
                    nama_kelas: nama_kelas
                },
                success: function(response) {
                    if (response == 'success') {
                        notifier.show(
                            'Sukses!',
                            'Kelas berhasil ditambahkan.',
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
                            'Kelas gagal ditambahkan.',
                            'danger',
                            'assets/images/notification/high_priority-48.png',
                            3000
                        );
                    }
                }
            });
        }
    }

    function editKelas(kelas_id) {
        let nama_kelas = $('#nama_kelas_' + kelas_id).val();
        let pembimbing_id = $('#pembimbing_' + kelas_id).find(":selected").val();
        if (nama_kelas == '') {
            notifier.show(
                'Perhatian!',
                'Nama kelas tidak boleh kosong.',
                'warning',
                'assets/images/notification/medium_priority-48.png',
                3000
            );
            return;
        } else {
            $.ajax({
                url: 'classes/Kelas.php',
                type: 'POST',
                data: {
                    action: 'edit',
                    kelas_id: kelas_id,
                    pembimbing_id: pembimbing_id,
                    nama_kelas: nama_kelas
                },
                success: function(response) {
                    if (response == 'success') {
                        notifier.show(
                            'Sukses!',
                            'Kelas berhasil diubah.',
                            'success',
                            'assets/images/notification/ok-48.png',
                            3000
                        );
                    } else {
                        notifier.show(
                            'Gagal!',
                            'Kelas gagal diubah.',
                            'danger',
                            'assets/images/notification/high_priority-48.png',
                            3000
                        );
                    }
                }
            });
        }
    }

    function editAktifKelas(el, kelas_id) {
        let status = $(el).is(':checked') ? 1 : 0;
        $.ajax({
            url: 'classes/Kelas.php',
            type: 'POST',
            data: {
                action: 'editAktif',
                kelas_id: kelas_id,
                status: status
            },
            success: function(response) {
                if (response == 'success') {
                    notifier.show(
                        'Sukses!',
                        'Status kelas berhasil diubah.',
                        'success',
                        'assets/images/notification/ok-48.png',
                        3000
                    );
                } else {
                    notifier.show(
                        'Gagal!',
                        'Status kelas gagal diubah.',
                        'danger',
                        'assets/images/notification/high_priority-48.png',
                        3000
                    );
                }
            }
        });
    }

    function tambahJurusan() {
        swal("Silahkan masukkan nama jurusan :", {
                content: "input",
            })
            .then((value) => {
                if (value == null || value == '') {
                    notifier.show(
                        'Perhatian!',
                        'Nama jurusan tidak boleh kosong.',
                        'warning',
                        'assets/images/notification/medium_priority-48.png',
                        3000
                    );
                    return;
                } else {
                    $.ajax({
                        url: 'classes/Jurusan.php',
                        type: 'POST',
                        data: {
                            action: 'add',
                            nama_jurusan: value
                        },
                        success: function(response) {
                            if (response == 'success') {
                                notifier.show(
                                    'Sukses!',
                                    'Jurusan berhasil ditambahkan.',
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
                                    'Jurusan gagal ditambahkan.',
                                    'danger',
                                    'assets/images/notification/high_priority-48.png',
                                    3000
                                );
                            }
                        }
                    });
                }
            });
    }

    function editJurusan(el, jurusan_id) {
        let nama_jurusan = $(el).val();
        $.ajax({
            url: 'classes/Jurusan.php',
            type: 'POST',
            data: {
                action: 'edit',
                jurusan_id: jurusan_id,
                nama_jurusan: nama_jurusan
            },
            success: function(response) {
                if (response == 'success') {
                    notifier.show(
                        'Sukses!',
                        'Jurusan berhasil diubah.',
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
                        'Jurusan gagal diubah.',
                        'danger',
                        'assets/images/notification/high_priority-48.png',
                        3000
                    );
                }
            }
        });
    }

    function editAktifJurusan(el, jurusan_id) {
        let status = $(el).is(':checked') ? 1 : 0;
        $.ajax({
            url: 'classes/Jurusan.php',
            type: 'POST',
            data: {
                action: 'editAktif',
                jurusan_id: jurusan_id,
                status: status
            },
            success: function(response) {
                if (response == 'success') {
                    notifier.show(
                        'Sukses!',
                        'Status jurusan berhasil diubah.',
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
                        'Status jurusan gagal diubah.',
                        'danger',
                        'assets/images/notification/high_priority-48.png',
                        3000
                    );
                }
            }
        });
    }
</script>