<?php 
require_once 'Model.php';
require_once 'dto/QuestQuestionario.php';

Class ManterQuestQuestionario extends Model {

    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = 'select id, titulo, descricao FROM quest_questionario';
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                         = new QuestQuestionario();
            $dados->excluir                = true;
            $dados->id                     = $registro['id'];
            $dados->titulo                   = $registro['titulo'];
            $dados->descricao              = $registro['descricao'];
            $array_dados[]                 = $dados;
        }
        return $array_dados;
    }
    function getQuestionarioPorId($id) {
        $sql = 'select id, titulo, descricao FROM quest_questionario WHERE id=' . $id;
        $resultado = $this->db->Execute($sql);
        $dados  = new QuestQuestionario();
        if($registro = $resultado->fetchRow()) {
            $dados->excluir    = true;
            $dados->id         = $registro['id'];
            $dados->titulo     = $registro['titulo'];
            $dados->descricao  = $registro['descricao'];
        }
        return $dados;
    }

    function getQuestionarioPorIdUsuario($id) {
        $sql = 'select id, titulo, descricao FROM quest_questionario WHERE id_usuario=' . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados  = new QuestQuestionario();
            $dados->excluir    = true;
            $dados->id         = $registro['id'];
            $dados->titulo     = $registro['titulo'];
            $dados->descricao  = $registro['descricao'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function salvar(QuestQuestionario $dados) {
        $sql = "insert into quest_questionario (titulo, descricao, id_usuario) values ('" .$dados->titulo. "', '" .$dados->descricao. "', '" .$dados->id_usuario. "')";
        if ($dados->id > 0) {
            $sql = "update quest_questionario set titulo='". $dados->titulo ."', descricao='". $dados->descricao ."', id_usuario='". $dados->id_usuario ."' WHERE id= '". $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = 'delete from quest_questionario where id=' . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}