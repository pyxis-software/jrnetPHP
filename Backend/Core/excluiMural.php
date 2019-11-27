<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();
//retorno
$retorno = array();
$retorno['erro'] = false;
$retorno['msg'] = "";

//recebendo os dados
$id = intval($_POST['id']);

//Criando um novo objeto de Mural
$mural = new Mural();

//adicionando as informações do mural
$mural->setId($id);

//Criando objeto de MuralDAO
$muralDAO = new MuralDAO();

//adicionando o mural ao objeto MuralDAO
$muralDAO->setMural($mural);

//salvando o mural no banco de dados
if(!$muralDAO->excluirMural()){
    $retorno['erro'] = true;
    $retorno['msg'] = "Não foi possível Excluir!";
}
echo json_encode($retorno);