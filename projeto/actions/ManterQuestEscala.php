<?php 
require_once 'Model.php';
require_once 'dto/QuestEscala.php';

Class ManterQuestEscala extends Model {
 
        
    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = 'select id, nome, descricao, parametro FROM quest_escala';
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                         = new QuestEscala();
            $dados->excluir                = true;
            $dados->id                     = $registro['id'];
            $dados->nome                   = $registro['nome'];
            $dados->descricao              = $registro['descricao'];
            $dados->parametro              = $registro['parametro'];
            $array_dados[]                 = $dados;
        }

        return $array_dados;
    }
    function getParametroPorPergunta($id) {
        $sql = "SELECT qe.id, qe.nome, qe.descricao, qe.parametro FROM quest_escala as qe, quest_pergunta as qp where qe.id = qp.id_quest_escala AND qp.id_quest_escala =" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                         = new QuestEscala();
            $dados->excluir                = true;
            $dados->id                     = $registro['id'];
            $dados->nome                   = $registro['nome'];
            $dados->descricao              = $registro['descricao'];
            $dados->parametro              = $registro['parametro'];
            $array_dados[]                 = $dados;
        }

        return $array_dados;
    }
    function salvar(QuestEscala $dados) {
        $sql = "insert into quest_escala (nome, descricao, parametro) values ('" .$dados->nome. "', '" .$dados->descricao. "', '". $dados->parametro . "')";
        if ($dados->id > 0) {
            $sql = "update quest_escala set nome='". $dados->nome ."', descricao='". $dados->descricao ."', parametro='". $dados->parametro ."' WHERE id= '". $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from quest_escala where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
} 