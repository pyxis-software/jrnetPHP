<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>
<!--EXIBIÇÂO DAS INFORMAÇÕES-->
<div class="container">
    <div class="card-panel">
        <div class="row">
            <div class="col s5 m5 valign-wrapper">
                <h5>Minhas Notícias</h5>
            </div>
            <div class="col s7 m7 right-align mt2">
                <a class="waves-effect waves-light btn modal-trigger" href="#modalAdd"><i class="material-icons left">add</i>Adicionar</a>
            </div>
        </div>
        <?php $CORE->functions->getInfo(); ?>

        <!--MODAL ADICIONAR-->
        <div id="modalAdd" class="modal">
            <div class="modal-content">
                <h4>Adicionar Notícia</h4>
                <p>Por favor, informe os dados da nova notícia</p>
                <form method="post" action="" id="formAddMural">
                    <div class="input-field">
                        <label for="tituloMural">Título Da Notícia</label>
                        <input type="text" id="tituloMural" class="validate"required autocomplete="off">
                    </div>

                    <div class="input-field">
                        <textarea id="descMural" class="materialize-textarea" required></textarea>
                        <label for="descMural">Descrição da Notícia</label>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn green accent-4" id="btnAddMural">Salvar</a>
                <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>

        <!--Modal Confirma Excluir-->
        <div id="modalEx" class="modal">
            <div class="modal-content">
                <b>Deseja mesmo excluir a informação <i id="textoInfoMural"></i>?</b>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn green accent-4" id="btnConfirmMural">Sim</a>
                <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>

        <!--Modal Edit-->
        <div id="modalEdit" class="modal">
            <div class="modal-content">
                <h4>Editando <b id="nomeEditMural"></b></h4>
                <p>Por favor, altere somente o necessário</p>
                <form method="post" action="" id="formEditMural">
                    <div class="input-field">
                        <label for="tituloMuralEdit">Título Do Plano</label>
                        <input type="text" id="tituloMuralEdit" class="validate"required autocomplete="off">
                    </div>

                    <div class="input-field">
                        <textarea id="descMuralEdit" class="materialize-textarea" required></textarea>
                        <label for="descMuralEdit">Descrição do Plano</label>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn green accent-4" id="btnSalvaMural">Salvar Alterações</a>
                <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>

    </div>
</div>