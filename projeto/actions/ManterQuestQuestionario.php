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
    function salvar(QuestQuestionario $dados) {
        $sql = "insert into quest_questionario (titulo, descricao) values ('" .$dados->titulo. "', '" .$dados->descricao. "')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}