<?php

class Siswa
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllSiswa()
    {
        $query = "select
                    us.username,
                    us.email,
                    kel.kelas_id,
                    kel.nama_kelas,
                    jur.nama_jurusan,
                    dp.nama_lengkap as nama_pembimbing,
                    ds.*
                from
                    detail_siswa ds
                left join user us on
                    ds.user_id = us.user_id
                left join kelas kel on ds.kelas_id = kel.kelas_id
                left join jurusan jur on kel.jurusan_id = jur.jurusan_id
                left join detail_pembimbing dp on kel.pembimbing_id = dp.pembimbing_id
                where
                    us.is_active = 1
                order by
                    nama_lengkap asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $siswa = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $siswa[] = $row;
        }

        return $siswa;
    }
}
