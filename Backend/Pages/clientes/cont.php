<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>
<!--EXIBIÇÂO DE CLIENTES-->
<div class="container">
    <div class="card-panel">
        <?php if (!isset($CORE->url[1])) { ?>
            <div class="row">
                <div class="col s5 m5 valign-wrapper">
                    <h5>Clientes Pendentes</h5>
                </div>
                
            </div>
            <?php $CORE->functions->getClientesPendentes(); ?>

            <hr />
            <h5>Meus Clientes</h5>

            <?php $CORE->functions->getClientes(); ?>
            <?php
        } else {
            $id = intval($CORE->url[1]);
            //buscando os dados do cliente
            $Cliente = new Cliente();
            $Cliente->setId($id);
            $ClienteDAO = new ClienteDAO($Cliente);
            $cliente = $ClienteDAO->getCliente();
            if ($cliente == null) {
                header("Location: ../../");
            }
            $cpf = $cliente->getCPF();
            $cpf = str_replace(".", "", $cpf);
            $cpf = str_replace("-", "", $cpf);
            $SettingsDAO = new SettingsDAO();
            $settings = $SettingsDAO->settings();
            ?>
            <!--Dados para o Jquery-->
            <b id="cpfCliente" lang="<?php echo $cpf ?>"></b>
            <h3><?php echo $cliente->getNome() ?></h3>
            <strong>CPF: <?php echo $cliente->getCPF() ?></strong>
            <br />
            <strong>E-mail: <?php echo $cliente->getEmail() ?></strong>
            <br />
            <strong>Endereço: <?php echo $cliente->getEndereco() ?></strong>
            <br />
            <strong>Cidade: <?php echo $cliente->getCidade() ?></strong>
            <br />
            <strong>Telefones para contato: <br /><?php if($cliente->getCelPrincipal() != "") echo $cliente->getCelPrincipal().' |';
            if($cliente->getCelSecundario() != "")
                echo ' '.$cliente->getCelSecundario() ?></strong>
            <!--VERIFICA A SITUAÇÃO DO CLIENTE-->
            <?php
            if($cliente->getAtivo() == 1){
            ?>
            <div class="card-panel z-depth-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s6 m6">
                            <h5>Plano</h5>
                        </div>
                        <div class="col s6 m6 right-align">
                            <a class="waves-effect waves-light btn modal-trigger" href="#modalAlterar"><i class="material-icons left">add</i>Alterar Plano</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s6 m6">
                            <b><?php echo utf8_decode( $cliente->getPlano()->getTitulo()) ?></b>
                        </div>
                        <div class="col s4 m4">
                            <b>R$ <?php echo $cliente->getPlano()->getValor() ?></b>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-panel z-depth-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s6 m6">
                            <h5>Faturas</h5>
                        </div>
                        <div class="col s6 m6 right-align">
                            <a class="waves-effect waves-light btn modal-trigger" href="#addFatura"><i class="material-icons left">add</i>Adicionar</a>
                        </div>
                    </div>
                    <?php $CORE->functions->getFaturas($cliente->getId()) ?>

                </div>

            </div>


        </div>
        
        <!--EDITAR PLANO-->
        <div id="modalAlterar" class="modal">
            <div class="modal-content">
                <h4>Alterar Plano</h4>
                <b>Selecione o plano</b>
                <div class="input-field">
                    <select id="selectPlano">
                        <option value="0">Selecione Um Plano</option>
                        <?php
                        $PlanosDAO = new PlanosDAO();
                        $PlanosDAO->getPlanos($cliente->getPlano()->getId());
                        ?>
                    </select>
                    <input type="hidden" id="idCliente" value="<?php echo $cliente->getId() ?>">
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="waves-effect waves-light btn green accent-4" id="alterarPlano">Salvar</a>
                <a href="javascript:void(0)" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>
    
        <!----ADICIONAR FATURA-->
        <div id="addFatura" class="modal">
            <div class="modal-content">
                <h4>Adicionar Fatura</h4>

                <!---->
                <div class="progress center-align" id="progressFaturamento">
                    <div class="indeterminate"></div>
                </div>
                <!---->
                <div id="telaDadosForm">
                    <form method="post" action="" id="formAddBoleto">
                        <div class="input-field">
                            <label for="#valorBoleto">Valor Do Plano</label>
                            <input type="number" id="valorBoleto" name="valor" step=".01" class="validate" value="<?php echo $cliente->getPlano()->getValor() ?>" required>
                        </div>
                        
                        <input type="hidden" value="<?php echo date("Y-m-d") ?>" id="diaVencimento">
                        
                        <div class="input-field">
                            <label>Dias para Vencimento</label>
                            <input class="validate" type="number" id="diasVencimento" value="<?php echo $settings->getDias_venc() ?>" required>

                        </div>
                        <div class="input-field">
                            <input type="hidden" id="idUser" value="<?php echo $cliente->getId() ?>">
                            <input type="hidden" id="nomeUser" value="<?php echo $cliente->getNome() ?>">
                            <input type="hidden" id="cpfUser" value="<?php echo $cliente->getCPF() ?>">
                            <input type="hidden" id="emailUser" value="<?php echo $cliente->getEmail() ?>">
                            <input type="hidden" id="endlUser" value="<?php echo $cliente->getEndereco() ?>">
                            <input type="hidden" id="cidadeUser" value="<?php echo $cliente->getCidade() ?>">
                            <strong>A fatura será gerada e o vencimento será de acordo com o que foi informado acima.</strong>
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="waves-effect waves-light btn green accent-4" id="btnGeraFatura">Gerar Faturamento</a>
                <a href="javascript:void(0)" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>
    <?php
            }else{?>
    <!--Cliente não ativado-->
        <h4>Cliente não ativado!</h4>
        <a href="javascript:void(0)" class="waves-effect waves-light btn green accent-4" lang="<?php echo $cliente->getId() ?>" id="btnAtiva">Ativar</a>
        <a href="javascript:void(0)" class="waves-effect waves-light btn" id="btnRemove" lang="<?php echo $cliente->getId() ?>">Remover</a>
    
    
    
    <?php }
    } ?>

</div>
</div>