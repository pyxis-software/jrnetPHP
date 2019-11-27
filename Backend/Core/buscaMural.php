<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

$muralDAO = new MuralDAO();

//recebendo os dados
$id = intval($_POST['id']);

//Criando uma novo instância de planos
$mural = new Mural();
$mural->setId($id);
$muralDAO->setMural($mural);

//buscando os dados
$retorno = $muralDAO->getDados();
echo json_encode($retorno);