<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();


$PlanosDAO = new PlanosDAO();

//recebendo os dados
$id = intval($_POST['id']);

//Criando uma novo instância de planos
$plano = new Plano();
$plano->setId($id);
//adicionando o plano no DAO
$PlanosDAO->plano = $plano;

$retorno = $PlanosDAO->dadosPlano();
echo json_encode($retorno);