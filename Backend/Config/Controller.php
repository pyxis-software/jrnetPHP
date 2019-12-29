<?php
require "mysql.php";

require_once 'model/Admin.php';
require_once 'model/Cliente.php';
require_once 'model/Fatura.php';
require_once 'model/Mural.php';
require_once 'model/Plano.php';
require_once 'model/Settings.php';
require_once 'model/Fatura.php';
require_once 'model/Notificacao.php';
//DAO
require_once 'DAO/AdminDAO.php';
require_once 'DAO/ClienteDAO.php';
require_once 'DAO/MuralDAO.php';
require_once 'DAO/PlanosDAO.php';
require_once 'DAO/SettingsDAO.php';
require_once 'DAO/FaturaDAO.php';
require_once 'DAO/NotificacaoDAO.php';
require_once 'DAO/FinanceiroDAO.php';
require_once 'ApiDAO.php';

//funções
require 'Functions.php';

class Controller {

    public $url;
    public $functions;
    public $api;
    function __construct() {
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header("Location: $redirect_url");
            exit();
        }

        $parte1 = strrchr($_SERVER['REQUEST_URI'], "?");
        $parte2 = str_replace($parte1, "", $_SERVER['REQUEST_URI']);
        $this->url = explode("/", $parte2);
        array_shift($this->url);
        $this->functions = new Functions();
        $this->api = new ApiDAO();
        $this->functions->verificaVencimento();
    }

    //HEADER
    public function header() {
        //buscando o cabeçalho do arquivo
        if ($this->url[0] == "") {
            //inicial
            include "Backend/View/header.php";
        } else {
            //verifica se existe a pasta
            if (file_exists("Backend/Pages/" . $this->url[0] . "/")) {
                include "Backend/Pages/" . $this->url[0] . "/header.php";
            } else {
                echo "<script>location.href='../';</script>";
            }
        }
    }

    //CONTEUDO
    public function conteudo() {
        if ($this->url[0] == "") {
            //inicial
            include "Backend/View/cont.php";
        } else {
            include "Backend/Pages/" . $this->url[0] . "/cont.php";
        }
    }

    //FOOTER
    public function footer() {
        if ($this->url[0] == "") {
            //inicial
            include "Backend/View/footer.php";
        } else {
            include "Backend/Pages/" . $this->url[0] . "/footer.php";
        }
    }

    //gera pastas
    public function gerLinkPastas() {
        //string das url
        $resultado = "";

        //pega o tamanho dos links
        $total = count($this->url);

        for ($i = 0; $i < $total; $i++) {
            $resultado .= "../";
        }
        echo $resultado;
    }

    /* BARRA DE NAVEGAÇÃO */

    public function navBar() {
        $adminDAO = new AdminDAO();
        $admin = $adminDAO->verificaAdmin();
        ?>
        <!--NAVBAR-->
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper" id="barraTopo">

                    <a href="<?php $this->gerLinkPastas() ?>" class="brand-logo center">JRNET</a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="javascript:void(0)" id="btnSair">Sair</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <ul id="mobile-demo" class="sidenav">
            <li>
                <div class="user-view light-blue darken-3" id="telaUser">
                    <img src="<?php $this->gerLinkPastas() ?>Backend/Images/logo.png" width="100%" alt="Imagem Logo" />
                    <a href="#name"><span class="white-text name">Administrador</span></a>
                    <a href="#email"><span class="white-text email"><?php echo $admin->getEmail() ?></span></a>
                </div>
            </li>
            <li><a href="<?php $this->gerLinkPastas() ?>"><i class="material-icons">dashboard</i>Administração</a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>planos"><i class="material-icons">list</i>Planos</a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>noticias"><i class="material-icons">notification_important</i>Notícias</a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>clientes"><i class="material-icons">supervised_user_circle</i>Clientes</a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>money"><i class="material-icons">monetization_on</i>Financeiro</a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>chat"><i class="material-icons">chat</i>Conversas <span class="new badge red" id="totalChat"></span></a></li>
            <li><a href="<?php $this->gerLinkPastas() ?>settings"><i class="material-icons">settings_applications</i>Configurações</a></li>
            
        </ul>
        <!--NAVBAR-->
        <?php
    }

}
