<?php
date_default_timezone_set('Asia/Jakarta');

class DaftarSiswa
{
	private $conn;

	public function __construct()
	{
		$this->conn = DB::getInstance()->connection();
	}

	public function getAllSiswaByPembimbingId($pembimbing_id)
	{
		$query = "select
					ds.siswa_id,
					ds.nama_lengkap as nama_siswa,
					ds.jenis_kelamin,
					ds.tempat_pkl,
					ds.nis,
					kel.nama_kelas,
					jur.nama_jurusan,
					count(case when abs.is_verified = 1 then abs.absensi_id end) as jumlah_absensi_verified,
					count(case when abs.is_verified = 0 then abs.absensi_id end) as jumlah_absensi_unverified,
					count(case when log.is_verified = 1 then log.logbook_id end) as jumlah_logbook_verified,
					count(case when log.is_verified = 0 then log.logbook_id end) as jumlah_logbook_unverified
				from
					detail_siswa ds
				left join kelas kel on
					ds.kelas_id = kel.kelas_id
				left join jurusan jur on
					kel.jurusan_id = jur.jurusan_id
				left join logbook log on
					ds.siswa_id = log.siswa_id
				left join absensi abs on
					ds.siswa_id = abs.siswa_id
				where 
					kel.pembimbing_id = 1
				group by
					ds.siswa_id,
					ds.nama_lengkap,
					ds.jenis_kelamin,
					ds.tempat_pkl,
					ds.nis,
					kel.nama_kelas,
					jur.nama_jurusan";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$data = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}

		return $data;
	}
}
