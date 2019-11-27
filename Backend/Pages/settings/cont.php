<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
$setings = new SettingsDAO();
$set = $setings->settings;
?>
<div class="container">
    <div class="card-panel">
        <div class="row">
            <div class="col s5 m5 valign-wrapper">
                <h5>Configurações</h5>
            </div>
        </div>
        
        <div class="row">
            <div class="col s12 m3">
                <strong>Configurações de Pagamentos</strong>
            </div>
            <div class="col s12 m9">
                <div class="">
                    <form method="post" action="">
                        <div class="input-field">
                            <label>Token API</label>
                            <input type="text" class="validate" id="token" value="<?php echo $set->getToken() ?>">
                        </div>
                        <div class="input-field">
                            <label>Dias Vencimento de Boletos</label>
                            <input type="number" class="validate" id="dias_venc" value="<?php echo $set->getDias_venc() ?>">
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <hr />
        <br />
        <div class="row">
            <div class="col s12 m3">
                <strong>Configurações da Empresa</strong>
            </div>
            <div class="col s12 m9">
                <div class="">
                    <form method="post" action="">
                        <div class="input-field">
                            <label>Endereço</label>
                            <input type="text" class="validate" id="ende" value="<?php echo $set->getEnde() ?>">
                        </div>
                        <div class="input-field">
                            <label>Descrição</label>
                            <textarea id="descri" class="materialize-textarea"><?php echo $set->getDesc() ?></textarea>
                        </div>
                        
                        <div class="input-field">
                            <label>Telefone</label>
                            <input type="tel" id="telefone" class="validate" value="<?php echo $set->getTel() ?>">
                        </div>
                        
                        <div class="input-field">
                            <label>E-mail</label>
                            <input type="email" id="email" class="validate" value="<?php echo $set->getEmail() ?>">
                        </div>
                    </form>
                </div>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col s12 m3"></div>
            <div class="col s12 m9">
                <a href="javascript:void(0)" class="waves-effect waves-light green btn" id="btnSalvaConf">Salvar</a>
            </div>
        </div>
    </div>
</div>