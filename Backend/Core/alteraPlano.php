<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

//retorno
$retorno = array();
$retorno['erro'] = false;
$retorno['msg'] = "";

//Recebendo os valores
$plano = $_POST['plano'];
$clienteID = $_POST['cliente'];

//Criando um cliente
$cliente = new Cliente();
$cliente->setId($clienteID);

//Criando o DAO de cliente
$ClienteDAO = new ClienteDAO($cliente);
if($ClienteDAO->alteraPlano($plano)){
    $PlanosDAO = new PlanosDAO();
    $retorno['plano'] = $PlanosDAO->nomePlano($plano);
}else{
    $retorno['erro'] = true;
    $retorno['msg'] = "Não foi possível alterar";
}

echo json_encode($retorno);