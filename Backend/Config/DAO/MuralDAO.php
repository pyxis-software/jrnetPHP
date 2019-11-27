<?php
class MuralDAO{
    private $mysql;
    private $mural;
    
    function __construct() {
        $this->mysql = new Mysql();
        $this->mural = new Mural();
    }
    
    function setMural($mural) {
        $this->mural = $mural;
    }
    
    //Retorna todos os murais
    public function murais() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $retorno['murais'] = array();
        $sql = $this->mysql->select("mural", "*","","id DESC");
        while($info = mysqli_fetch_array($sql)){
            $retorno['murais'][] = array(
                'id' => $info['id'],
                'titulo' => utf8_decode($info['titulo']),
                'descricao' => utf8_decode($info['descricao'])
            );
        }
        echo json_encode($retorno, true);
    }
    
    //Cadastrando Mural
    public function cadastra() {
        $sql = $this->mysql->insere("mural", "titulo, descricao", "'" . $this->mural->getTitulo()."', '" . $this->mural->getDesc()."'");
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //Editar Mural
    public function editarMural() {
        $sql = $this->mysql->update("mural", "titulo = '".$this->mural->getTitulo()."', descricao = '".$this->mural->getDesc()."'", "id = " . $this->mural->getId());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //Excluir Mural
    public function excluirMural() {
        $sql = $this->mysql->delete("mural", "id = " . $this->mural->getId());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //Buscando dados do mural
    public function getDados() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        
        //
        $sql = $this->mysql->select("mural", "*", "id = " . $this->mural->getId());
        if(mysqli_num_rows($sql) > 0){
            
            while ($mural = mysqli_fetch_array($sql)){
                $retorno['dados'] = array(
                    'id' => utf8_decode( $mural['id'] ),
                    'titulo' => utf8_decode( $mural['titulo'] ),
                    'desc' => utf8_decode( $mural['descricao'] )
                );
            }
            
            
        }else{
            $retorno['erro'] = true;
            $retorno['msg'] = "Mural Não Encontrado!";
        }
        return $retorno;
    }
    
    //Busca todos os clientes
    public function getClientes() {
        $retorno = array();
        $sql = $this->mysql->select("cliente", "*", "ativo = 1");
        while($cliente = mysqli_fetch_array($sql)){
            $cpf = str_replace(".", "", $cliente['cpf']);
            $cpf = str_replace("-", "", $cpf);
            $retorno[] = $cpf;
        }
        return $retorno;
    }
    
    
}