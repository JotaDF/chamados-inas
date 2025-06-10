<?php 
require_once 'actions/Model.php';
require_once 'dto/QuestResposta.php';

Class ManterQuestResposta extends Model{

    function __construct() {
        parent::__construct();
    }

    function lista() {
        $sql         = "SELECT qp.id_quest_pergunta, qp.id_quest_aplicacao, qp.execucao, qp.resposta";
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new QuestResposta;
            $dados->id_quest_pergunta    = $registro['id_quest_pergunta'];
            $dados->id_quest_aplicacao   = $registro['id_quest_aplicacao'];
            $dados->execucao             = $registro['execucao'];
            $dados->resposta             = $registro['resposta'];
            $array_dados[]               = $dados;
        }
        return $array_dados;
    }

    function salvar(QuestResposta $dados) {
        $sql = "INSERT INTO quest_resposta(id_quest_pergunta, id_quest_aplicacao, execucao, resposta) VALUES ( '" . $dados->id_quest_pergunta . "','" . $dados->id_quest_aplicacao ."',now(),'" . $dados->resposta ."')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}