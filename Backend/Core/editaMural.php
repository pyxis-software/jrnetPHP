<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

//retorno
$retorno = array();
$retorno['erro'] = false;
$retorno['msg'] = "";

//recebendo os dados
$id = intval($_POST['id']);
$titulo = utf8_encode($_POST['titulo']);
$desc = utf8_encode($_POST['desc']);

//Criando um novo objeto de Mural
$mural = new Mural();

//adicionando as informações do mural
$mural->setTitulo($titulo);
$mural->setDesc($desc);
$mural->setId($id);

//Criando objeto de MuralDAO
$muralDAO = new MuralDAO();

//adicionando o mural ao objeto MuralDAO
$muralDAO->setMural($mural);

//salvando o mural no banco de dados
if(!$muralDAO->editarMural()){
    $retorno['erro'] = true;
    $retorno['msg'] = "Não foi possível Editar!";
}
echo json_encode($retorno);