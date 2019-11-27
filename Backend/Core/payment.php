<?php
//Mostrando todos os erro do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once '../../vendor/autoload.php';

require '../Config/Controller.php';
$CORE = new Controller();
$settingsDAO = new SettingsDAO();
$set = $settingsDAO->settings;


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

$data = date("Y-m-d", strtotime("+ " . $dias." days", strtotime($vencimento)));
$mes = intval(date("m", strtotime($vencimento)));
//tratando os dados
$cpf = str_replace(".", "", $cpf);
$cpf = str_replace("-", "", $cpf);
$UF = explode("-", $cidade);
$cidade = $UF[0];
$UF = $UF[1];

//gerando o boleto
MercadoPago\SDK::setAccessToken($set->getToken());

 $payment = new MercadoPago\Payment();
 $payment->date_of_expiration = $data . "T21:52:49.000-04:00";
 $payment->transaction_amount = $valor;
 $payment->description = "Fatura do mes " . $CORE->functions->nomeMes($mes)." de " . date("Y");
 $payment->payment_method_id = "bolbradesco";
 $payment->payer = array(
     "email" => $email,
     "first_name" => $firstName,
     "last_name" => $nomes[count($nomes) - 1],
     "identification" => array( 
         "type" => "CPF",
         "number" => $cpf
      ),
     "address"=>  array(
         "zip_code" => "56000000",
         "street_name" => $endereco,
         "street_number" => "100",
         "neighborhood" => "Umas",
         "city" => $cidade,
         "federal_unit" => $UF
      )
   );
$payment->save();
$retorno = $payment->toArray();
echo json_encode($retorno);