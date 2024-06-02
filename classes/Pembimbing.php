<?php

class Pembimbing
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllPembimbing($forAddKelas = false)
    {
        $query = "select
                        us.username,
                        us.email,
                        dp.*
                    from
                        detail_pembimbing dp
                        left join user us on dp.user_id = us.user_id 
                    where
                        us.is_active = 1
                    order by
                        nama_lengkap asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $pembimbings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pembimbings[] = $row;
        }

        return $pembimbings;
    }

    public function getPembimbingById($pembimbing_id)
    {
        $query = "select
                        us.username,
                        us.email,
                        us.user_id,
                        dp.*
                    from
                        detail_pembimbing dp
                        left join user us on dp.user_id = us.user_id 
                    where
                        dp.pembimbing_id = $pembimbing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPembimbing($data)
    {
        $db = DB::getInstance();
        return $db->add('detail_pembimbing', $data);
    }

    public function addUser($data)
    {
        $db = DB::getInstance();
        $result = $db->add('user', $data);
        $user_id = $this->conn->lastInsertId();
        return $user_id;
    }

    public function editPembimbing($table, $data, $where)
    {
        $db = DB::getInstance();
        return $db->update($table, $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';

    $pembimbing = new Pembimbing();

    if ($_POST['action'] == 'tambah') {
        $password = md5($_POST['password']);
        $dataUser = [
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "password" => $password,
            "status_user_id" => 2,
        ];

        $user_id = $pembimbing->addUser($dataUser);

        $dataPembimbing = [
            "nama_lengkap" => $_POST['nama_lengkap'],
            "no" => $_POST['no'],
            "jenis_kelamin" => $_POST['jenis_kelamin'],
            "user_id" => $user_id
        ];

        $result = $pembimbing->addPembimbing($dataPembimbing);

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

        $updateUser = $pembimbing->editPembimbing('user', $dataUser, $whereUser);

        $dataPembimbing = [
            "nama_lengkap" => $_POST['nama_lengkap'],
            "no" => $_POST['no'],
            "jenis_kelamin" => $_POST['jenis_kelamin']
        ];

        $wherePembimbing = [
            "pembimbing_id" => $_POST['pembimbing_id']
        ];

        $updatePembimbing = $pembimbing->editPembimbing('detail_pembimbing', $dataPembimbing, $wherePembimbing);

        if ($updateUser >= 0 && $updatePembimbing >= 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'delete') {
        $where = [
            "user_id" => $_POST['user_id']
        ];

        $result = $pembimbing->editPembimbing('user', ['is_active' => 0], $where);

        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
