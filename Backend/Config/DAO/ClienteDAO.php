<?php
class ClienteDAO {
    private $mysql;
    private $cliente;
    private $functions;

    function __construct(Cliente $cliente) {
        $this->mysql = new Mysql();
        $this->cliente = $cliente;
        $this->functions = new Functions();
    }
    function getMysql() {
        return $this->mysql;
    }

    function getFunctions() {
        return $this->functions;
    }

    function setMysql($mysql) {
        $this->mysql = $mysql;
    }

    function setFunctions($functions) {
        $this->functions = $functions;
    }
    
    function setCliente($cliente){
        $this->cliente = $cliente;
    }
    /* FUNCIONALIDADES DO CLIENTE */

    //Busca o ID do cliente
    private function getIDCliente() {
        //Aqui
        $sql = $this->mysql->select("cliente", "*", "cpf = '" . $this->cliente->getCPF() . "' AND nome = '" . $this->cliente->getNome() . "'");
        if (mysqli_num_rows($sql) > 0) {
            $dados = mysqli_fetch_array($sql);
            $this->cliente->setId($dados['id']);
            return $dados['id'];
        } else {
            echo 'Erro interno do banco de dados';
        }
    }
    
    private function cliente($c){
        $cliente = new Cliente();
        $cliente->setAtivo($c['ativo']);
        $cliente->setCPF( $c['cpf'] );
        $cliente->setCidade( $c['cidade'] );
        $cliente->setEmail( $c['email'] );
        $cliente->setEndereco($c['endereco'] );
        $cliente->setId($c['id']);
        $cliente->setNome( $c['nome'] );
        $plano = new Plano();
        $plano->setId($c['plano']);
        $PlanoDAO = new PlanosDAO();
        $PlanoDAO->setPlano($plano);
        $cliente->setPlano($PlanoDAO->plano());
        $cliente->setSenha($c['senha']);
        $cliente->setCelPrincipal($c['cel_principal']);
        $cliente->setCelSecundario($c['cel_secundario']);
        $cliente->setDiaPagamento($c['dia_pagamento']);
        return $cliente;
    }
    
    public function povoaClienteCPF() {
        $sql = $this->mysql->select("cliente", "*", "cpf = '" . $this->cliente->getCPF()."'");
        if(mysqli_num_rows($sql) > 0){
            $cliente = null;
            while($c = mysqli_fetch_array($sql)){
                $cliente = $this->cliente($c);
            }
            return $cliente;
        }else{
            return null;
        }
    }
    
    //Busca os dados de um cliente
    public function getCliente() {
        $sql = $this->mysql->select("cliente", "*", "id = " . $this->cliente->getId());
        if(mysqli_num_rows($sql) > 0){
            $cliente = null;
            while($c = mysqli_fetch_array($sql)){
                $cliente = $this->cliente($c);
            }
            return $cliente;
        }else{
            return null;
        }
    }

    //verifica se o cpf está cadastrado
    private function verCPF() {
        $sql = $this->mysql->select("cliente", "*", "cpf = '" . $this->cliente->getCPF() . "'");
        if (mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function verificaSenhaAntiga() {
        $senha = "";
        $sql = $this->mysql->select("cliente", "*", "cpf = '" . $this->cliente->getCPF(). "'");
        while($cliente = mysqli_fetch_array($sql)){
            $senha = $cliente['senha'];
        }
        
        //verificando se a senha é igual
        if(md5($this->cliente->getSenha()) == $senha){
            return true;
        }else{
            return false;
        }
    }
    
    public function alteraSenha() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "Senha alterada com sucesso!";
        $sql = $this->mysql->update("cliente", "senha = '".md5($this->cliente->getSenha())."'", "cpf = '".$this->cliente->getCPF()."'");
        
        if(!$sql){
            $retorno['erro'] = true;
            $retorno['msg'] = "Não conseguimos alterar!";
        }
        echo json_encode($retorno, true);
    }

    public function cadastraCliente() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "Cadastro efetuado com sucesso!";
        
        if($this->functions->verificaEmail($this->cliente->getEmail()) && $this->functions->validaCPF($this->cliente->getCPF())){
            //verifica se já tem alguém cadastrado com o CPF
            if (!$this->verCPF()) {
                if($this->cliente->getCelSecundario() == ""){
                    $sql = $this->mysql->insere("cliente", "nome, cpf, endereco, plano, ativo, senha, email, cel_principal, cidade, dia_pagamento", "'".$this->cliente->getNome()."', '".$this->cliente->getCPF()."', '".$this->cliente->getEndereco(). "', '". $this->cliente->getPlano()."', '" . $this->cliente->getAtivo()."', '".$this->cliente->getSenha()."', '".$this->cliente->getEmail()."', '".$this->cliente->getCelPrincipal()."', '".$this->cliente->getCidade()."', ".$this->cliente->getDiaPagamento()."");
                }else{
                    $sql = $this->mysql->insere("cliente", "nome, cpf, endereco, plano, ativo, senha, email, cel_principal, cel_secundario, cidade, dia_pagamento", "'".$this->cliente->getNome()."', '".$this->cliente->getCPF()."', '".$this->cliente->getEndereco(). "', '". $this->cliente->getPlano()."', '" . $this->cliente->getAtivo()."', '".$this->cliente->getSenha()."', '".$this->cliente->getEmail()."', '".$this->cliente->getCelPrincipal()."', '".$this->cliente->getCelSecundario()."', '".$this->cliente->getCidade()."', ".$this->cliente->getDiaPagamento()."");
                }
                if (!$sql) {
                    //Erro ao adicionar o novo cliente
                    $retorno['erro'] = true;
                    $retorno['msg'] = "Erro ao adicionar cliente!";
                }
            }else{
                $retorno['erro'] = true;
                $retorno['msg'] = "Cliente já está cadastrado!";
            }
        
        }else{
            $retorno['erro'] = true;
            $retorno['msg'] = "E-mail ou CPF informado é inválido ou vazio!";
        }
        echo json_encode($retorno, true);
    }

    //Busca os telefones do cliente
    private function getTelefones($id) {
        $sql = $this->mysql->select("telefone", "*", "idCliente = $id");
        $telefones = array();
        while ($telefone = mysqli_fetch_array($sql)) {
            $telefones[] = utf8_decode($telefone['telefone']);
        }
        return $telefones;
    }

    //Excluir cliente
    public function removerCliente() {
        $retorno['erro'] = false;
        $retorno['msg'] = "";

        $sql = $this->mysql->delete("cliente", "id = " . $this->cliente->getId());
        if (!$sql) {
            $retorno['erro'] = true;
            $retorno['msg'] = "Erro ao excluir cliente!";
        }
        return $retorno;
    }
    
    //Ativa cliente
    public function ativaCliente() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $sql = $this->mysql->update("cliente", "ativo = 1", "id = " . $this->cliente->getId());
        if(!$sql){
            $retorno['erro'] = true;
            $retorno['msg'] = "Erro ao ativar cliente!";
        }
        return $retorno;
    }

    //Todos os clientes
    public function getClientes() {
        $result = array();
        $result['result'] = array();
        $result['msg'] = "";
        $sql = $this->mysql->select("cliente");
        if (mysqli_num_rows($sql) > 0) {
            $result['erro'] = false;
            while ($clientes = mysqli_fetch_array($sql)) {
                $result['result'][] = array(
                    'nome' => $clientes['nome'],
                    'id' => $clientes['id'],
                    'cpf' => $clientes['cpf'],
                    'endereco' => $clientes['endereco'],
                    'telefone' => $this->getTelefones($clientes['id'])
                );
            }
        } else {
            $result['erro'] = true;

            $result['msg'] = "Nenhum cliente encontrado!";
        }
        return $result;
    }
    
    
    /*Login cliente*/
    public function loginUser(){
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $senha = md5($this->cliente->getSenha());
        $sql = $this->mysql->select("cliente", "*", "cpf = '" . $this->cliente->getCPF() . "' AND senha = '$senha'");
        if(mysqli_num_rows($sql) == 0){
            $retorno['erro'] = true;
            $retorno['msg'] = "Verifique seus dados!";
        }else{
            
            while($cliente = mysqli_fetch_array($sql)){
                $telefones = array();
                $telefones[] = $cliente['cel_principal'];
                $telefones[] = $cliente['cel_secundario'];
                
                if($cliente['ativo'] == 1){
                    $retorno['result'] = array(
                        'id' => $cliente['id'],
                        'nome' => $cliente['nome'],
                        'cpf' => $cliente['cpf'],
                        'endereco' => $cliente['endereco'],
                        'cidade' => $cliente['cidade'],
                        'plano' => $cliente['plano'],
                        'telefones' => $telefones,
                        'email' => $cliente['email'],
                        'ativo' => $cliente['ativo']
                    );
                }else{
                    $retorno['erro'] = true;
                    $retorno['msg'] = "Cliente não ativado!\nAguarde o contato do administrador!";
                }
            }
        }
        echo json_encode($retorno, true);
    }
    
    /*Recuperar Senha*/
    public function recuperaSenha(){
        $retorno = array();
        $retorno['erro'] = false;
        $clienteR;
        //buscando os dados do cliente
        $sql = $this->mysql->select("cliente", "*", "cpf = '".$this->cliente->getCPF()."'");
        if(mysqli_num_rows($sql) > 0){
            
            //cliente
            while ($cliente = mysqli_fetch_array($sql)){
                $this->cliente->setCidade($cliente['cidade']);
                $this->cliente->setEmail($cliente['email']);
                $this->cliente->setNome($cliente['nome']);
                $this->cliente->setId($cliente['id']);
                
                $clienteR[] = array(
                    'email' => $cliente['email']
                );
            }
            //regrando uma nova senha
            $resultado_final = $this->functions->gerar_senha(6, true, false, true, false);
            
            $this->cliente->setSenha($resultado_final);
            
            //alterando a senha no banco de dados
            $senha = md5( $resultado_final );
            $sqlBanco = $this->mysql->update("cliente", "senha = '".$senha."'", "id = " . $this->cliente->getId());
            if($sqlBanco){
                $retorno['cliente'] = $this->cliente;
            }else{
                $retorno['erro'] = true;
            }
            
        }else{
            $retorno['erro'] = true;
        }
        
        return $retorno;
    }
    
    //Altera o plano do cliente
    public function alteraPlano($plano) {
        $sql = $this->mysql->update("cliente", "plano = $plano", "id = " . $this->cliente->getId());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //clientes que gera fatura no dia
    public function clientesFaturaDia() {
        $dia = date("d");
        $sql = $this->mysql->select("cliente");
        while($c = mysqli_fetch_array($sql)){
            $cli = new Cliente();
            $cli->setCPF($c['cpf']);
            $ClienteDAO = new ClienteDAO($cli);
            $cliente = $ClienteDAO->povoaClienteCPF();
            
            //Verifica se o dia do pagamento é o mesmo
            if($dia == $cliente->getDiaPagamento()){
                
                //Verifica se já tem
                $FaturaDAO = new FaturaDAO();
                $FaturaDAO->setCliente($cliente);
                if( !$FaturaDAO->existeFatura() ){
                    //Mostra que é o dia
                    echo '<div class="card-content white-text">';
                        echo 'Dia do pagamento de ' . $cliente->getNome();
                        echo '<br />';
                        echo '<a href="../../clientes/'.$cliente->getId().'">Gerar</a>';
                    echo '</div>';
                    echo '<hr />';
                }
            }
        }
    }

}
