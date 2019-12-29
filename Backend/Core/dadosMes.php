<?php
require '../Config/Controller.php';
$CORE = new Controller();
$retorno = array();
$retorno['erro'] = false;
$retorno['msg'] = "";
$mes = $_POST['mes'];
$retorno['dados'] = $CORE->functions->dadosMes($mes);
echo json_encode($retorno);