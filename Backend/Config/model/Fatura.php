<?php
class Fatura{
    private $id;
    private $data;
    private $status;
    private $payment_id;
    private $vencimento;
    private $valor;
    private $clienteID;
    private $link;
    private $barcode;
    
    function getBarcode() {
        return $this->barcode;
    }

    function setBarcode($barcode) {
        $this->barcode = $barcode;
    }    
    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getStatus() {
        return $this->status;
    }

    function getPayment_id() {
        return $this->payment_id;
    }

    function getVencimento() {
        return $this->vencimento;
    }

    function getValor() {
        return $this->valor;
    }

    function getClienteID() {
        return $this->clienteID;
    }

    function getLink() {
        return $this->link;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setPayment_id($payment_id) {
        $this->payment_id = $payment_id;
    }

    function setVencimento($vencimento) {
        $this->vencimento = $vencimento;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setClienteID($clienteID) {
        $this->clienteID = $clienteID;
    }

    function setLink($link) {
        $this->link = $link;
    }
    
    public function salvaFatura($sql) {
        $this->clienteID = $sql['idCliente'];
        $this->data = $sql['lancamento'];
        $this->status = $sql['status'];
        $this->payment_id = $sql['payment_id'];
        $this->vencimento = $sql['vencimento'];
        $this->valor = $sql['valor'];
        $this->id = $sql['id'];
        $this->link = $sql['link'];
    }
}