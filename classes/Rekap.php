<?php

class Rekap
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getRekap($data = null)
    {
        $query = "SELECT
                    jur.nama_jurusan,
                    kel.nama_kelas,
                    dp.nama_lengkap as nama_pembimbing,
                    (
                    SELECT
                        COUNT(lo.logbook_id)
                    FROM
                        logbook lo
                    JOIN detail_siswa ds ON
                        lo.siswa_id = ds.siswa_id
                    WHERE
                        ds.kelas_id = kel.kelas_id
                        AND lo.is_verified = 1) AS jumlah_logbook_verif,
                        (
                    SELECT
                        COUNT(lo.logbook_id)
                    FROM
                        logbook lo
                    JOIN detail_siswa ds ON
                        lo.siswa_id = ds.siswa_id
                    WHERE
                        ds.kelas_id = kel.kelas_id
                        AND (lo.is_verified IS NULL
                            OR lo.is_verified = 0)) AS jumlah_logbook_unverif,
                        (
                    SELECT
                        COUNT(abs.absensi_id)
                    FROM
                        absensi abs
                    JOIN detail_siswa ds ON
                        abs.siswa_id = ds.siswa_id
                    WHERE
                        ds.kelas_id = kel.kelas_id
                        AND abs.is_verified = 1) AS jumlah_absensi_verif,
                        (
                    SELECT
                        COUNT(abs.absensi_id)
                    FROM
                        absensi abs
                    JOIN detail_siswa ds ON
                        abs.siswa_id = ds.siswa_id
                    WHERE
                        ds.kelas_id = kel.kelas_id
                        AND (abs.is_verified = 0
                            OR abs.is_verified IS NULL)) AS jumlah_absensi_unverif,
                        (
                    SELECT
                        COUNT(ds2.siswa_id)
                    FROM
                        detail_siswa ds2
                    WHERE
                        ds2.kelas_id = kel.kelas_id
                        AND ds2.verif_laporan = 1) AS jumlah_laporan_verif,
                    (
                    SELECT
                        COUNT(ds2.siswa_id)
                    FROM
                        detail_siswa ds2
                    WHERE
                        ds2.kelas_id = kel.kelas_id
                        AND (ds2.verif_laporan = 0
                            OR ds2.verif_laporan IS NULL)) AS jumlah_laporan_unverif,
                            (
                    SELECT
                        COUNT(ds.siswa_id)
                    FROM
                        detail_siswa ds
                    WHERE
                        ds.kelas_id = kel.kelas_id) AS jumlah_siswa
                FROM
                    jurusan jur
                JOIN kelas kel ON
                    jur.jurusan_id = kel.jurusan_id
                JOIN detail_pembimbing dp ON
                    kel.pembimbing_id = dp.pembimbing_id
                GROUP BY
                    jur.nama_jurusan,
                    kel.nama_kelas,
                    dp.nama_lengkap";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
