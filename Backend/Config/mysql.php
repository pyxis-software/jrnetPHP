<?php
class Mysql{
    private $sql;
    private $erro;
    //
    private $host = "localhost";
    private $user = "padraoto_magento";
    private $pass = "messo18101995";
    private $db = "padraoto_magento";
    
    function __construct() {
        //$this->connect();
    }
    
    function getSql() {
        return $this->sql;
    }

    function setSql($sql) {
        $this->sql = $sql;
    }
    function getErro(){
        return mysqli_error($this->sql);
    }
    
    private function connect(){
        $this->sql = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    }
    
    private function disconect(){
        mysqli_close($this->sql);
    }
    
    /*FUNCIONALIDADES*/
    public function select($tabela,$todos=NULL,$where=NULL,$order=NULL){
        //inicia a conexão
        $this->connect();
        
        if($todos == NULL){
            $todos = "*";
        }
        if($where != NULL){
            $where = " WHERE ".$where;
        }
        if($order != NULL){
            $order = " ORDER BY ".$order;
        }
        $sql = "SELECT {$todos} FROM {$tabela}{$where}{$order}";
        $query = $this->sql->query($sql);
        //fecha a coneção
        $this->disconect();
        return $query;
    }
    
    //DELETE no banco de dados
    public function delete($tabela, $where){
        //inicia a classe
        $this->connect();
        //
        if($where != NULL){
            $where = " WHERE ".$where;
        }
        //criando a consulta
        $sql = "DELETE FROM {$tabela}{$where}";
        $query = $this->sql->query($sql);
        //fecha a coneção
        $this->disconect();
        return $query;
    }
    
    //UPDATE no banco de dados
    public function update($tabela,$valores,$where){
        //inicia a classe
        $this->connect();
        //
        if($where != NULL){
            $where = " WHERE ".$where;
        }
        //
        $sql = "UPDATE {$tabela} SET {$valores} {$where}";
        //executa a Query
        $query = $this->sql->query($sql);
        //fecha a coneção
        //$this->disconect();
        $this->erro = $query;
        return $query;
    }
    
    //INSERE no banco de dados
    public function insere($tabela,$campos,$valores){
        //inicia a classe
        $this->connect();
        //
        $sql = "INSERT INTO {$tabela}({$campos}) VALUES({$valores})";
        //executa a Query
        $query = $this->sql->query($sql);
        //fecha a coneção
        $this->disconect();
        return $query;
    }
}