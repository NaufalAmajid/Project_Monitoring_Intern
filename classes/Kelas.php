<?php

class Kelas
{
    private $conn;
    private $table = 'kelas';

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addKelas($data)
    {
        $db = DB::getInstance();
        return $db->add($this->table, $data);
    }

    public function editKelas($data, $where)
    {
        $db = DB::getInstance();
        return $db->update($this->table, $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    $kelas = new Kelas();

    if ($_POST['action'] == 'add') {
        $data = [
            'nama_kelas' => $_POST['nama_kelas'],
            'jurusan_id' => $_POST['jurusan_id'],
            'pembimbing_id' => $_POST['pembimbing_id']
        ];
        $result = $kelas->addKelas($data);
        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'edit') {
        $data = [
            'nama_kelas' => $_POST['nama_kelas'],
            'pembimbing_id' => $_POST['pembimbing_id']
        ];
        $where = [
            'kelas_id' => $_POST['kelas_id']
        ];
        $result = $kelas->editKelas($data, $where);
        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'editAktif') {
        $data = [
            'is_active' => $_POST['status']
        ];
        $where = [
            'kelas_id' => $_POST['kelas_id']
        ];
        $result = $kelas->editKelas($data, $where);
        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
