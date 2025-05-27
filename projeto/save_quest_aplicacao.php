<?php 
require_once 'actions/ManterQuestAplicacao.php';
require_once 'dto/QuestAplicacao.php';


if (isset($_SERVER['REQUEST_METHOD']) == 'POST' ) {

    $id                        = $_POST['id'];
    $inicio                    = $_POST['inicio'];
    $termino                   = $_POST['termino'];
    $id_questionario           = $_POST['id_quest_questionario'];
    


    $ap              = new QuestAplicacao;
    $ap->id                           = $id;
    $ap->inicio                       = $inicio;
    $ap->termino                      = $termino;
    $ap->id_quest_questionario        = $id_questionario;
    

    $manterQuestAplicacao        = new ManterQuestAplicacao;
    $resultado                   = $manterQuestAplicacao->salvar($ap);

    if($resultado) {
        header('Location: quest_gerenciar_aplicacoes_questionario.php?id=' . $id_questionario);
        exit;
    }
}   