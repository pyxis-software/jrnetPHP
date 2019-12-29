<?php
class FinanceiroDAO {
    private $mysql;
    private $functions;

    function __construct() {
        $this->mysql = new Mysql();
        $this->functions = new Functions();
    }
    
    
    //Buscando os dados do gráfico
    public function dadosGrafico() {
        //este mês
        $mes = intval(date("m"));
        $inicial = 1;
        $dados = array();
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        $dados['datasets'][0]['borderWidth'] = 5;
        $dados['datasets'][0]['label'] = "Valor Recebido";
        $dados['datasets'][0]['backgroundColor'] = "transparent";
        
        while ($inicial <= $mes){
            //buscando todas as faturas
            $sql = $this->mysql->select("fatura");
            $total = 0;
            while($f = mysqli_fetch_array($sql)){
                if(date("m", $f['lancamento']) == $inicial){
                    if($f['status'] == "approved"){
                        $total += $f['valor'];
                    }
                }
            }
            $dados['labels'][] = $this->functions->nomeMes($inicial);
            $dados['datasets'][0]['data'][] = $total;
            $dados['datasets'][0]['backgroundColor'] = "rgba($r, $g, $b, 0.2)";
            $dados['datasets'][0]['borderColor'][] = "rgba($r, $g, $b, 1)";
            $inicial++;
        }
        
        /*
        //buscando todas as faturas
        $sql = $this->mysql->select("fatura");
        while($f = mysqli_fetch_array($sql)){
            $fatura = new Fatura();
            $fatura->setBarcode($f['barcode']);
            $fatura->setClienteID($f['idCliente']);
            $fatura->setData($f['lancamento']);
            $fatura->setId($f['id']);
            $fatura->setLink($f['link']);
            $fatura->setPayment_id($f['payment_id']);
            $fatura->setStatus($f['status']);
            $fatura->setValor($f['valor']);
            $fatura->setVencimento($f['vencimento']);
            
            
            
        }
         */
        return $dados;
    }
}
