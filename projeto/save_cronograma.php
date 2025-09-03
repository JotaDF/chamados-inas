<?php 
require_once("actions/ManterCronograma.php");
require_once("dto/Cronograma.php");

$id          = isset($_POST["id_cronograma"]) ? $_POST["id_cronograma"] : 0;
$id_eap_item = isset($_POST["id_eap_item"]) ? $_POST["id_eap_item"] : 0;
$descricao   = html_entity_decode($_POST["descricao"]);
$inicio_prev = $_POST["inicio_prev"];
$fim_prev    = $_POST["fim_prev"];
$inicio_real = $_POST['inicio_real'] ? $_POST['inicio_real'] : "NULL";
$fim_real    = $_POST['fim_real'] ? $_POST['fim_real'] : "NULL";

$eap_item    = $_POST["id_eap_item"];
$c = new Cronograma();
 
$c->id            = $id;
$c->conteudo      = $conteudo;
$c->descricao     = $descricao;
$c->inicio_prev   = $inicio_prev;
$c->fim_prev      = $fim_prev;
$c->inicio_real   = $inicio_real;
$c->fim_real      = $fim_real;
$c->status        = 'Não Iniciado';
$c->eap_item      = $eap_item;

$db_cronograma     = new ManterCronograma();
$resultado  = $db_cronograma->salvar($c);

if($resultado) {
    header("Location: cronograma.php?id=" . $id_eap_item);
} else {
    header("Location: cronograma.php?id=" . $id_eap_item);
}