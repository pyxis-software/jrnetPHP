<?php
class PlanosDAO{
    private $mysql;
    private $cpf;
    public $plano;
    function __construct() {
        $this->mysql = new Mysql();
        $this->plano = new Plano();
    }
    
    function getPlano() {
        return $this->plano;
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }
    
    //Retorna os plano
    public function planos($cpf){
        $this->cpf = $cpf;
        //buscando os dados do cliente
        $retorno = array();
        $retorno['erro'] = false;
        $idPlano = 0;
        $sql = $this->mysql->select("cliente", "*", "cpf = '".$this->cpf."'");
        if(mysqli_num_rows($sql) > 0){
            while($cliente = mysqli_fetch_array($sql)){
                $idPlano = $cliente['plano'];
            }
            
            //Buscando todos os planos
            $sqlPlano = $this->mysql->select("planos", "*", "", "valor ASC");
            if(mysqli_num_rows($sqlPlano) > 0){
                
                while($plano = mysqli_fetch_array($sqlPlano)){
                    if($idPlano == $plano['id']){
                        $meuPlano = true;
                    }else{
                        $meuPlano = false;
                    }
                    $retorno['planos'][] = array(
                        'id' => $plano['id'],
                        'titulo' => utf8_decode($plano['titulo']),
                        'descricao' => utf8_decode($plano['descricao']),
                        'valor' => $plano['valor'],
                        'plano' => $meuPlano
                    );
                }
                
            }else{
                $retorno['erro'] = true;
            }
        }else{
            $retorno['erro'] = true;
        }
        echo json_encode($retorno, true);
    }
    
    //Cadastra novo Plano
    public function cadastraPlano(){
        $sql = $this->mysql->insere("planos", "titulo, descricao, valor", "'".$this->plano->getTitulo()."','".$this->plano->getDesc()."',".$this->plano->getValor());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //Exclui Plano
    public function excluiPlano() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $retorno['usuarios'] = array();
        //buscando os clientes com esse plano
        $sqlClientes = $this->mysql->select("cliente", "*", "plano = " . $this->plano->getId());
        if(mysqli_num_rows($sqlClientes) == 0){
            $sql = $this->mysql->delete("planos", "id = " . $this->plano->getId());
            if(!$sql){
                $retorno['erro'] = true;
            }
        }else{
            $retorno['erro'] = true;
            $retorno['msg'] = "Você tem clientes cadastrados com esse Plano.<br />Por favor, altere os planos dos clientes abaixo:<br />";
            //Busca todos os cliente com o plano a ser excluido
            while ($cliente = mysqli_fetch_array($sqlClientes)){
                $retorno['usuarios'][] = $cliente['nome'];
            }
        }
        
        //retornando as informações
        return $retorno;
    }
    
    //Dados do plano
    public function plano() {
        $sql = $this->mysql->select("planos", "*", "id = '" . $this->plano->getId()."'");
        while($plano = mysqli_fetch_array($sql)){
            $this->plano->setTitulo($plano['titulo']);
            $this->plano->setValor($plano['valor']);
            $this->plano->setDesc($plano['descricao']);
        }
        return $this->plano;
    }
    
    //Busca dados de plano
    public function dadosPlano() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $sql = $this->mysql->select("planos", "*", "id = '" . $this->plano->getId()."'");
        if(mysqli_num_rows($sql) > 0){
            while($plano = mysqli_fetch_array($sql)){
                $retorno['dados'] = array(
                    'id' => utf8_decode($plano['id']),
                    'titulo' => utf8_decode($plano['titulo']),
                    'desc' => utf8_decode($plano['descricao']),
                    'valor' => $plano['valor']
                );
            }
        }else{
            $retorno['erro'] = true;
            $retorno['msg'] = "Plano Não Encontrado!";
        }
        
        return $retorno;
    }
    
    //Edita o plano
    public function editaPlano() {
        $sql = $this->mysql->update("planos", "titulo='".$this->plano->getTitulo()."', descricao = '".$this->plano->getDesc()."', valor = '".$this->plano->getValor()."'", "id = " . $this->plano->getId());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //Busca todos os planos
    public function getPlanos($idPlano) {
        $sql = $this->mysql->select("planos", "*", "id != $idPlano");
        while($plano = mysqli_fetch_array($sql)){
            echo '<option value="'.$plano['id'].'">' . $plano['titulo'].'</option>';
        }
    }
    
    //busca o nome do plano
    public function nomePlano($id) {
        $sql = $this->mysql->select("planos", "*", "id = $id");
        $dados = mysqli_fetch_array($sql);
        return $dados['titulo'];
    }
}