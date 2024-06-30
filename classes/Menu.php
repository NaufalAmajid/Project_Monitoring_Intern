<?php

class Menu
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function read($status_user_id)
    {

        $query = "SELECT 
                    men.direktori AS dir_menu, 
                    sub.direktori AS dir_submenu, 
                    men.*, 
                    sub.*, 
                    ham.* 
                FROM 
                    menu men 
                    LEFT JOIN submenu sub ON men.menu_id = sub.menu_id 
                    LEFT JOIN hak_akses_menu ham ON men.menu_id = ham.menu_id 
                WHERE 
                    ham.status_user_id = $status_user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $menu = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (is_null($row['submenu_id'])) {
                $menu[$row['menu_id']]['nama_menu'] = $row['nama_menu'];
                $menu[$row['menu_id']]['direktori'] = $row['dir_menu'];
            } else {
                $menu[$row['menu_id']]['nama_menu'] = $row['nama_menu'];
                $menu[$row['menu_id']]['submenu'][] = [
                    'nama_submenu' => $row['nama_submenu'],
                    'direktori' => $row['dir_submenu']
                ];
            }
        }

        return $menu;
    }
}
