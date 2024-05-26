<?php

class Siswa
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllSiswa()
    {
        $query = "select
                    us.username,
                    us.email,
                    kel.kelas_id,
                    kel.nama_kelas,
                    jur.nama_jurusan,
                    dp.nama_lengkap as nama_pembimbing,
                    ds.*
                from
                    detail_siswa ds
                left join user us on
                    ds.user_id = us.user_id
                left join kelas kel on ds.kelas_id = kel.kelas_id
                left join jurusan jur on kel.jurusan_id = jur.jurusan_id
                left join detail_pembimbing dp on kel.pembimbing_id = dp.pembimbing_id
                where
                    us.is_active = 1
                order by
                    nama_lengkap asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $siswa = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $siswa[] = $row;
        }

        return $siswa;
    }

    public function getAllJurusan()
    {
        $query = "select
                        kel.kelas_id,
                        kel.nama_kelas,
                        jur.nama_jurusan,
                        jur.jurusan_id,
                        dp.nama_lengkap as nama_pembimbing
                    from
                        kelas kel
                    left join jurusan jur on
                        kel.jurusan_id = jur.jurusan_id
                    left join detail_pembimbing dp on
                        kel.pembimbing_id = dp.pembimbing_id
                    where
                        kel.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $jurusan = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $jurusan[$row['jurusan_id']]['nama_jurusan'] = $row['nama_jurusan'];
            $jurusan[$row['jurusan_id']]['jurusan_id'] = $row['jurusan_id'];
            $jurusan[$row['jurusan_id']]['kelas'][] = [
                'kelas_id' => $row['kelas_id'],
                'nama_kelas' => $row['nama_kelas'],
                'nama_pembimbing' => $row['nama_pembimbing']
            ];
        }

        return $jurusan;
    }

    public function getSiswaById($siswa_id)
    {
        $query = "select
                    usr.username,
                    usr.email,
                    usr.user_id,
                    ds.nama_lengkap as nama_siswa,
                    ds.no,
                    ds.nis,
                    ds.jenis_kelamin,
                    ds.tempat_pkl,
                    kel.nama_kelas,
                    kel.kelas_id,
                    jur.nama_jurusan,
                    dp.nama_lengkap as nama_pembimbing
                from
                    detail_siswa ds
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join user usr on
                    ds.user_id = usr.user_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                left join detail_pembimbing dp on
                    kel.pembimbing_id = dp.pembimbing_id
                where
                    ds.siswa_id = $siswa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSiswa($data)
    {
        $db = DB::getInstance();
        return $db->add('detail_siswa', $data);
    }

    public function addUser($data)
    {
        $db = DB::getInstance();
        $result = $db->add('user', $data);
        $user_id = $this->conn->lastInsertId();
        return $user_id;
    }

    public function editSiswa($table, $data, $where)
    {
        $db = DB::getInstance();
        return $db->update($table, $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';

    $siswa = new Siswa();

    if ($_POST['action'] == 'add') {
        $password = md5($_POST['password']);
        $dataUser = [
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "password" => $password,
            "status_user_id" => 3,
        ];

        $user_id = $siswa->addUser($dataUser);

        $dataSiswa = [
            "nama_lengkap" => $_POST['nama_lengkap'],
            "no" => $_POST['no'],
            "nis" => $_POST['nis'],
            "jenis_kelamin" => $_POST['jenis_kelamin'],
            "user_id" => $user_id,
            "kelas_id" => $_POST['kelas_id'],
            "tempat_pkl" => $_POST['tempat_pkl']
        ];

        $result = $siswa->addSiswa($dataSiswa);

        if ($result) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'update') {

        $dataUser = [
            "username" => $_POST['username'],
            "email" => $_POST['email'],
        ];

        $whereUser = [
            "user_id" => $_POST['user_id']
        ];

        $updateUser = $siswa->editSiswa('user', $dataUser, $whereUser);

        $dataSiswa = [
            "nama_lengkap" => $_POST['nama_lengkap'],
            "no" => $_POST['no'],
            "nis" => $_POST['nis'],
            "jenis_kelamin" => $_POST['jenis_kelamin'],
            "kelas_id" => $_POST['kelas_id'],
            "tempat_pkl" => $_POST['tempat_pkl']
        ];

        $whereSiswa = [
            "siswa_id" => $_POST['siswa_id']
        ];

        $updateSiswa = $siswa->editSiswa('detail_siswa', $dataSiswa, $whereSiswa);

        if ($updateUser >= 0 && $updateSiswa >= 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'delete') {
        $where = [
            "user_id" => $_POST['user_id']
        ];

        $result = $siswa->editSiswa('user', ['is_active' => 0], $where);

        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
