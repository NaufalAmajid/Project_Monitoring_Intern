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
					ds.nilai,
					ds.nama_lengkap as nama_siswa,
					ds.jenis_kelamin,
					ds.tempat_pkl,
					ds.pimpinan_pkl,
					ds.nis,
					ds.selesai_pkl,
					ds.laporan,
					ds.verif_laporan,
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
					kel.pembimbing_id = $pembimbing_id
				group by
					ds.siswa_id,
					ds.nama_lengkap,
					ds.nilai,
					ds.jenis_kelamin,
					ds.tempat_pkl,
					ds.pimpinan_pkl,
					ds.nis,
					ds.selesai_pkl,
					ds.laporan,
					ds.verif_laporan,
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

	public function addNilai($data, $where)
	{
		$db = DB::getInstance();
		return $db->update('detail_siswa', $data, $where);
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once '../config/database.php';
	require_once '../classes/DB.php';

	$daftarSiswa = new DaftarSiswa();
	if ($_POST['action'] == 'addNilai') {
		$data = [
			'nilai' => $_POST['nilai']
		];
		$where = [
			'siswa_id' => $_POST['siswa_id']
		];

		$result = $daftarSiswa->addNilai($data, $where);
		if ($result > 0) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}

	if ($_POST['action'] == 'changeStatusPKL') {
		$data = [
			'selesai_pkl' => 1
		];
		$where = [
			'siswa_id' => $_POST['siswa_id']
		];

		$result = $daftarSiswa->addNilai($data, $where);
		if ($result > 0) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
	
	if ($_POST['action'] == 'verifLaporan') {
		$data = [
			'verif_laporan' => 1
		];
		$where = [
			'siswa_id' => $_POST['siswa_id']
		];

		$result = $daftarSiswa->addNilai($data, $where);
		if ($result > 0) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
}
