<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

$id = $_POST['id'];
$cliente = new Cliente();
$cliente->setId($id);

$clienteDAO = new ClienteDAO($cliente);

$dados = $clienteDAO->desabilita();

echo json_encode($dados);