<?php
class SettingsDAO{
    private $mysql;
    public $settings;
    
    function __construct() {
        $this->mysql = new Mysql();
        $this->settings = new Settings();
        $this->getSettings();
    }
    
    private function getSettings(){
        $sql = $this->mysql->select("settings","*", "id = 1");
        while($settings = mysqli_fetch_array($sql)){
            $this->settings->setId($settings['id']);
            $this->settings->setDias_venc($settings['dias_venc']);
            $this->settings->setToken($settings['tokken_api']);
            $this->settings->setDesc($settings['descricao']);
            $this->settings->setEmail($settings['email']);
            $this->settings->setEnde($settings['endereco']);
            $this->settings->setTel($settings['telefone']);
        }
    }
    
    public function settings() {
        return $this->settings;
    }
    
    public function salvaSetings() {
        $retorno = array();
        $retorno['erro'] = false;
        $retorno['msg'] = "";
        
        $sql = $this->mysql->update("settings", "endereco = '".$this->settings->getEnde()."', descricao = '".$this->settings->getDesc()."', email = '".$this->settings->getEmail()."', telefone = ".$this->settings->getTel().", tokken_api = '".$this->settings->getToken()."', dias_venc = '" . $this->settings->getDias_venc()."'", "id = 1");
        if(!$sql){
            $retorno['erro'] = true;
            $retorno['msg'] = $this->mysql->getErro();
        }
        
        return $retorno;
    }
}