<?php

class Main
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getJurusanKelas()
    {
        $query = "select
                        jur.nama_jurusan,
                        count(kel.kelas_id) as jumlah_kelas 
                    from
                        jurusan jur
                    left join kelas kel on
                        jur.jurusan_id = kel.jurusan_id
                    group by 
                        jur.nama_jurusan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $jurusans = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $jurusans[] = $row;
        }

        return $jurusans;
    }

    public function getAllUser()
    {
        $query = "select
                        count(usr.user_id) as jumlah_user,
                        count(dp.pembimbing_id) as jumlah_pembimbing,
                        count(ds.siswa_id) as jumlah_siswa
                    from
                        user usr
                    left join detail_pembimbing dp on
                        usr.user_id = dp.user_id
                    left join detail_siswa ds on
                        usr.user_id = ds.user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAbsensi($siswa_id = null)
    {
        $whereSiswa = $siswa_id ? "where abs.siswa_id = $siswa_id" : "";
        $query = "select
                        count(case when abs.is_verified = 1 then abs.absensi_id end) as jumlah_absensi_verified,
                        count(case when abs.is_verified = 0 then abs.absensi_id end) as jumlah_absensi_unverified
                    from
                        absensi abs
                        $whereSiswa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLogbook($siswa_id = null)
    {
        $whereSiswa = $siswa_id ? "where log.siswa_id = $siswa_id" : "";
        $query = "select
                        count(case when log.is_verified = 1 then log.logbook_id end) as jumlah_logbook_verified,
                        count(case when log.is_verified = 0 then log.logbook_id end) as jumlah_logbook_unverified
                    from
                        logbook log
                        $whereSiswa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetailSiswa($siswa_id)
    {
        $query = "select
                    usr.username,
                    usr.email,
                    usr.user_id,
                    ds.nama_lengkap as nama_siswa,
                    ds.no,
                    ds.nis,
                    ds.jenis_kelamin,
                    ds.tempat_pkl,
                    ds.pimpinan_pkl,
                    kel.nama_kelas,
                    kel.kelas_id,
                    jur.nama_jurusan,
                    dp.nama_lengkap as nama_pembimbing
                from
                    detail_siswa ds
                left join kelas kel on
                    ds.kelas_id = kel.kelas_id
                left join user usr on
                    ds.user_id = usr.user_id
                left join jurusan jur on
                    kel.jurusan_id = jur.jurusan_id
                left join detail_pembimbing dp on
                    kel.pembimbing_id = dp.pembimbing_id
                where
                    ds.siswa_id = $siswa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
