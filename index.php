<?php
require "./Backend/Config/Controller.php";
$con = new Controller();
 
//Mostrando todos os erro do PHP
ini_set('display_errors',0);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

//Header
$con->header();

//Conteudo
$con->conteudo();

//Footer
$con->footer();