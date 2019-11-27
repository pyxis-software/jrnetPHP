<?php
require '../Config/Controller.php';
$CORE = new Controller();

//recebendo os dados
$id = $_POST['id'];

//criando o cliente
$cliente = new Cliente();
$cliente->setId($id);

//Criando o clienteDAO
$clieteDAO = new ClienteDAO($cliente);

$result = $clieteDAO->removerCliente();
echo json_encode($result);