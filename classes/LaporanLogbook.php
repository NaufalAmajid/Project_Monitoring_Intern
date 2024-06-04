<?php
date_default_timezone_set('Asia/Jakarta');
class LaporanLogbook
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllLogbookBySiswaId($siswa_id, $tgl1, $tgl2)
    {
        $query = "select
                        convert(log.created_at, time) as jam,
                        convert(log.created_at, date) as hari,
                        log.*
                    from
                        logbook log
                    where
                        cast(log.created_at as date) between '$tgl1' and '$tgl2'
                        and log.siswa_id = $siswa_id
                        order by cast(log.created_at as date) desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}
