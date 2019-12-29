<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>
<!--EXIBIÇÂO DE FINANÇAS-->
<div class="container">
    <div class="card-panel">
        <div class="row">
            <div class="col s5 m5 valign-wrapper">
                <h5>Financeiro</h5>
            </div>
        </div>
        <!--Comparativo meses do ano-->

        <div class="row">
            <div class="col s12 m5">
                <h5>Todos os meses do ano</h5>
                <canvas id="chartMeses" width="100%" height="70"></canvas>
            </div>
            <div class="col m6 s12">
                <h5>Esse Mês</h5>
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Faturamento do Mês</span>
                        <b style="font-size: 35px;"><?php echo 'R$ ' . $CORE->functions->faturamentoMesPagos(); ?></b>
                        <br />
                        A receber:
                        <br /><b style="font-size: 30px;"><?php echo 'R$ ' . $CORE->functions->faturamentoMesPendente(); ?></b>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="container-fluid">
            <h5>Faturamento Detalhado</h5>
            <select id="selectMes" class="input-field">
                <option value="0">Selecione um Mês</option>
                <?php
                $CORE->functions->mesesFatura();
                ?>
            </select>
            <div id="containerInfo">
                <div class="row">
                    <div class="col s12 m5">
                        <h5>Todos os meses do ano</h5>
                        <canvas id="chartInfo" width="100%" height="70"></canvas>
                    </div>
                    <div class="col m6 s12">
                        <h5>Esse Mês</h5>
                        <div class="card blue-grey darken-1">
                            <div class="card-content white-text">
                                <span class="card-title">Faturamento do Mês</span>
                                <b style="font-size: 35px;"><span id="valorRecebido"></span></b>
                                <br />
                                A receber:
                                <br /><b style="font-size: 30px;"><span id="valorPendente"></span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <h5>Clientes</h5>
                    <div class="container-fluid" id="telaClientesMes">
                        <div class="card-panel teal">
                            <div class="row">
                                <div class="col s12 m6">

                                </div>

                                <div class="col s12 m2">
                                    Nome
                                </div>

                                <div class="col s12 m4">
                                    Nome
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>