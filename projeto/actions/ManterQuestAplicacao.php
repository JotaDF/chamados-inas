<?php
require_once 'Model.php';
require_once 'dto/QuestAplicacao.php';

class ManterQuestAplicacao extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT id, inicio, termino, publicado, id_quest_questionario FROM quest_aplicacao";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestAplicacao;
            $dados->id                              = $registro['id'];
            $dados->inicio                          = $registro['inicio'];
            $dados->termino                         = $registro['termino'];
            $dados->publicado                       = $registro['publicado'];
            $dados->id_quest_questionario           = $registro['id_quest_questionario'];
            $array_dados                            = $dados;
        }

        return $resultado;
    }

    function getQuestionarioPorId($id = 0) {
        $sql = "SELECT qa.id, qa.inicio, qa.termino, qa.publicado, qa.id_quest_questionario, qq.id, qq.titulo FROM quest_aplicacao as qa, quest_questionario as qq WHERE qa.id_quest_questionario = " . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new QuestAplicacao;
            $dados->id                                                      = $registro['id'];
            $dados->inicio                                                  = $registro['inicio'];
            $dados->termino                                                 = $registro['termino'];
            $dados->publicado                                               = $registro['publicado'];
            $dados->publicado                                               = $registro['titulo'];
            $dados->id_quest_questionario                                   = $registro['id_quest_questionario'];
        }
    }

}