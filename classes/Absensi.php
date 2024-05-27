<?php

class Absensi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addAbsensi($data)
    {
        $db = DB::getInstance();
        return $db->add('absensi', $data);
    }

    public function editAbsensi($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('absensi', $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    session_start();
    $absensi = new Absensi();
    if ($_POST['action'] == 'absensiSiswa') {
        $foto               = $_FILES['foto'];
        $foto_name          = $foto['name'];
        $foto_tmp           = $foto['tmp_name'];
        $foto_size          = $foto['size'];
        $foto_error         = $foto['error'];

        $foto_ext           = explode('.', $foto_name);
        $foto_actual_ext    = strtolower(end($foto_ext));

        $allowed            = ['jpg', 'jpeg', 'png'];

        if (in_array($foto_actual_ext, $allowed)) {
            if ($foto_error === 0) {
                if ($foto_size < 1000000) {
                    $foto_name_new = $_SESSION['the_id'] . '_' . date('YmdHis') . '-' . $_POST['status'] . '.' . $foto_actual_ext;
                    $foto_destination = '../lampiran/absensi/' . $foto_name_new;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Your file is too big!']);
                    exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'There was an error uploading your file!']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You cannot upload files of this type!']);
            exit();
        }

        if ($_POST['status'] == 'masuk') {
            $dataInsert = [
                'siswa_id' => $_SESSION['the_id'],
                'hari' => date('Y-m-d'),
                'masuk' => date('H:i:s'),
                'lampiran_masuk' => $foto_name_new
            ];
            $save = $absensi->addAbsensi($dataInsert);
        } else {
            $dataInsert = [
                'keluar' => date('H:i:s'),
                'lampiran_keluar' => $foto_name_new
            ];
            $where = ['siswa_id' => $_SESSION['the_id'], 'hari' => date('Y-m-d')];
            $save = $absensi->editAbsensi($dataInsert, $where);
        }

        if ($save > 0) {
            move_uploaded_file($foto_tmp, $foto_destination);
            echo json_encode(['status' => 'success', 'data' => $dataInsert]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data!']);
        }
    }
}
