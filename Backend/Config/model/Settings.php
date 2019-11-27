<?php
class Settings{
    private $id;
    private $dias_venc;
    private $token;
    private $email;
    private $ende;
    private $desc;
    private $tel;
    
    function getEmail() {
        return $this->email;
    }

    function getEnde() {
        return $this->ende;
    }

    function getDesc() {
        return $this->desc;
    }

    function getTel() {
        return $this->tel;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setEnde($ende) {
        $this->ende = $ende;
    }

    function setDesc($desc) {
        $this->desc = $desc;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }
    
    function getToken() {
        return $this->token;
    }

    function setToken($token) {
        $this->token = $token;
    }

        
    function getId() {
        return $this->id;
    }

    function getDias_venc() {
        return $this->dias_venc;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDias_venc($dias_venc) {
        $this->dias_venc = $dias_venc;
    }


}