<?php
include_once 'Model.php';
include_once 'dto/QuestAplicacao.php';
include_once 'dto/QuestQuestionario.php';
include_once 'dto/QuestResposta.php';
include_once 'dto/QuestPergunta.php';

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

    function getPerguntasPorCategoria($id) {
        $sql = "SELECT qe.nome, qe.parametro, qp.pergunta,  qp.opcional, qcp.id FROM quest_escala as qe, quest_pergunta as qp, quest_pergunta_categoria as qpc, quest_categoria_pergunta as qcp WHERE qe.id = qp.id_quest_escala AND qp.id = qpc.id_quest_pergunta AND qcp.id = qpc.id_quest_categoria_pergunta AND qpc.id_quest_categoria_pergunta = " . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                  = new stdClass;
            $dados->id              = $registro['id'];
            $dados->nome            = $registro['nome'];
            $dados->parametro       = $registro['parametro'];
            $dados->pergunta        = $registro['pergunta'];
            $dados->opcional        = $registro['opcional'];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
     function getQuestionario($id) {
        $sql = "SELECT qq.titulo as quest_titulo, qq.descricao as quest_descricao, qp.titulo as quest_pergunta_titulo, qp.opcional, qe.nome, qe.descricao, qe.parametro FROM quest_aplicacao AS qa,
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
            $dados->opcional            = $registro['opcional'];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }

    function getPerguntaPorQuestionario($id) {
        $sql = "SELECT qe.nome escala, qp.pergunta,  qp.opcional, qcp.nome as categoria, qq.titulo, qq.descricao FROM quest_escala AS qe, quest_pergunta_categoria AS qpc, quest_categoria_pergunta AS qcp, quest_pergunta AS qp, quest_questionario as qq WHERE qe.id = qp.id_quest_escala AND qp.id = qpc.id_quest_pergunta AND qcp.id = qpc.id_quest_categoria_pergunta AND qcp.id_quest_questionario = qq.id AND qq.id =" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                   = new QuestPergunta();
            $dados->id               = $registro['id_pergunta'];
            $dados->titulo           = $registro['titulo_pergunta'];
            $dados->pergunta         = $registro['pergunta'];
            $dados->escala           = $registro['escala'];
            $dados->id_quest_escala  = $registro['id_quest_escala'];
            $dados->opcional         = $registro['opcional'];
            $dados->categoria        = $registro['categoria'];
            $array_dados[]             = $dados;
        }
        return $array_dados;
    }

    function getTodasPerguntasPorQuestionario($id) {
        $sql = "SELECT qp.id as id_pergunta, qp.pergunta,  qp.opcional, qcp.nome AS nome_categoria, qcp.descricao, qe.nome AS nome_escala, qp.id_quest_escala
                FROM quest_pergunta qp, quest_pergunta_categoria qpc, quest_categoria_pergunta qcp, quest_questionario qq,quest_escala qe 
                WHERE qp.id = qpc.id_quest_pergunta AND qcp.id = qpc.id_quest_categoria_pergunta AND qe.id = qp.id_quest_escala AND qcp.id_quest_questionario = qq.id AND qq.id = $id
                ORDER BY qp.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                      = new stdClass;
            $dados->id                  = $registro['id_pergunta'];
            $dados->pergunta            = $registro['pergunta'];
            $dados->opcional            = $registro['opcional'];
            $dados->nome_categoria      = $registro['nome_categoria'];
            $dados->descricao           = $registro['descricao'];
            $dados->nome_escala         = $registro['nome_escala'];
            $dados->id_quest_escala     = $registro['id_quest_escala'];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }
    function getCategoriaPorQuestionario($id) {
        $sql = "SELECT qcp.nome, qcp.descricao, qcp.id, qcp.id_quest_questionario FROM quest_categoria_pergunta as qcp WHERE qcp.id_quest_questionario =" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro  = $resultado->fetchRow()) {
            $dados                       = new QuestCategoriaPergunta;
            $dados->id                   = $registro['id'];
            $dados->nome                 = $registro['nome'];
            $dados->descricao            = $registro['descricao'];
            $dados->questionario         = $registro['id_quest_questionario'];
        }
        return $dados;
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