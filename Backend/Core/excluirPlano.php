<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

$PlanosDAO = new PlanosDAO();

//recebendo os dados
$id = intval($_POST['id']);
echo '';
$plano = new Plano();
$plano->setId($id);

$PlanosDAO->plano = $plano;
$dados = $PlanosDAO->excluiPlano();

echo json_encode($dados);