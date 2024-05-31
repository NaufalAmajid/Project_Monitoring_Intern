<?php
date_default_timezone_set('Asia/Jakarta');

class Logbook
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addLogbook($data)
    {
        $db = DB::getInstance();
        return $db->add('logbook', $data);
    }

    public function editLogbook($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('logbook', $data, $where);
    }

    public function getLogbookTodayBySiswaId($siswa_id)
    {
        $date = date('Y-m-d');
        $query = "select
                        *
                    from
                        logbook log
                    where
                        cast(log.created_at as date) = '$date'
                        and log.siswa_id = $siswa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllLogbookBySiswaId($siswa_id, $tgl1, $tgl2)
    {
        $query = "select
                        date_format(log.created_at, '%Y-%m-%d') as hari,
                        date_format(log.created_at, '%H:%i') as jam,
                        log.*
                    from
                        logbook log
                    where
                        cast(log.created_at as date) between '$tgl1' and '$tgl2'
                        and log.siswa_id = $siswa_id
                        order by log.created_at asc";
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
    $logbook = new Logbook();

    if ($_POST['action'] == 'writeLogbook') {
        $catatan = $_POST['catatan'];
        $siswa_id = $_SESSION['the_id'];
        $dataInsert = [
            'catatan' => $catatan,
            'siswa_id' => $siswa_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (isset($_FILES['foto'])) {

            if ($_POST['lampiran_lama'] != '') {
                unlink('../lampiran/logbook/' . $_POST['lampiran_lama']);
            }

            $foto    = $_FILES['foto'];

            // File handling
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
                        $foto_name_new = $_SESSION['the_id'] . '_' . date('YmdHis') . '.' . $foto_actual_ext;
                        $foto_destination = '../lampiran/logbook/' . $foto_name_new;
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

            $dataInsert['lampiran'] = $foto_name_new;
        }

        if ($_POST['status'] == 'add') {
            $save = $logbook->addLogbook($dataInsert);
        } else {
            $where = ['logbook_id' => $_POST['logbook_id']];
            $save = $logbook->editLogbook($dataInsert, $where);
        }

        if ($save) {
            if (isset($_FILES['foto'])) {
                move_uploaded_file($foto_tmp, $foto_destination);
            }
            echo json_encode(['status' => 'success', 'title' => 'Berhasil!', 'message' => 'Logbook berhasil disimpan!']);
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Terjadi kesalahan saat menyimpan logbook!']);
        }
    }
}
