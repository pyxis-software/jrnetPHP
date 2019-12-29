<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_destroy();

$dados = array(
    'erro' => false
);

echo json_encode($dados);