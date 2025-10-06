<?php
require_once 'Model.php';
require_once 'dto/QuestPergunta.php';

class ManterQuestPergunta extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listar()
    {
        $sql = 'SELECT qp.id, qp.titulo, qp.pergunta, qp.id_quest_escala, qp.opcional, qe.nome as escala FROM quest_pergunta AS qp, quest_escala AS qe WHERE qp.id_quest_escala = qe.id';
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestPergunta();
            $dados->excluir = true;
            $dados->id = $registro['id'];
            $dados->titulo = $registro['titulo'];
            $dados->pergunta = $registro['pergunta'];
            $dados->opcional = $registro['opcional'];
            $dados->escala = $registro['escala'];
            $dados->id_quest_escala = $registro['id_quest_escala'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    function getPerguntaPorUsuario($id)
    {
        $sql = 'SELECT qp.id, qp.titulo, qp.pergunta, qp.id_quest_escala, qp.opcional, qe.nome as escala FROM quest_pergunta AS qp, quest_escala AS qe WHERE qp.id_quest_escala = qe.id AND qp.id_usuario=' . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestPergunta();
            $dados->excluir = true;
            $dados->id = $registro['id'];
            $dados->titulo = $registro['titulo'];
            $dados->pergunta = $registro['pergunta'];
            $dados->opcional = $registro['opcional'];
            $dados->escala = $registro['escala'];
            $dados->id_quest_escala = $registro['id_quest_escala'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }
    
    function getQuestionarioPorUsuario($id)
    {
        $sql = 'SELECT qp.id, qp.titulo, qp.pergunta, qp.id_quest_escala, qp.opcional, qe.nome as escala FROM quest_pergunta AS qp, quest_escala AS qe WHERE qp.id_quest_escala = qe.id AND id_usuario =' . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestPergunta();
            $dados->excluir = true;
            $dados->id = $registro['id'];
            $dados->titulo = $registro['titulo'];
            $dados->pergunta = $registro['pergunta'];
            $dados->opcional = $registro['opcional'];
            $dados->escala = $registro['escala'];
            $dados->id_quest_escala = $registro['id_quest_escala'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }


    function getPerguntaPorId($id)
    {
        $sql = 'SELECT pergunta FROM quest_pergunta WHERE id=' . $id;
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
        $pergunta = $registro['pergunta'];
        return $pergunta;
    }
    function getEscalaPorPergunta($id = 0)
    {
        $sql = "SELECT qe.nome as escala FROM quest_pergunta as qp, quest_escala as qe WHERE qp.id_quest_escala = qe.id AND qp.id =" . $id;
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
        $escala = $registro['escala'];
        return $escala;
    }
    function getParametroPergunta($id = 0)
    {
        $sql = "SELECT qe.parametro FROM quest_escala as qe, quest_pergunta as qp WHERE qp.id_quest_escala = qe.id AND qp.id =" . $id;
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
        $parametro = $registro['parametro'];
        return $parametro;
    }
    function salvar(QuestPergunta $dados)
    {
        $sql = "insert into quest_pergunta (titulo, pergunta, id_quest_escala,id_usuario, opcional) values ('" . $dados->titulo . "', '" . $dados->pergunta . "', '" . $dados->id_quest_escala . "','" . $dados->id_usuario . "', '" . $dados->opcional . "')";

        if ($dados->id > 0) {
            $sql = "update quest_pergunta SET titulo='" . $dados->titulo . "', pergunta='" . $dados->pergunta . "', id_quest_escala='" . $dados->id_quest_escala . "',id_usuario='" . $dados->id_usuario . "', opcional='" . $dados->opcional . "' WHERE id='" . $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id)
    {
        $sql = "DELETE FROM quest_pergunta WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}