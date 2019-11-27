<?php
class Mural{
    private $id;
    private $titulo;
    private $desc;
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDesc() {
        return $this->desc;
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
}