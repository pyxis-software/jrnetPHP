<?php
class NotificacaoDAO {
    private $mysql;
    private $notificacao;
    private $cliente;
    function __construct() {
        $this->mysql = new Mysql();
        $this->notificacao = new Notificacao();
        $this->cliente = new Cliente();
    }
    
    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    
    //Buscando as notificações
    public function getNotificacoes() {
        /*
         * 0 - Fatura
         * 1 - Chat
         * 2 - Informação
         */
        $notificacoes = array();
        $clienteDAO = new ClienteDAO($this->cliente);
        $this->cliente = $clienteDAO->povoaClienteCPF();
        
        
        
        $sql = $this->mysql->select("notificacao", "*", "idCliente = " . $this->cliente->getId());
        while($notificacao = mysqli_fetch_array($sql)){
            $titulo = "";
            switch ($notificacao['tipo']){
                case 0:
                    $titulo = "Nova Fatura Para Você!";
                    break;
                case 1:
                    $titulo = "Nova mensagem";
                    break;
                case 2:
                    $titulo = "Você tem um novo AVISO!";
            }
            
            $notificacoes[] = array(
                'id'=> $notificacao['id'],
                'tipo' => $notificacao['tipo'],
                'titulo' => $titulo,
                'msg' => $notificacao['msg'],
            );
            
            $sqlDELETE = $this->mysql->delete("notificacao", "id = " . $notificacao['id']);;;
        }
        
        return $notificacoes;
    }

}
