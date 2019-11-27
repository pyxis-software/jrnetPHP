<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>
<div class="container">
    <div class="card-panel">
        <h5>Administração</h5>

        <div class="row" id="paineisAdmin">
            <div class="col s12 m6">

                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Faturamento do Mês</span>
                        <b style="font-size: 35px;"><?php echo 'R$ '. $CORE->functions->faturamentoMesPagos(); ?></b>
                        <br />
                        A receber:
                        <br /><b style="font-size: 30px;"><?php echo 'R$ '. $CORE->functions->faturamentoMesPendente(); ?></b>
                    </div>
                </div>


            </div>

            <div class="col s12 m6">

                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Clientes</span>
                        <b>Total de Clientes: </b><?php $CORE->functions->getTotalClientes(); ?>
                        <br/>
                        <b>Pagamentos Pendentes:</b> <?php $CORE->functions->clientesInativos() ?>
                        <!--Buscando os clientes pendentes de geramento de fatura-->
                        <?php
                        $cliente = new Cliente();
                        $ClienteDAO = new ClienteDAO($cliente);
                        $ClienteDAO->clientesFaturaDia();
                        ?>
                    </div>
                    <div class="card-action">
                        <a href="../../clientes">Ver Clientes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>