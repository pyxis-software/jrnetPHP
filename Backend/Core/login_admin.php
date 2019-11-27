<?php
require '../../Backend/Config/Controller.php';

//recebendo os dados
$email = htmlspecialchars( $_POST['email'] );
$senha = htmlspecialchars( $_POST['senha'] );
$admin = new Admin();
$admin->setEmail($email);
$admin->setSenha($senha);

$adminDAO = new AdminDAO();
$adminDAO->setAdmin($admin);

//verifica o login
$result = $adminDAO->login();
if(!$result['erro']){
    //criando a sessoa
    $adminDAO->criaSessao();
}
echo json_encode($result);