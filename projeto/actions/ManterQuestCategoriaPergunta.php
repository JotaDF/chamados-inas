<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Categoria.php');
require_once('dto/QuestCategoriaPergunta.php');

class ManterQuestCategoriaPergunta extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar(string $filtro) {
        $sql = "select c.id,c.nome, id_quest_questionario, (select count(*) from quest_pergunta_categoria as pc where pc.id_quest_categoria_pergunta=c.id) as dep FROM quest_categoria_pergunta as c $filtro order by c.id";
	//echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestCategoriaPergunta();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id              = $registro["id"];
            $dados->nome            = $registro["nome"];
            $dados->questionario    = $registro["id_quest_questionario"];
            $dados->total_perguntas = $registro["dep"];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
    function getCategoriaPorId(int $id) {
        $sql = "select c.id,c.nome, id_quest_questionario, (select count(*) from quest_pergunta_categoria as pc where pc.id_quest_categoria_pergunta=c.id) as dep  FROM quest_pergunta_categoria as c WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new QuestCategoriaPergunta();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->questionario    = $registro["id_quest_questionario"];
            $dados->total_perguntas = $registro["dep"];
        }
        return $dados;
    }
    function getPeguntasPorCategoria(int $id) {
        $sql = 'SELECT qp.id, qp.titulo, qp.pergunta, qp.publicada, qp.id_quest_escala, qp.opcional FROM quest_pergunta AS qp, quest_pergunta_categoria AS qpc WHERE qpc.id_quest_pergunta=qp.id AND qpc.id_quest_categoria_pergunta=' . $id . ' ORDER BY qp.id';
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                            = new QuestPergunta();
            $dados->excluir                   = true;
            $dados->id                        = $registro['id'];
            $dados->titulo                    = $registro['titulo'];
            $dados->pergunta                  = $registro['pergunta'];
            $dados->publicada                 = $registro['publicada'];
            $dados->opcional                  = $registro['opcional'];
            $dados->id_quest_escala           = $registro['id_quest_escala'];
            $array_dados[]                    = $dados;
        }

        return $array_dados;
    }
    function getPeguntasNaoVinculadasCategoria(int $id) {
        $sql = 'SELECT qp.id, qp.titulo, qp.pergunta, qp.publicada, qp.id_quest_escala, qp.opcional FROM quest_pergunta AS qp  WHERE qp.id NOT IN(SELECT id_quest_pergunta FROM quest_pergunta_categoria WHERE id_quest_categoria_pergunta=' . $id . ') ORDER BY qp.id';
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                            = new QuestPergunta();
            $dados->excluir                   = true;
            $dados->id                        = $registro['id'];
            $dados->titulo                    = $registro['titulo'];
            $dados->pergunta                  = $registro['pergunta'];
            $dados->publicada                 = $registro['publicada'];
            $dados->opcional                  = $registro['opcional'];
            $dados->id_quest_escala           = $registro['id_quest_escala'];
            $array_dados[]                    = $dados;
        }

        return $array_dados;
    }
    function salvar(QuestCategoriaPergunta $dados) {
        $sql = "insert into quest_categoria_pergunta (nome,id_quest_questionario) values ('" . $dados->nome . "','" . $dados->questionario . "')";
        if ($dados->id > 0) {
            $sql = "update quest_categoria_pergunta set nome='" . $dados->nome . "',id_quest_questionario='" . $dados->questionario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from quest_categoria_pergunta where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

