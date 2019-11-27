<?php
require '../../Backend/Config/Controller.php';
$CORE = new Controller();

//retorno
$retorno = array();
$retorno['erro'] = false;
$retorno['msg'] = "";
$retorno['clientes'] = "";

//recebendo os dados
$titulo = utf8_encode($_POST['titulo']);
$desc = utf8_encode($_POST['desc']);

//Criando um novo objeto de Mural
$mural = new Mural();

//adicionando as informações do mural
$mural->setTitulo($titulo);
$mural->setDesc($desc);

//Criando objeto de MuralDAO
$muralDAO = new MuralDAO();

//adicionando o mural ao objeto MuralDAO
$muralDAO->setMural($mural);

//salvando o mural no banco de dados
if(!$muralDAO->cadastra()){
    $retorno['erro'] = true;
    $retorno['msg'] = "Não foi possível Adicionar!";
}
$retorno['clientes'] = $muralDAO->getClientes();
echo json_encode($retorno);