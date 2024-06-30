<?php
date_default_timezone_set('Asia/Jakarta');
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

    public function deleteAbsensi($where)
    {
        $db = DB::getInstance();
        return $db->delete('absensi', $where);
    }

    public function getAbsensiTodayBySiswaId($siswa_id)
    {
        $date  = date('Y-m-d');
        $query = "select
                        *
                    from
                        absensi abs
                    where
                        abs.hari = '$date'
                        and abs.siswa_id = $siswa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAbsensiBySiswaId($siswa_id, $tgl1, $tgl2)
    {
        $query = "select
                        *
                    from
                        absensi abs
                    where
                        abs.hari between '$tgl1' and '$tgl2'
                        and abs.siswa_id = $siswa_id
                        order by abs.hari desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
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
                    echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Ukuran file terlalu besar! Max 1MB!']);
                    exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Terjadi kesalahan saat upload file!']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Format file tidak didukung! Hanya JPG, JPEG, PNG!']);
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
            echo json_encode(['status' => 'success', 'title' => 'Berhasil!', 'message' => 'Berhasil absen!']);
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Gagal absen!']);
        }
    }

    if ($_POST['action'] == 'repeatAbsen') {
        $absensi_id = $_POST['absensi_id'];
        $lampiran_masuk = $_POST['lampiran_masuk'];
        $lokasi_lampiran = '../lampiran/absensi/' . $lampiran_masuk;

        $deleteAbsensi = $absensi->deleteAbsensi('absensi_id = ' . $absensi_id);
        if ($deleteAbsensi) {
            unlink($lokasi_lampiran);
            echo "success";
        } else {
            echo "failed";
        }
    }
}
