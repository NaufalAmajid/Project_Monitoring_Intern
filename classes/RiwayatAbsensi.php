<?php
date_default_timezone_set('Asia/Jakarta');

class RiwayatAbsensi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function verifAbsensi($absensi_id)
    {
        $query = "update absensi set is_verified = 1 where absensi_id = $absensi_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function getAbsensiSiswaToday($pembimbing_id)
    {
        $date = date('Y-m-d');
        $query = "select
                    abs.absensi_id,
                    abs.masuk,
                    abs.keluar,
                    abs.lampiran_masuk,
                    abs.lampiran_keluar,
                    abs.is_verified,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan
                from
                    absensi abs
                left join detail_siswa ds on
                    abs.siswa_id = ds.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where 
                    kel.pembimbing_id = $pembimbing_id
                    and cast(abs.hari as date) = '$date'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatAbsensiToday = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatAbsensiToday[] = $row;
        }
        return $riwayatAbsensiToday;
    }

    public function getAbsensiSiswaUnverif($pembimbing_id, $tgl1, $tgl2)
    {
        $query = "select
                    abs.absensi_id,
                    abs.masuk,
                    abs.keluar,
                    abs.lampiran_masuk,
                    abs.lampiran_keluar,
                    abs.is_verified,
                    abs.hari,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan
                from
                    absensi abs
                left join detail_siswa ds on
                    abs.siswa_id = ds.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where 
                    kel.pembimbing_id = $pembimbing_id
                    and abs.is_verified = 0 
                    and cast(abs.hari as date) between '$tgl1' and '$tgl2'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatAbsensiUnverif = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatAbsensiUnverif[] = $row;
        }
        return $riwayatAbsensiUnverif;
    }

    public function getAbsensiSiswaAll($pembimbing_id, $tgl1, $tgl2)
    {
        $query = "select
                    abs.absensi_id,
                    abs.masuk,
                    abs.keluar,
                    abs.lampiran_masuk,
                    abs.lampiran_keluar,
                    abs.is_verified,
                    abs.hari,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan
                from
                    absensi abs
                left join detail_siswa ds on
                    abs.siswa_id = ds.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where 
                    kel.pembimbing_id = $pembimbing_id
                    and cast(abs.hari as date) between '$tgl1' and '$tgl2'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatAbsensiAll = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatAbsensiAll[] = $row;
        }
        return $riwayatAbsensiAll;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';

    $riwayatAbsensi = new RiwayatAbsensi();

    if ($_POST['action'] == 'verif') {
        $absensi_id = $_POST['absensi_id'];
        $verif = $riwayatAbsensi->verifAbsensi($absensi_id);
        if ($verif) {
            echo json_encode(['status' => 'success', 'title' => 'Berhasil', 'message' => 'Absensi berhasil diverifikasi']);
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal', 'message' => 'Absensi gagal diverifikasi']);
        }
    }
}
