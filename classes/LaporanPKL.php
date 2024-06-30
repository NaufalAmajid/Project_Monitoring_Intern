<?php
date_default_timezone_set('Asia/Jakarta');
class LaporanPKL
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addLaporan($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('detail_siswa', $data, $where);
    }

    public function getSiswaById($siswa_id)
    {
        $query = "SELECT * FROM detail_siswa WHERE siswa_id = $siswa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    session_start();

    $laporanPKL = new LaporanPKL();
    if ($_POST['action'] == 'addLaporan') {
        $siswa_id = $_SESSION['the_id'];
        $dataSiswa = $laporanPKL->getSiswaById($siswa_id);

        $file_laporan = $_FILES['file_laporan'];
        $tmp_file_laporan = $file_laporan['tmp_name'];
        $name_file_laporan = $file_laporan['name'];
        $size_file_laporan = $file_laporan['size'];
        $error_file_laporan = $file_laporan['error'];

        $file_laporan_ext           = explode('.', $name_file_laporan);
        $file_laporan_actual_ext    = strtolower(end($file_laporan_ext));

        if ($error_file_laporan == 0) {
            $newName_file_laporan = 'Laporan PKL_' . $_SESSION['nama'] . '(' . $dataSiswa['nis'] . ').' . $file_laporan_actual_ext;
            $file_laporan_destination = '../lampiran/laporan/' . $newName_file_laporan;

            $dataUpdate = [
                'laporan' => $newName_file_laporan
            ];

            $where = [
                'siswa_id' => $siswa_id
            ];

            $addLaporan = $laporanPKL->addLaporan($dataUpdate, $where);

            if ($addLaporan > 0) {
                move_uploaded_file($tmp_file_laporan, $file_laporan_destination);
                $respon = [
                    'title' => 'Berhasil!',
                    'status' => 'success',
                    'msg' => 'File Laporan Berhasil DiUpload',
                    'icon' => 'assets/images/notification/ok-48.png',
                ];
            } else {
                $respon = [
                    'title' => 'Gagal!',
                    'status' => 'error',
                    'msg' => 'Gagal Upload File Laporan!',
                    'icon' => 'assets/images/notification/high_priority-48.png',
                ];
            }
        } else {
            $respon = [
                'title' => 'Perhatian!',
                'status' => 'warning',
                'msg' => 'File Sepertinya Corrupt, Cek File Anda!',
                'icon' => 'assets/images/notification/medium_priority-48.png'
            ];
        }

        echo json_encode($respon);
    }

    if ($_POST['action'] == 'reupload') {
        $dataUpdate = [
            'laporan' => NULL
        ];

        $where = [
            'siswa_id' => $_POST['siswa_id']
        ];

        $reUpload = $laporanPKL->addLaporan($dataUpdate, $where);

        if ($reUpload > 0) {
            $lokasiFile = '../lampiran/laporan/' . $_POST['file_laporan'];
            unlink($lokasiFile);
            $respon = [
                'title' => 'Berhasil!',
                'status' => 'success',
                'msg' => 'Silahkan Upload Ulang, Laporan Anda',
                'icon' => 'assets/images/notification/ok-48.png',
            ];
        } else {
            $respon = [
                'title' => 'Gagal!',
                'status' => 'warning',
                'msg' => 'Coba Lagi Untuk ReUpload Laporan',
                'icon' => 'assets/images/notification/high_priority-48.png',
            ];
        }

        echo json_encode($respon);
    }
}
