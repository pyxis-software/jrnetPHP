<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

class Functions {

    private $mysql;

    function __construct() {
        $this->mysql = new Mysql();
    }

    /* PLANOS */

    public function getPlanos() {
        $sql = $this->mysql->select("planos", "*", "", "valor ASC");
        if (mysqli_num_rows($sql) > 0) {
            while ($plano = mysqli_fetch_array($sql)) {
                //mostrando o plano
                ?>
                <div class="card blue-grey darken-1" id="card_plano">
                    <div class="card-content white-text">
                        <span class="card-title"><?php echo utf8_decode($plano['titulo']) ?></span>
                        <?php
                        if (strlen($plano['descricao']) > 100) {
                            echo '<p>' . utf8_decode(substr($plano['descricao'], 0, 100)) . '...</p>';
                        } else {
                            echo '<p>' . utf8_decode($plano['descricao']) . '</p>';
                        }
                        ?>
                        <strong class="center-align">R$ <?php echo utf8_decode($plano['valor']) ?></strong>
                    </div>
                    <div class="card-action center-align">
                        <a href="#modalEdit" class="waves-effect waves-light btn modal-trigger" id="btnEditPlano" idplano="<?php echo $plano['id'] ?>" titulo="<?php echo $plano['titulo'] ?>">Editar</a>
                        <a class="waves-effect waves-light btn modal-trigger" href="#modalEx" id="btnExcluPlano" idplano="<?php echo $plano['id'] ?>" title="Exluir" titulo="<?php echo $plano['titulo'] ?>">Excluir</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo 'Nenhum Plano Encontrado!<br />Adicione um NOVO!';
        }
    }
    

    /* CLIENTES */

    public function getTotalClientes() {
        $sql = $this->mysql->select("cliente", "*", "ativo = 1");
        echo mysqli_num_rows($sql);
    }

    //Total clientes inativos
    public function clientesInativos() {
        $sql = $this->mysql->select("cliente", "*", "ativo = 0");
        echo mysqli_num_rows($sql);
    }

    public function getClientes() {
        $sql = $this->mysql->select("cliente", "*", "ativo = 1", "nome ASC");
        if (mysqli_num_rows($sql) > 0) {
            while ($cliente = mysqli_fetch_array($sql)) {
                //mostrando o cliente
                $Plano = new Plano();
                $Plano->setId($cliente['plano']);
                $PlanoDAO = new PlanosDAO();
                $PlanoDAO->setPlano($Plano);
                $result = $PlanoDAO->dadosPlano();
                ?>
                <div class="card blue-grey darken-1" id="card_plano">
                    <div class="card-content white-text">
                        <span class="card-title"><b><?php echo utf8_decode($cliente['nome']) ?></b></span>
                        <br />
                        <p>CPF: <?php echo $cliente['cpf'] ?></p>
                        <br />
                        <p>Plano <?php echo $result['dados']['titulo']; ?></p>
                    </div>
                    <div class="card-action center-align">
                        <a href="../../clientes/<?php echo $cliente['id'] ?>" class="waves-effect waves-light btn green accent-4" >Gerenciar Cliente</a>

                    </div>
                </div>
                <?php
            }
        } else {
            echo 'Nenhum Cliente Encontrado!';
        }
    }

    public function getClientesPendentes() {
        $sql = $this->mysql->select("cliente", "*", "ativo = 0", "nome ASC");
        if (mysqli_num_rows($sql) > 0) {
            while ($cliente = mysqli_fetch_array($sql)) {
                //mostrando o cliente
                $Plano = new Plano();
                $Plano->setId($cliente['plano']);
                $PlanoDAO = new PlanosDAO();
                $PlanoDAO->setPlano($Plano);
                $result = $PlanoDAO->dadosPlano();
                ?>
                <div class="card blue-grey darken-1" id="card_plano">
                    <div class="card-content white-text">
                        <span class="card-title"><b><?php echo utf8_decode($cliente['nome']) ?></b></span>
                        <br />
                        <p>CPF: <?php echo $cliente['cpf'] ?></p>
                        <br />
                        <p>Plano <?php echo $result['dados']['titulo']; ?></p>
                    </div>
                    <div class="card-action center-align">
                        <a href="../../clientes/<?php echo $cliente['id'] ?>" class="waves-effect waves-light btn green accent-4" >Gerenciar Cliente</a>

                    </div>
                </div>
                <?php
            }
        } else {
            echo 'Nenhum Cliente Encontrado!';
        }
    }
    
    public function mesFatura($time) {
        
    }

    /* FATURA */

    /* AUTENTICAÇÃO */

    public function enviaEmailRecuperaSenha(Cliente $c) {
        $arquivo = ''
                . 'Este e-mail faz parte do sistema de recuperação de senhas do aplicativo de Junior NET!<br />'
                . 'Segue abaixo a sua nova senha<br /><br />'
                . '<b style="font-size: 28px;">' . $c->getSenha() . '</b>'
                . '<br><br />'
                . 'Entre no aplicativo e altere sua senha!';


        $emailenviar = "softwarepyxis@gmail.com";
        $destino = $c->getEmail();
        $assunto = "Recuperar Senha Aplicativo Junior NET";

        // É necessário indicar que o formato do e-mail é html
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Junior NET <' . $emailenviar . '>';
        //$headers .= "Bcc: $EmailPadrao\r\n";
        mail($destino, $assunto, $arquivo, $headers);
    }

    /* Verifica CPF */

    function validaCPF($cpf = null) {
        // Verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }
        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    /* MOSTRA AS INFORMAÇÕES */

    public function getInfo() {
        $sql = $this->mysql->select("mural", "*", "", "id DESC");
        if (mysqli_num_rows($sql) > 0) {
            while ($info = mysqli_fetch_array($sql)) {
                
                ?>
                <div class="card blue-grey darken-1" style="width: 100%;">
                    <div class="card-content white-text">
                        <span class="card-title"><?php echo utf8_decode($info['titulo']) ?></span>
                        <?php
                        echo '<p>' . utf8_decode($info['descricao']) . '</p>';
                        ?>
                    </div>
                    <div class="card-action center-align">
                        <a href="#modalEdit" class="waves-effect waves-light btn modal-trigger" id="btnEditMural" idmural="<?php echo $info['id'] ?>" titulo="<?php echo utf8_decode($info['titulo']) ?>">Editar</a>
                        <a class="waves-effect waves-light btn modal-trigger" href="#modalEx" id="btnExcluMural" idmural="<?php echo $info['id'] ?>" title="Exluir" titulo="<?php echo utf8_decode($info['titulo']) ?>">Excluir</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo 'Nenhuma informação encontrada!<br />Adicione uma nova informação!';
        }
    }

    /* Nome do mês */

    public function nomeMes($mes) {
        switch ($mes) {
            case 1:
                return 'Janeiro';
            case 2:
                return 'Fevereiro';
            case 3:
                return 'Março';
            case 4:
                return 'Abril';
            case 5:
                return 'Maio';
            case 6:
                return 'Junho';
            case 7:
                return 'Julho';
            case 8:
                return 'Agost';
            case 9:
                return 'Setembro';
            case 10:
                return 'Outubro';
            case 11:
                return 'Novembro';
            case 12:
                return 'Dezembro';
        }
    }

    /* FATURAS */
    
    public function nomeStatus($status) {
        switch ($status){
            case 'pending':
                return "Pendente";
            case 'cancelled':
                return "Vencido ou Cancelado";
            case 'in_process':
                return "Processando";
            case 'approved':
                return "Pago";
        }
    }

    public function getFaturas($idCliente) {
        $sql = $this->mysql->select("fatura", "*", "idCliente = $idCliente", "id DESC");
        if (mysqli_num_rows($sql) > 0) {
            while ($fatura = mysqli_fetch_array($sql)) {
                //red darken-1
                ?>
                <div class="card-panel <?php echo ($fatura['status'] != "pending")? 'teal red darken-1': 'red darken-4'; ?>">
                    <div class="card-content white-text">
                        <div class="row center-align">
                            <div class="col s12 m2">
                                <br />
                                Lançada em<br /><b><?php echo date("d/m/Y", $fatura['lancamento']) ?></b>
                            </div>
                            <div class="col s12 m2">
                                <br />
                                Vencimento em<br /><b><?php echo $fatura['vencimento'] ?></b>
                            </div>
                            <div class="col s12 m2 center-align">
                                <br />
                                Valor
                                <br />
                                R$ <b style="font-size: 23px;"><?php echo $fatura['valor'] ?></b>
                            </div>
                            <div class="col s12 m3 center-align">
                                <br />
                                Status do pagamento
                                <br />
                                <b><?php echo $this->nomeStatus( $fatura['status'] ) ?></b>
                            </div>
                            <div class="col s12 m3">
                                <br />
                                <a href="<?php echo $fatura['link'] ?>" target="_blank" class="waves-effect waves-light btn">Download Boleto</a>
                                <br />
                                <br />
                                <a href="javascript:void(0)" id="btnMPago" lang="<?php echo $fatura['payment_id'] ?>" class="waves-effect waves-light green darken-1 btn">Marcar como Pago</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo 'Nenhuma Fatura do Cliente!';
        }
    }

    //Mostra o total das faturas pagas no mês
    public function faturamentoMesPagos() {
        $mes = date("m");
        $total = 0;

        //bucando todos as faturas salvas
        $sql = $this->mysql->select("fatura", "*", "");
        if (mysqli_num_rows($sql) > 0) {
            while ($faturaSQL = mysqli_fetch_array($sql)) {
                $fatura = new Fatura();
                //salvando os dados no objeto
                $fatura->salvaFatura($faturaSQL);

                $d = $fatura->getData();
                //Verifica se o mês da fatura é o mes atual
                if (date("m", $d) == $mes) {

                    //verifica se a fatura foi paga
                    if ($fatura->getStatus() == 'approved') {
                        $total += $fatura->getValor();
                    }
                }
            }
        }
        return floatval($total);
    }

    //Mostra o faturamento que ainda será recebido
    public function faturamentoMesPendente() {
        $mes = date("m");
        $total = 0;

        //bucando todos as faturas salvas
        $sql = $this->mysql->select("fatura", "*", "");
        if (mysqli_num_rows($sql) > 0) {
            while ($faturaSQL = mysqli_fetch_array($sql)) {
                $fatura = new Fatura();
                //salvando os dados no objeto
                $fatura->salvaFatura($faturaSQL);

                $d = $fatura->getData();
                //Verifica se o mês da fatura é o mes atual
                if (date("m", $d) == $mes) {

                    //verifica se a fatura foi paga
                    if ($fatura->getStatus() == 'pending') {
                        $total += $fatura->getValor();
                    }
                }
            }
        }
        return floatval($total);
    }

    /* VERIFICA EMAIL */

    public function verificaEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

}
