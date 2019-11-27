<?php

class ApiDAO {

    private $functions;
    private $settingsDAO;
    private $settings;

    function __construct() {
        $this->functions = new Functions();
        $this->settingsDAO = new SettingsDAO();
        $this->settings = new Settings();
        $this->settings = $this->settingsDAO->settings();
    }

    public function cadastroPlano() {
        //verifica se os dados forão enviados
        if (!isset($_POST['id_plano'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        $dados = array();
        $dados['erro'] = false;
        //faz toda a lógica de cadastro aqui

        echo json_encode($dados, true);
    }

    public function editarPlano() {
        //verifica se os dados forão enviados
        if (!isset($_POST['id_plano'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        $dados = array();
        $dados['erro'] = false;
        //faz toda a lógica de cadastro aqui

        echo json_encode($dados, true);
    }

    public function deletarPlano() {
        //verifica se os dados forão enviados
        if (!isset($_POST['id_plano'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        $dados = array();
        $dados['erro'] = false;
        //faz toda a lógica de cadastro aqui



        echo json_encode($dados, true);
    }

    public function getPlanos() {
        if (!isset($_GET['cpf'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        $cpf = $_GET['cpf'];
        $planosDAO = new PlanosDAO();
        $planosDAO->planos($cpf);
    }

    /* PLANOS */

    /* LOGIN */

    public function loginUser() {
        //verifica se os dados forão enviados
        if (!isset($_GET['cpf']) || !isset($_GET['senha'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        $cpf = $_GET['cpf'];
        $senha = $_GET['senha'];
        $cliente = new Cliente();
        $cliente->setCPF($cpf);
        $cliente->setSenha($senha);

        $clienteDAO = new ClienteDAO($cliente);
        $clienteDAO->loginUser();
    }

    /* LOGIN */

    /* RECUPERAR SENHA */

    public function recuperarSenha() {
        //verifica se os dados forão enviados
        if (!isset($_GET['cpf'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }

        $cpf = $_GET['cpf'];
        $cliente = new Cliente();
        $cliente->setCPF($cpf);
        $ClienteDAO = new ClienteDAO($cliente);
        $retorno = $ClienteDAO->recuperaSenha();
        if (!$retorno['erro']) {
            //enviando a mensagem via E-mail
            $this->functions->enviaEmailRecuperaSenha($retorno['cliente']);
        }
        echo json_encode($retorno, true);
    }

    //alterar Senha
    public function alteraSenha() {
        //verifica se os dados forão enviados
        if (!isset($_GET['cpf']) || !isset($_GET['senhaAntiga']) || !isset($_GET['senhaNova'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }

        //recebendo os dados
        $cpf = $_GET['cpf'];
        $senhaAntiga = $_GET['senhaAntiga'];
        $senhaNova = $_GET['senhaNova'];
        $cliente = new Cliente();
        $cliente->setCPF($cpf);
        $cliente->setSenha($senhaAntiga);

        $ClienteDAO = new ClienteDAO($cliente);

        //verificando se a senha antiga está correta
        if ($ClienteDAO->verificaSenhaAntiga()) {
            //alterando a senha
            $cliente->setSenha($senhaNova);
            $ClienteDAO->setCliente($cliente);
            $ClienteDAO->alteraSenha();
        } else {
            $retorno = array(
                'erro' => true,
                'msg' => 'Senha antiga não é válida!'
            );
            echo json_encode($retorno);
            exit;
        }
    }

    /* RECUPERAR SENHA */

    /* CLIENTES */

    public function cadastraCliente() {
        //verifica se os dados forão enviados
        if (!isset($_GET['nome']) || !isset($_GET['email']) || !isset($_GET['cpf']) || !isset($_GET['celularPrincipal']) || !isset($_GET['celularSecundario']) || !isset($_GET['endereco']) || !isset($_GET['cidadeEstado']) || !isset($_GET['diaPagamento'])) {
            $retorno = array(
                'erro' => true,
                'msg' => 'Dados incompletos!'
            );
            echo json_encode($retorno);
            exit;
        }
        //Recebendo os dados
        $nome = $_GET['nome'];
        $email = $_GET['email'];
        $cpf = $_GET['cpf'];
        $celularPrincipal = $_GET['celularPrincipal'];
        $celularSecundario = $_GET['celularSecundario'];
        $endereco = $_GET['endereco'];
        $cidadeEstado = $_GET['cidadeEstado'];
        $diaPagamento = $_GET['diaPagamento'];
        $senha = $_GET['senha'];

        //Criando um cliente
        $cliente = new Cliente();
        $cliente->setAtivo(0);
        $cliente->setCPF($cpf);
        $cliente->setCidade($cidadeEstado);
        $cliente->setEmail($email);
        $cliente->setEndereco($endereco);
        $cliente->setNome($nome);
        $cliente->setPlano(1);
        $cliente->setSenha(md5($senha));
        $cliente->setCelPrincipal($celularPrincipal);
        $cliente->setCelSecundario($celularSecundario);
        $cliente->setDiaPagamento($diaPagamento);

        $ClienteDAO = new ClienteDAO($cliente);
        $result = $ClienteDAO->cadastraCliente();
    }

    /* CLIENTES */

    /* NOTIFICAÇÕES */

    public function getMurais() {
        $MuralDAO = new MuralDAO();
        $MuralDAO->murais();
    }

    /* NOTIFICAÇÕES */


    /* GET UPDATE FATURA */

    public function updateFatura() {
        require_once 'vendor/autoload.php';
        //
        MercadoPago\SDK::setAccessToken($this->settings->getToken());

        switch ($_GET["topic"]) {
            case "payment":
                $result = $this->getInfo($_GET['id']);
                $status = $result['status'];
                $fatura = new Fatura();
                $fatura->setPayment_id($_GET['id']);
                $fatura->setStatus($status);
                $faturaDAO = new FaturaDAO();
                $faturaDAO->setFatura($fatura);
                if($faturaDAO->notificacao()){
                    echo 'Atualizado!';
                }else{
                    echo 'Não atualizado!';
                }
                break;
            case "merchant_order":
                $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
                return $merchant_order;
        }
    }

    public function getInfo($id) {
        $dados = json_decode(file_get_contents("https://api.mercadopago.com/v1/payments/$id?access_token=" . $this->settings->getToken()), true);
        return $dados;
    }
    
    //PEGA BOLETOS DO CLIENTE
    public function getBoletos() {
        if(!isset($_GET['cpf'])){
            $retorno = array();
            $retorno['erro'] = true;
            $retorno['msg'] = "Cliente não credenciado!";
            echo json_encode($retorno);
            exit;
        }
        
        $cpf = $_GET['cpf'];
        $cliente = new Cliente();
        $cliente->setCPF($cpf);
        
        $clienteDAO = new ClienteDAO($cliente);
        $clienteRetorno = $clienteDAO->povoaClienteCPF();
        
        //Fatura
        $faturaDAO = new FaturaDAO();
        $faturaDAO->setCliente($clienteRetorno);
        $faturaDAO->faturas();
        
    }
    
    /*NOTIFICAÇÕES DO APLICATIVO*/
    public function getNotification() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = '';
        $retorno['notifications'] = array();
        /*
        $retorno['notifications'][] = array(
            'id'=> 1,
            'tipo' => 0,
            'titulo' => 'Chat',
            'msg' => 'Mensagem da notificação'
        );
        */
        
        echo json_encode($retorno);
    }
    
    public function getNotifications() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = '';
        $retorno['notifications'] = array();
        
        if(!isset($_GET['cpf'])){
            $retorno['erro'] = true;
            $retorno['msg'] = "CPF não informado!";
        }else{
            $cpf = $_GET['cpf'];
            $cliente = new Cliente();
            $cliente->setCPF($cpf);
            $NotificacaoDAO = new NotificacaoDAO();
            $NotificacaoDAO->setCliente($cliente);
            $retorno['notifications'] = $NotificacaoDAO->getNotificacoes();
        }
        
        //Buscando as notificações
        
        
        /*
        $retorno['notifications'][] = array(
            'id'=> 1,
            'tipo' => 0,
            'titulo' => 'Chat',
            'msg' => 'Mensagem da notificação'
        );
         * 
         */
        
        echo json_encode($retorno);
    }
    
    public function infoEmpresa() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        $settings = new SettingsDAO();
        $set = new Settings();
        
        $set = $settings->settings();
        $retorno['result'] = array(
            'email' => $set->getEmail(),
            'endereco' => $set->getEnde(),
            'descricao' => $set->getDesc(),
            'telefone' => $set->getTel()
        );
        
        
        echo json_encode($retorno);
    }

}
