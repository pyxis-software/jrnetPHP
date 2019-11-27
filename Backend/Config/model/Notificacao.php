<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notificacao
 *
 * @author Emerson Santos
 */
class Notificacao {
    private $id;
    private $tipo;
    private $msg;
    private $cliente;
    
    
    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }
    
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getMsg() {
        return $this->msg;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }
}
