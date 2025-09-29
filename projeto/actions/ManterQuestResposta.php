<?php
require_once 'actions/Model.php';
require_once 'dto/QuestResposta.php';

class ManterQuestResposta extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function lista()
    {
        $sql = "SELECT qp.id_quest_pergunta, qp.id_quest_aplicacao, qp.execucao, qp.resposta";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestResposta;
            $dados->id_quest_pergunta = $registro['id_quest_pergunta'];
            $dados->id_quest_aplicacao = $registro['id_quest_aplicacao'];
            $dados->execucao = $registro['execucao'];
            $dados->resposta = $registro['resposta'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function salvar(QuestResposta $dados)
    {
        $sql = "INSERT INTO quest_resposta VALUES ( '" . $dados->id_quest_pergunta . "','" . $dados->id_quest_aplicacao . "',now(),'" . $dados->resposta . "')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getTotalRespostaPorIdQuestionario($id = 0)
    {
        $sql = "SELECT COUNT(*) as total FROM quest_resposta as qr, quest_aplicacao as qa, quest_questionario as qq WHERE qr.id_quest_aplicacao = qa.id AND qa.id_quest_questionario = qq.id AND resposta is not null AND qq.id =" . $id;
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
        $total    = $registro['total'];
        return $total;
    }
    function getRespostaPorIdQuestionario($id)
    {
        $sql = "SELECT qp.pergunta, qr.id_quest_aplicacao, qr.resposta FROM quest_resposta AS qr, quest_pergunta AS qp, quest_aplicacao AS qa WHERE qr.id_quest_aplicacao = qa.id AND qp.id = qr.id_quest_pergunta AND qa.id_quest_questionario = $id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestResposta;
            $dados->id_quest_pergunta = $registro['id_quest_pergunta'];
            $dados->id_quest_aplicacao = $registro['id_quest_aplicacao'];
            $dados->execucao = $registro['execucao'];
            $dados->resposta = $registro['resposta'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getTodasRespostaPorPerguntaQuestionario($id_questionario = 0, $id_pergunta = 0) {
        $sql = "SELECT qr.resposta, qr.execucao FROM quest_resposta as qr, quest_aplicacao as qa, quest_questionario as qq, quest_pergunta as qp WHERE qr.id_quest_pergunta = qp.id  AND qr.id_quest_aplicacao = qa.id AND qa.id_quest_questionario = qq.id  AND qq.id = $id_questionario AND qp.id =" . $id_pergunta;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestResposta;
            $dados->execucao = $registro['execucao'];
            $dados->resposta = $registro['resposta'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getTotalRespostaPorParametro($id_questionario, $id_pergunta) {
        $sql = "SELECT DISTINCT COUNT(qr.resposta) as total_resposta, qr.resposta FROM quest_resposta as qr, quest_aplicacao as qa, quest_questionario as qq, quest_pergunta as qp WHERE qr.id_quest_pergunta = qp.id AND qr.id_quest_aplicacao = qa.id AND qa.id_quest_questionario = qq.id AND qq.id = $id_questionario AND qp.id = $id_pergunta GROUP BY qr.resposta";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $array_dados[$registro['resposta']] = $registro['total_resposta'];
        }
        return $array_dados;
    }
        function getTotalRespostaPorPerguntaQuestionario($id_questionario = 0, $id_pergunta = 0) {
        $sql = "SELECT COUNT(*) as total FROM quest_resposta as qr, quest_aplicacao as qa, quest_questionario as qq, quest_pergunta as qp WHERE qr.id_quest_pergunta = qp.id  AND qr.id_quest_aplicacao = qa.id AND qa.id_quest_questionario = qq.id AND resposta is not null AND qq.id = $id_questionario AND qp.id =" . $id_pergunta;
        $resultado = $this->db->Execute($sql); 
        $dados     = $resultado->fetchRow();
        $total     = $dados['total'];
        return $total;
    }
}