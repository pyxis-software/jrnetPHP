<?php
include "Backend/Config/config.php";
$CORE = new Controller();
$adminDAO = new AdminDAO();
$admin = $adminDAO->verificaAdmin();
$CORE->navBar();
?>
<div class="container">
    <div class="card-panel">
        <div class="row">
            <div class="col s5 m5 valign-wrapper">
                <h5>Meus Planos</h5>
            </div>
            <div class="col s7 m7 right-align mt2">
                <a class="waves-effect waves-light btn modal-trigger" href="#modalAdd"><i class="material-icons left">add</i>Adicionar</a>
            </div>
        </div>
        <!--Processo-->
        <?php
        if (isset($_POST['numero'])) {
            echo '<div class="container-fluid">';
            //recebendo os dados
            $titulo = utf8_encode($_POST['titulo']);
            $desc = utf8_encode($_POST['desc']);
            $valor = doubleval($_POST['numero']);

            $PlanosDAO = new PlanosDAO();
            $plano = new Plano();
            $plano->setTitulo($titulo);
            $plano->setDesc($desc);
            $plano->setValor($valor);
            $PlanosDAO->setPlano($plano);

            if (!$PlanosDAO->cadastraPlano()) {
                echo '<div class="card-panel red center-align">';
                echo 'Não foi possível adicionar';
                echo '</div>';
            } else {
                echo '<div class="card-panel teal accent-3 center-align">';
                echo 'Plano adicionado com sucesso!';
                echo '</div>';
            }

            echo '</div>';
        }
        if (isset($_POST['desc_edit'])) {
            echo '<div class="container-fluid">';
            //recebendo os dados
            $titulo = utf8_encode($_POST['titulo_edit']);
            $desc = utf8_encode($_POST['desc_edit']);
            $valor = doubleval($_POST['valor_edit']);
            $id = intval($_POST['id']);

            $PlanosDAO = new PlanosDAO();
            $plano = new Plano();
            $plano->setTitulo($titulo);
            $plano->setDesc($desc);
            $plano->setValor($valor);
            $plano->setId($id);
            $PlanosDAO->setPlano($plano);

            if (!$PlanosDAO->editaPlano()) {
                echo '<div class="card-panel red center-align">';
                echo 'Não foi possível editar';
                echo '</div>';
            } else {
                echo '<div class="card-panel teal accent-3 center-align">';
                echo 'Plano editado com sucesso!';
                echo '</div>';
            }

            echo '</div>';
        }
        ?>
        <!--Processo-->
        <!--Buscando todas os planos-->
        <?php
        $CORE->functions->getPlanos();
        ?>
        <!--MODAL ADICIONAR-->
        <div id="modalAdd" class="modal">
            <div class="modal-content">
                <h4>Adicionar Plano</h4>
                <p>Por favor, informe os dados do novo plano</p>
                <form method="post" action="" id="formAddPlano">
                    <div class="input-field">
                        <label for="tituloPlano">Título Do Plano</label>
                        <input type="text" id="tituloPlano" name="titulo" class="validate"required autocomplete="off">
                    </div>

                    <div class="input-field">
                        <textarea id="descPlano" name="desc" class="materialize-textarea" required></textarea>
                        <label for="descPlano">Descrição do Plano</label>
                    </div>
                    <div class="input-field">
                        <input type="number" name="numero" class="validate" step=".01" id="valorPlano" required autocomplete="off">
                        <label for="valorPlano">Valor do Plano</label>
                    </div>
                    <div class="modal-footer">
                        <button class="waves-effect waves-light btn green accent-4" type="submit" id="btnAddPlano">Salvar</button>
                        <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>

        <!--Modal Confirma Excluir-->
        <div id="modalEx" class="modal">
            <div class="modal-content">
                <b>Deseja mesmo excluir o plano <i id="textoPlanoModal"></i>?</b>
                <br />
                <div id="infoErro">

                </div>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn green accent-4" id="btnConfirm">Sim</a>
                <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>

        <!--Modal Edit-->
        <div id="modalEdit" class="modal">
            <div class="modal-content">
                <h4>Editando <b id="nomePlanoEdit"></b></h4>
                <p>Por favor, altere somente o necessário</p>
                <form method="post" action="" id="formEditPlano">
                    <div class="input-field">
                        <label for="tituloPlanoEdit">Título Do Plano</label>
                        <input type="text" name="titulo_edit" id="tituloPlanoEdit" class="validate"required autocomplete="off">
                    </div>

                    <div class="input-field">
                        <textarea id="descPlanoEdit" name="desc_edit" class="materialize-textarea" required></textarea>
                        <label for="descPlanoEdit">Descrição do Plano</label>
                    </div>
                    <div class="input-field">
                        <input type="number" name="valor_edit" class="validate" step=".01" id="valorPlanoEdit" required autocomplete="off">
                        <label for="valorPlanoEdit">Valor do Plano</label>
                    </div>
                    <input type="hidden" name="id" id="campoId">


                    <div class="modal-footer">
                        <button class="waves-effect waves-light btn green accent-4" id="btnSalva" type="submit">Salvar Alterações</button>
                        <a href="#!" class="modal-close waves-effect waves-light btn">Cancelar</a>
                    </div>
                </form> 
            </div>
        </div>


    </div>
</div>