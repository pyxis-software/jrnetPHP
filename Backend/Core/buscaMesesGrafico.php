<?php
require '../Config/Controller.php';
$CORE = new Controller();
$retorno = array();

$FinanceiroDAO = new FinanceiroDAO();
$retorno['dados'] = $FinanceiroDAO->dadosGrafico();
echo json_encode($retorno);