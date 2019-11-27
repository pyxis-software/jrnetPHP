<?php
require '../Config/Controller.php';
$CORE = new Controller();

//recebendo os dados
$token = $_POST['token'];
$dias = $_POST['dias'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$end = $_POST['end'];
$desc = htmlspecialchars( $_POST['desc'] );

$tel = str_replace("(", "", $tel);
$tel = str_replace(")", "", $tel);
$tel = str_replace("-", "", $tel);


$setingsDAO = new SettingsDAO();
$setingsDAO->settings->setToken($token);
$setingsDAO->settings->setDias_venc($dias);

//
$setingsDAO->settings->setEmail($email);
$setingsDAO->settings->setEnde($end);
$setingsDAO->settings->setDesc($desc);
$setingsDAO->settings->setTel($tel);

$retorno = $setingsDAO->salvaSetings();
echo json_encode($retorno);
