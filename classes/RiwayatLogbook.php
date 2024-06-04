<?php
date_default_timezone_set('Asia/Jakarta');

class RiwayatLogbook
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function verifLogbook($logbook_id)
    {
        $query = "update logbook set is_verified = 1 where logbook_id = $logbook_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function getLogbookSiswaToday($pembimbing_id)
    {
        $date = date('Y-m-d');
        $query = "select
                    log.logbook_id,
                    log.catatan,
                    log.lampiran,
                    log.is_verified,
                    convert(log.created_at, time) as jam,
                    convert(log.created_at, date) as hari,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan 
                from
                    logbook log
                left join detail_siswa ds on
                    ds.siswa_id = log.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where
                    kel.pembimbing_id = $pembimbing_id
                    and cast(log.created_at as date) = '$date'
                order by log.created_at asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatLogbookToday = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatLogbookToday[] = $row;
        }
        return $riwayatLogbookToday;
    }

    public function getLogbookSiswaUnverified($pembimbing_id, $tgl1, $tgl2)
    {
        $query = "select
                    log.logbook_id,
                    log.catatan,
                    log.lampiran,
                    log.is_verified,
                    convert(log.created_at, time) as jam,
                    convert(log.created_at, date) as hari,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan 
                from
                    logbook log
                left join detail_siswa ds on
                    ds.siswa_id = log.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where
                    kel.pembimbing_id = $pembimbing_id
                    and cast(log.created_at as date) between '$tgl1' and '$tgl2'
                    and log.is_verified = 0
                order by log.created_at asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatLogbookUnverif = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatLogbookUnverif[] = $row;
        }
        return $riwayatLogbookUnverif;
    }

    public function getLogbookSiswaAll($pembimbing_id, $tgl1, $tgl2)
    {
        $query = "select
                    log.logbook_id,
                    log.catatan,
                    log.lampiran,
                    log.is_verified,
                    convert(log.created_at, time) as jam,
                    convert(log.created_at, date) as hari,
                    ds.nama_lengkap as nama_siswa,
                    ds.nis,
                    kel.nama_kelas,
                    jur.nama_jurusan 
                from
                    logbook log
                left join detail_siswa ds on
                    ds.siswa_id = log.siswa_id
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                where
                    kel.pembimbing_id = $pembimbing_id
                    and cast(log.created_at as date) between '$tgl1' and '$tgl2'
                order by log.created_at asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $riwayatLogbookAll = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $riwayatLogbookAll[] = $row;
        }
        return $riwayatLogbookAll;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';

    $riwayatLogbook = new RiwayatLogbook();

    if ($_POST['action'] == 'verif') {
        $logbook_id = $_POST['logbook_id'];
        $verif = $riwayatLogbook->verifLogbook($logbook_id);
        if ($verif) {
            echo json_encode(['status' => 'success', 'title' => 'Berhasil', 'message' => 'Logbook berhasil diverifikasi']);
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Gagal', 'message' => 'Logbook gagal diverifikasi']);
        }
    }
}
