<?php
require_once 'Backend/Config/Controller.php';
$CORE = new Controller();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="<?php $CORE->gerLinkPastas(); ?>Backend/Images/favicon.ico">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>Dashboard - Júnior NET</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="<?php $CORE->gerLinkPastas(); ?>Backend/Styles/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>