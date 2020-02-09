<?php
//Mostrando todos os erro do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require '../Config/Controller.php';
$CORE = new Controller();


//recebendo os dados
$id = intval($_POST['id']);
$valor = $_POST['valor'];
$vencimento = $_POST['dia_venc'];
$dias = intval($_POST['dias']);
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$cidade = $_POST['cidade'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$nomes = explode(" ", $nome);
$firstName = $nomes[0];
$barcode = $_POST['barcode'];

$data = date("Y-m-d H:i:s", strtotime("+ " . $dias." days", strtotime($vencimento)));
$mes = intval(date("m", strtotime($vencimento)));
//tratando os dados
$cpf = str_replace(".", "", $cpf);
$cpf = str_replace("-", "", $cpf);
$UF = explode("-", $cidade);
$cidade = $UF[0];
$UF = $UF[1];

$link = $_POST['link'];
$status = $_POST['status'];
$id_payment = $_POST['id_payment'];



//adicionando uma nova fatura para o cliente
$fatura = new Fatura();
$fatura->setClienteID($id);
$mk = new DateTime(date("Y-m-d H:i:s"));
$fatura->setData($mk->getTimestamp());
$fatura->setLink($link);
$fatura->setPayment_id($id_payment);
$fatura->setValor($valor);
$fatura->setVencimento(strtotime($data));
$fatura->setStatus($status);

$fatura->setBarcode($barcode);
//
$cliente = new Cliente();
$cliente->setCPF($cpf);
$ClienteDAO = new ClienteDAO($cliente);
$c = $ClienteDAO->povoaClienteCPF();


$faturaDAO = new FaturaDAO();
$faturaDAO->setCliente($c);
$faturaDAO->fatura = $fatura;
$dados = array();
$dados['erro'] = false;
$dados['msg'] = "";
$dados['cpf'] = $cpf;

if(!$faturaDAO->salvaFatura()){
    $dados['erro'] = true;
    $dados['msg'] = "Não foi possível adicionar a fatura";
}

echo json_encode($dados);