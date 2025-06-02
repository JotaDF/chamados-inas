<?php
include_once 'Model.php';
include_once 'dto/QuestAplicacao.php';
include_once 'dto/QuestQuestionario.php';
include_once 'dto/QuestResposta.php';
class ManterQuestAplicacao extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT id, inicio, termino, publicado FROM quest_aplicacao";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestAplicacao;
            $dados->id                                      = $registro['id'];
            $dados->inicio                                  = $registro['inicio'];
            $dados->termino                                 = $registro['termino'];
            $dados->publicado                               = $registro['publicado'];
            $array_dados[]                                  = $dados;
        }

        return $array_dados;
    }

    function getQuestionario($id) {
        $sql = "SELECT qq.titulo as quest_titulo, qq.descricao as quest_descricao, qp.titulo as quest_pergunta_titulo, qe.nome, qe.descricao, qe.parametro FROM quest_aplicacao AS qa,
        quest_pergunta AS qp, quest_pergunta_categoria AS qpc, quest_questionario AS qq,quest_categoria_pergunta AS qcp, quest_escala AS qe
        WHERE qa.id_quest_questionario = qq.id AND qcp.id_quest_questionario = qq.id AND qcp.id = qpc.id_quest_categoria_pergunta AND qpc.id_quest_pergunta = qp.id AND qe.id = qp.id_quest_escala AND qq.id =" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados  = new QuestAplicacao();
            $dados->id                  = $registro['id'];
            $dados->titulo              = $registro['titulo'];
            $dados->descricao           = $registro['descricao'];
            $dados->pergunta            = $registro['pergunta'];
            $dados->nome                = $registro['nome'];
            $dados->descricao           = $registro['descricao'];
            $dados->parametro           = $registro['parametro'];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }

    function getPerguntaPorQuestionario($id) {
        $sql = "SELECT id, titulo, pergunta, publicada, opcional, id_quest_escala FROM quest_pergunta WHERE id_ques";
    }

    function getAplicacaoPorId($id) {
        $sql = 'select id, inicio, termino, publicado FROM quest_aplicacao WHERE id_quest_questionario=' . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados  = new QuestAplicacao();
            $dados->excluir       = true;
            $dados->id            = $registro['id'];
            $dados->inicio        = $registro['inicio'];
            $dados->termino       = $registro['termino'];
            $dados->publicado     = $registro['publicado'];
            $array_dados[]        = $dados; 
        }
        return $array_dados;
    }

    function salvar(QuestAplicacao $dados) {
        $sql = "INSERT INTO quest_aplicacao (inicio, termino, id_quest_questionario) 
        VALUES ('" . $dados->inicio . "', '" . $dados->termino ."', '" . $dados->id_quest_questionario ."')";
        if($dados->id > 0) {
            $sql = "UPDATE quest_aplicacao SET inicio='" . $dados->inicio ."', termino='". $dados->termino ."' WHERE id='". $dados->id ."'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function publicar($id) {
        $sql = "UPDATE quest_aplicacao SET publicado = 1 WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    
    function despublicar($id) {
        $sql = "UPDATE quest_aplicacao SET publicado = 0 WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM quest_aplicacao WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }


}