<?php
include "Backend/Config/config.php";
$CORE = new Controller();

//verificando se existe a opção para cadastro
if( isset($_GET['action']) && $_GET['action'] == "cadastro" && $_GET['key'] == "984628462"){
    ?>
<div class="container">
    <div class="card-panel">
        <div class="card-content">
            <h4>Realize seu cadastro de administrador!</h4>
            <br />
            <form method="post" action="">
                <div class="input-field">
                    <input type="email" name="email" id="email" required class="validate">
                    <label for="email">Seu E-mail</label>
                </div>
                
                <div class="input-field">
                    <input type="password" name="senha" id="senha" required minlength="8" class="validate">
                    <label for="senha">Sua Senha</label>
                </div>
                <div class="input-field">
                    <button type="submit" name="action_cadastro" class="waves-effect waves-light btn">Cadastrar</button>
                </div>
            </form>
            <?php
            if(isset($_POST['action_cadastro'])){
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                
                $adminDAo = new Admin();
                $adminDAo->setEmail($email);
                $adminDAo->setSenha($senha);
                
                //
                $DAO = new AdminDAO();
                $DAO->setAdmin($adminDAo);
                
                
                $result = $DAO->cadastro();
                if(!$result['erro']){
                    echo '<div class="card-panel green">';
                    echo $result['msg'];
                }else{
                    echo '<div class="card-panel red darken-1">';
                    echo $result['msg'];
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>


<?php
}else{
    header("Location: ../../index.php");
}