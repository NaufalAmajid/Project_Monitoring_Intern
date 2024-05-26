<?php

class Login
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function login($data)
    {
        $password = md5($data['password']);

        $query = "select
                    case
                        when dp.pembimbing_id is null then ds.siswa_id
                        else dp.pembimbing_id
                    end as the_id,
                    case
                        when dp.pembimbing_id is null then ds.nama_lengkap
                        else dp.nama_lengkap
                    end as nama,
                    usr.username,
                    usr.user_id,
                    usr.email,
                    usr.status_user_id,
                    su.nama_status_user
                from
                    user usr
                left join status_user su on
                    usr.status_user_id = su.status_user_id 
                left join detail_pembimbing dp on
                    dp.user_id = usr.user_id
                left join detail_siswa ds on
                    usr.user_id = ds.user_id
                where
                    (usr.username = '$data[email_username]'
                        or usr.email = '$data[email_username]')
                    and usr.password = '$password'
                    and usr.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
        return $query;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/database.php';
    require_once '../classes/DB.php';
    $login = new Login();

    if ($_POST['action'] == 'login') {
        $data = [
            'email_username' => $_POST['email_username'],
            'password' => $_POST['password'],
        ];

        $login = $login->login($data);

        if ($login) {
            session_start();
            $_SESSION['user_id'] = $login['user_id'];
            $_SESSION['the_id'] = $login['the_id'];
            $_SESSION['nama'] = $login['nama'] ? $login['nama'] : $login['username'];
            $_SESSION['username'] = $login['username'];
            $_SESSION['email'] = $login['email'];
            $_SESSION['status_user_id'] = $login['status_user_id'];
            $_SESSION['nama_status_user'] = $login['nama_status_user'];
            $_SESSION['is_login'] = true;

            echo 'success';
        } else {
            echo 'failed';
        }
    }

    if ($_POST['action'] == 'logout') {
        session_start();
        session_destroy();
        echo 'success';
    }
}
