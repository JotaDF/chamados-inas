<?php 
require_once './dto/Indicador.php';
require_once './actions/ManterIndicador.php';

$id_objetivo  = isset($_POST['id_objetivo']) ? $_POST['id_objetivo'] : 0;
$id_indicador = isset($_POST['id_indicador']) ? $_POST['id_indicador'] : 0;
$i = new Indicador;

$i->id        = $id_indicador;
$i->nome      = $_POST['nome'];
$i->unidade   = $_POST['unidade'];
$i->objetivo  = $id_objetivo;
$db_indicador = new ManterIndicador();

$resultado    = $db_indicador->salvar($i);
if ($resultado) {
    header('Location: indicador.php?id=' . $id_objetivo);
}

