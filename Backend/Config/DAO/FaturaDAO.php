<?php
class FaturaDAO {
    private $mysql;
    public $fatura;
    private $cliente;
    private $functions;
    
    function __construct() {
        $this->mysql = new Mysql();
        $this->fatura = new Fatura();
        $this->cliente = new Cliente();
        $this->functions = new Functions();
    }
    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }
    
    function getFatura() {
        return $this->fatura;
    }

    function setFatura($fatura) {
        $this->fatura = $fatura;
    }
    
    public function salvaFatura() {
        $lancamento = $this->fatura->getData();
        $status = $this->fatura->getStatus();
        $payment_id = $this->fatura->getPayment_id();
        $vencimento = $this->fatura->getVencimento();
        $valor = $this->fatura->getValor();
        $cliente = $this->fatura->getClienteID();
        $link = $this->fatura->getLink();
        $barcode = $this->fatura->getBarcode();
        
        $sql = $this->mysql->insere("fatura", "lancamento, status, payment_id, vencimento, valor, idCliente, link, barcode", "'$lancamento', '$status', '$payment_id', '$vencimento', $valor, $cliente, '$link', '$barcode'");
        if($sql){
            //Adicionando uma nova notificação
            $msg = "Fatura de " . $this->functions->nomeMes(date("m" , $lancamento)) ." de " . date("Y") . " disponível!";
            $sqlAddN = $this->mysql->insere("notificacao", "idCliente, tipo, msg", $cliente.", 0, '".$msg."'");
            return true;
        }else{
            return false;
        }
    }
    
    //Atualiza fatura
    public function notificacao() {
        $status = $this->fatura->getStatus();
        $sql = $this->mysql->update("fatura", "status = '$status'", "payment_id = " . $this->fatura->getPayment_id());
        if($sql){
            return true;
        }else{
            return false;
        }
    }
    
    //mostra as faturas do cliente
    public function faturas() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $retorno['faturas'] = array();
        $function = new Functions();
        $sql = $this->mysql->select("fatura", "*", "idCliente = " . $this->cliente->getId(),"lancamento DESC");
        while($fatura = mysqli_fetch_array($sql)){
            $retorno['faturas'][] = array(
                'id' => $fatura['id'],
                'status' => $function->nomeStatus( $fatura['status'] ),
                'vencimento' => $fatura['vencimento'],
                'valor' => $fatura['valor'],
                'link' => $fatura['link'],
                'barcode' => $fatura['barcode'],
                'mes' => $function->nomeMes( date("m", $fatura['lancamento']) )." de " . date("Y", $fatura['lancamento'])
            );
        }
        echo json_encode($retorno);
    }
    
    //Marca como paga
    public function aprovaFatura(){
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $sql = $this->mysql->update("fatura", "status = 'approved'", "payment_id = '".$this->fatura->getPayment_id()."'");
        if(!$sql){
            $retorno['erro'] = true;
            $retorno['msg'] = "Não conseguimos atualizar";
        }
        return $retorno;
    }
    
    //Verifica se existe fatura
    public function existeFatura() {
        $mes = date("m");
        $sql = $this->mysql->select("fatura", "*", "idCliente = " . $this->cliente->getId());
        $tem = false;
        while ($fatura = mysqli_fetch_array($sql)){
            $d = date("m", $fatura['lancamento']);
            if($mes == $d){
                $tem = true;
            }
        }
        return $tem;
    }
}
