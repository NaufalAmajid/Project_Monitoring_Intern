<?php
date_default_timezone_set('Asia/Jakarta');
class LaporanAbsensi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
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
