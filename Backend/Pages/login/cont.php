<?php include "Backend/Config/config.php"; ?>
<div class="container center-align">

    <div class="row">
        <div class="z-depth-3 col-8" id="telaLogin">
            <img src="<?php $CORE->gerLinkPastas()?>Backend/Images/logo.png" class="materialboxed" alt="Image logo">
            <h4>Que bom que voltou!</h4>
            <h5>Entre com Seus Dados!</h5>
            <form method="post" action="" id="formLogin">
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    <input type="email" class="validate" placeholder="Seu E-mail" id="campoEmail" required>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">security</i>
                    <input type="password" class="validate" placeholder="Sua Senha" id="campoSenha" required>
                </div>

                <button type="submit" class="waves-effect waves-light btn-large" id="btnEntrar">Entrar</button>

            </form>
        </div>
    </div>

</div>