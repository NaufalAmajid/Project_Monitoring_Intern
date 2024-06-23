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
            $foto_destination = '../lampiran/logbook/';
            if (!is_dir($foto_destination)) {
                mkdir($foto_destination, 0777, true);
            }
            $errors = [];
            $newFotos = [];
            $fotos = $_FILES['foto'];
            foreach ($fotos['name'] as $key => $filename) {
                $fileTmp        = $fotos['tmp_name'][$key];
                $fileType       = $fotos['type'][$key];
                $fileSize       = $fotos['size'][$key];
                $fileError      = $fotos['error'][$key];
                $fileExt        = explode('.', $filename);
                $fileActualExt  = strtolower(end($fileExt));
                $fileAllowed    = ['jpg', 'jpeg', 'png'];
                if (in_array($fileActualExt, $fileAllowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 1000000) {
                            $fileNewName = $_SESSION['the_id'] . '_' . date('YmdHis') . '_' . $key . '.' . $fileActualExt;
                            $fileDestination = $foto_destination . $fileNewName;
                            $newFotos[] = [
                                'name' => $fileNewName,
                                'tmp' => $fileTmp,
                                'destination' => $fileDestination
                            ];
                        } else {
                            $errors[] = 'Ukuran file terlalu besar! Max 1MB!';
                        }
                    } else {
                        $errors[] = 'Terjadi kesalahan saat upload file!';
                    }
                } else {
                    $errors[] = $filename . ' Format file tidak didukung! Hanya JPG, JPEG, PNG!';
                }
            }
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal!', 'message' => 'Lampiran tidak boleh kosong!']);
            exit();
        }

        echo json_encode($newFotos);
        exit();

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
