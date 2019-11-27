<?php
require "Backend/Config/config.php";
$CORE = new Controller();

if (isset($CORE->url[1])) {
    $requisicao = $CORE->url[1];
    //Verificando
    switch ($requisicao) {
        //mostra as notificações
        case "notfi":
            echo 'Notificações';
            break;

        //cadastro de usuários
        case "caduser":
            $CORE->api->cadastraCliente();
            break;

        case "loginuser":
            $CORE->api->loginUser();
            break;

        //Cadastro planos
        case "cadastroplano":
            $CORE->api->cadastroPlano();
            break;

        case "clientes":
            $CORE->api->clientes();
            break;

        case "planos":
            $CORE->api->getPlanos();
            break;

        case "teste":
            $CORE->api->teste();
            break;

        case "recupera":
            $CORE->api->recuperarSenha();
            break;

        case "murais":
            $CORE->api->getMurais();
            break;
        
        case "alterasenha":
            $CORE->api->alteraSenha();
            break;
        
        case "updatefatura":
            $CORE->api->updateFatura();
            break;
        
        case "boletos":
            $CORE->api->getBoletos();
            break;
        
        case "notificacoes":
            $CORE->api->getNotifications();
            break;
        
        case "notifica":
            $CORE->api->getNotifications();
            break;
        
        case "info":
            $CORE->api->infoEmpresa();
            break;

        default:
            echo 'Erro';
    }
}else{
    echo 'Sem autorização!';
}
