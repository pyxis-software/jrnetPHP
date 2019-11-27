<?php

class AdminDAO {

    private $admin;
    private $mysql;

    function __construct() {
        $this->mysql = new Mysql();
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    function getAdmin() {
        return $this->admin;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }

    private function buscaDados($session) {
        $sql = $this->mysql->select("admin", "*", "email = '$session'");
        $ad = new Admin();
        while ($admin = mysqli_fetch_array($sql)) {
            $ad->setEmail($admin['email']);
            $ad->setId($admin['id']);
            $ad->setSenha($admin['senha']);
        }
        return $ad;
    }

    public function verificaAdmin() {
        if (isset($_SESSION['email'])) {
            return $this->buscaDados($_SESSION['email']);
        } else {
            echo "<script>location.href='../../login';</script>";
        }
    }

    public function criaSessao() {
        $_SESSION['email'] = $this->admin->getEmail();
    }

    public function login() {
        $return = array();
        $return['erro'] = false;
        $return['msg'] = "";
        $senha = md5($this->admin->getSenha());
        $sql = $this->mysql->select("admin", "*", "email = '" . $this->admin->getEmail() . "' AND senha = '$senha'");
        if (mysqli_num_rows($sql) == 0) {
            $return['erro'] = true;
            $return['msg'] = "Verifique os dados informados!";
        }
        return $return;
    }

}
