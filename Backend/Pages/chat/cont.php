<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>

<!--EXIBIÇÂO DE CHAT -->
<div class="container-fluid" id="containerChat">
    <div class="container" id="telaUsuarios">

        <ul class="collection" id="colectionUsers">

        </ul>

    </div>

    <div class="container" id="telaConversa">
        <div class="container-fluid">
            <div class="row red lighten-1" id="barraMensagens">
                <div class="col s2 m2">
                    <a href="javascript:void(0)" id="btnVoltar" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">arrow_back</i></a>
                </div>

                <div class="col s10 m10">
                    <b id="nomeCliente"></b>
                </div>

            </div>


            <div class="" id="telaMensagens">
                <div id="mensagem" class="chats">

                </div>



            </div>
            <div class="row" id="telaCampo" class="z-depth-2">
                <div class="col s10">
                    <form method="post"action="" id="formInput">
                        <input type="text" autocomplete="false" class="validate" id="campoMensagem" placeholder="Sua mensagem aqui!">
                    </form>
                </div>
                <div class="col s2 center-align">
                    <a href="javascript:void(0)" class="btn-floating waves-effect waves-light gray" id="btnSend"><i class="material-icons">send</i></a>
                </div>

            </div>

        </div>
    </div>


</div>