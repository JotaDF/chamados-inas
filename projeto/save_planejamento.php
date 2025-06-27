<?php 
require_once './actions/ManterPlanejamento.php';
require_once './dto/Planejamento.php';
$db_planejamento = new ManterPlanejamento();
$p            = new Planejamento;

$p->id           = isset($_POST['id_planejamento']) ? $_POST['id_planejamento'] : 0;
$p->nome         = $_POST['nome'];
$p->ano_inicio   = $_POST['ano_inicio'];
$p->ano_fim      = $_POST['ano_fim'];
$p->missao       = html_entity_decode($_POST['missao']);
$p->visao        = html_entity_decode($_POST['visao']);
$resultado = $db_planejamento->salvar($p);
if($resultado) {
    header('Location: planejamento.php');
}