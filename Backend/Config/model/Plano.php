<?php
class Plano{
    private $id;
    private $titulo;
    private $desc;
    private $valor;
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDesc() {
        return $this->desc;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDesc($desc) {
        $this->desc = $desc;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }
    
}