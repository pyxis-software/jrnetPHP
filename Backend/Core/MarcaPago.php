<?php
//Mostrando todos os erro do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require_once '../../vendor/autoload.php';

require '../Config/Controller.php';
$CORE = new Controller();
$settingsDAO = new SettingsDAO();
$api = new ApiDAO();
$set = $settingsDAO->settings;

$id = intval($_POST['id']);

$fatura = new Fatura();
$fatura->setPayment_id($id);

$faturaDAO = new FaturaDAO();
$faturaDAO->setFatura($fatura);

//Mercado Pago
MercadoPago\SDK::setAccessToken($set->getToken());
$payment = MercadoPago\Payment::find_by_id($id);
$payment->status = "cancelled";
$dado = $payment->update();
echo json_encode($faturaDAO->aprovaFatura());