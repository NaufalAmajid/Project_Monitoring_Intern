<?php

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function cekPassword($user_id, $password)
    {
        $password = md5($password);

        $query = "select
                    user_id
                from
                    user
                where
                    user_id = $user_id
                    and password = '$password'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function changePassword($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('user', $data, $where);
    }

    public function getSiswaById($siswa_id)
    {
        $query = "select
                    usr.user_id,
                    usr.username,
                    usr.email,
                    ds.nama_lengkap as nama_siswa,
                    ds.no,
                    ds.nis,
                    ds.jenis_kelamin,
                    ds.tempat_pkl,
                    kel.nama_kelas,
                    jur.nama_jurusan,
                    dp.nama_lengkap as nama_pembimbing
                from
                    detail_siswa ds
                left join user usr on
                    ds.user_id = usr.user_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
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

    public function getPembimbingById($pembimbing_id)
    {
        $query = "select
                    dp.no,
                    dp.pembimbing_id,
                    dp.nama_lengkap as nama_pembimbing,
                    dp.jenis_kelamin,
                    kel.nama_kelas,
                    jur.nama_jurusan
                from
                    detail_pembimbing dp
                left join kelas kel on
                    dp.pembimbing_id = kel.pembimbing_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where
                    dp.pembimbing_id = $pembimbing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $pembimbing = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pembimbing['nama_pembimbing'] = $row['nama_pembimbing'];
            $pembimbing['jenis_kelamin'] = $row['jenis_kelamin'];
            $pembimbing['no'] = $row['no'];
            $pembimbing['kelas'][] = [
                'nama_kelas' => $row['nama_kelas'],
                'nama_jurusan' => $row['nama_jurusan']
            ];
        }

        return $pembimbing;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';

    $user = new User();
    if ($_POST['action'] == 'cekPassword') {
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        $result = $user->cekPassword($user_id, $password);
        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    if ($_POST['action'] == 'changePassword') {
        if (isset($_POST['password1']) && isset($_POST['password2'])) {
            $dataEdit = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password1']),
            ];
        } else {
            $dataEdit = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
            ];
        }

        $where = ['user_id' => $_POST['user_id']];
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email'] = $_POST['email'];

        $result = $user->changePassword($dataEdit, $where);
        if ($result >= 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
