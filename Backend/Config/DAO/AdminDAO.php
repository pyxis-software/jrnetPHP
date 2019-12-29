<?php

class AdminDAO {

    private $admin;
    private $mysql;

    function __construct() {
        $this->mysql = new Mysql();
        $this->admin = new Admin();
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
    
    //Verifica existencia de admin
    public function verificaExist() {
        $sql = $this->mysql->select("admin", "*", "email = '".$this->admin->getEmail()."' AND senha = '".md5($this->admin->getSenha())."'");
        if(mysqli_num_rows($sql) > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //Cadastro
    public function cadastro() {
        $return = array();
        $return['erro'] = false;
        $return['msg'] = "";
        
        if(!$this->verificaExist()){
        
            $sql = $this->mysql->insere("admin", "email, senha", "'".$this->admin->getEmail()."', '".md5($this->admin->getSenha())."'");
            if($sql){
                $return['msg'] = "Cadastro Realizado Com Sucesso!";
            }else{
                $return['msg'] = "Não foi possível realizar o cadastro!";
                $return['erro'] = true;
            }
        }else{
            $return['msg'] = "Administrador já foi cadastrado!";
            $return['erro'] = true;
        }
        
        return $return;
    }

}
