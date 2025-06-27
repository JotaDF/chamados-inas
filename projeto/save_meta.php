<?php 
include './dto/Meta.php';
include_once './actions/ManterMeta.php';
$db_meta = new ManterMeta;
$m           = new Meta;

$id_indicador = isset($_POST['id_indicador']) ? $_POST['id_indicador'] : 0;
$id_meta = isset($_POST['id_meta']) ? $_POST['id_meta'] : 0;
$m->id               = $id_meta; 
$m->valor            = $_POST['valor'];
$m->data_inicio      = $_POST['data_inicio'];
$m->data_fim         = $_POST['data_fim'];
$m->indicador        = $id_indicador;

$resultado = $db_meta->salvar($m);

if ($resultado) {
    header('Location: meta.php?id=' . $id_indicador);
} else {
     header('Location: meta.php?id=' . $id_indicador);
}