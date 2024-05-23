<?php

class Jurusan
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllJurusan($params = '')
    {
        $where = $params != '' ? "where jur.nama_jurusan LIKE '%$params%' " : '';
        $query = "select
                    jur.jurusan_id,
                    jur.nama_jurusan,
                    kel.kelas_id,
                    kel.nama_kelas,
                    dp.nama_lengkap as nama_pembimbing,
                    dp.pembimbing_id,
                    jur.is_active as is_active_jurusan,
                    kel.is_active as is_active_kelas,
                    count(ds.siswa_id) as jumlah_siswa
                from
                    jurusan jur
                left join kelas kel on
                    jur.jurusan_id = kel.jurusan_id
                left join detail_siswa ds on
                    kel.kelas_id = ds.kelas_id
                left join detail_pembimbing dp on
                    kel.pembimbing_id = dp.pembimbing_id
                $where
                group by
                    jur.jurusan_id,
                    jur.nama_jurusan,
                    kel.kelas_id,
                    kel.nama_kelas,
                    dp.nama_lengkap,
                    dp.pembimbing_id,
                    jur.is_active,
                    kel.is_active
                order by
                    jur.is_active desc, jur.nama_jurusan asc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $jurusans = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (is_null($row['kelas_id'])) {
                $jurusans[$row['jurusan_id']]['nama_jurusan'] = $row['nama_jurusan'];
                $jurusans[$row['jurusan_id']]['is_active'] = $row['is_active_jurusan'];
            } else {
                $jurusans[$row['jurusan_id']]['nama_jurusan'] = $row['nama_jurusan'];
                $jurusans[$row['jurusan_id']]['is_active'] = $row['is_active_jurusan'];
                $jurusans[$row['jurusan_id']]['kelas'][] = [
                    'kelas_id' => $row['kelas_id'],
                    'nama_kelas' => $row['nama_kelas'],
                    'is_active' => $row['is_active_kelas'],
                    'jumlah_siswa' => $row['jumlah_siswa'],
                    'nama_pembimbing' => $row['nama_pembimbing'],
                    'pembimbing_id' => $row['pembimbing_id']
                ];
            }
        }

        return $jurusans;
    }

    public function getKelasByJurusan($jurusan_id)
    {
        $query = "select * from kelas where jurusan_id = $jurusan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $kelas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kelas[] = $row;
        }

        return $kelas;
    }

    public function addJurusan($data)
    {
        $db = DB::getInstance();
        return $db->add('jurusan', $data);
    }

    public function editJurusan($table, $data, $where)
    {
        $db = DB::getInstance();
        return $db->update($table, $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    $jurusan = new Jurusan();

    if ($_POST['action'] == 'add') {
        $data = [
            'nama_jurusan' => $_POST['nama_jurusan']
        ];
        $result = $jurusan->addJurusan($data);
        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'edit') {
        $data = [
            'nama_jurusan' => $_POST['nama_jurusan']
        ];
        $where = [
            'jurusan_id' => $_POST['jurusan_id']
        ];
        $result = $jurusan->editJurusan('jurusan', $data, $where);
        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'editAktif') {
        $data = [
            'is_active' => $_POST['status']
        ];
        $where = [
            'jurusan_id' => $_POST['jurusan_id']
        ];
        $kelas = $jurusan->getKelasByJurusan($_POST['jurusan_id']);
        if (count($kelas) > 0) {
            foreach ($kelas as $kelas) {
                $result = $jurusan->editJurusan('kelas', $data, ['kelas_id' => $kelas['kelas_id']]);
            }

            $result = $jurusan->editJurusan('jurusan', $data, $where);
        } else {
            $result = $jurusan->editJurusan('jurusan', $data, $where);
        }

        if ($result > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
