<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
//$CORE->navBar();
?>
<!--EXIBIÇÂO DE FINANÇAS-->
<div class="container">
    <div class="card-panel">
        <div class="row">
            <div class="col s5 m5 valign-wrapper">
                <h5>Financeiro</h5>
            </div>
            <div class="col s7 m7 right-align mt2">
                <a class="waves-effect waves-light btn modal-trigger" href="#modalBoletoAdd"><i class="material-icons left">add</i>Gerar Boleto</a>
            </div>
        </div>
        <!--Informações do mês atual-->
        

    </div>
</div>