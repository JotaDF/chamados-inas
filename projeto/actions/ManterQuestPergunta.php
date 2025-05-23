<?php 
require_once 'Model.php';
require_once 'dto/QuestPergunta.php';

Class ManterQuestPergunta extends Model {
 
    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = 'SELECT qp.id AS id, qp.titulo AS titulo, qp.pergunta AS pergunta, qp.publicada AS publicada, qp.id_quest_escala AS id_quest_escala, qp.opcional AS opcional, qe.id AS id_escala, qe.nome AS nome_escala FROM quest_pergunta AS qp, quest_escala AS qe WHERE qp.id_quest_escala = qe.id';
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
            $dados->nome                      = $registro['nome_escala'];
            $dados->id_quest_escala           = $registro['id_quest_escala'];
            $array_dados[]                    = $dados;
        }

        return $array_dados;
    }
    function salvar(QuestPergunta $dados) {
       $sql = "insert into quest_pergunta (titulo, pergunta, id_quest_escala, opcional ) values ('" .$dados->titulo. "', '" .$dados->pergunta. "', '" .$dados->id_quest_escala. "', '" .$dados->opcional. "')";
        
        if($dados->id > 0) {
            $sql = "update quest_pergunta SET titulo='". $dados->titulo ."', pergunta='". $dados->pergunta . "', id_quest_escala='". $dados->id_quest_escala . "', opcional='". $dados->opcional ."' WHERE id='". $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        }  else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM quest_pergunta WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}