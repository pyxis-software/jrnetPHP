<?php
class Cliente{
    private $CPF;
    private $id;
    private $nome;
    private $endereco;
    private $plano;
    private $senha;
    private $email;
    private $cidade;
    private $ativo;
    private $diaPagamento;
    private $celPrincipal;
    private $celSecundario;
    
    function __construct() {
        
    }
    function getCPF() {
        return $this->CPF;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getPlano() {
        return $this->plano;
    }

    function getSenha() {
        return $this->senha;
    }

    function getEmail() {
        return $this->email;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function getDiaPagamento() {
        return $this->diaPagamento;
    }

    function getCelPrincipal() {
        return $this->celPrincipal;
    }

    function getCelSecundario() {
        return $this->celSecundario;
    }

    function setCPF($CPF) {
        $this->CPF = $CPF;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setDiaPagamento($diaPagamento) {
        $this->diaPagamento = $diaPagamento;
    }

    function setCelPrincipal($celPrincipal) {
        $this->celPrincipal = $celPrincipal;
    }

    function setCelSecundario($celSecundario) {
        $this->celSecundario = $celSecundario;
    }
}