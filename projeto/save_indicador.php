<?php 
require_once './dto/Indicador.php';
require_once './actions/ManterIndicador.php';

$id_objetivo  = isset($_POST['id_objetivo']) ? $_POST['id_objetivo'] : 0;
$id_indicador = isset($_POST['id_indicador']) ? $_POST['id_indicador'] : 0;
$i = new Indicador;

$i->id                           = $id_indicador;
$i->objetivo                     = $id_objetivo;
$i->nome                         = $_POST['nome'];
$i->unidade                      = $_POST['unidade'];
$i->indicador_desempenho         = $_POST['indicador_desempenho'];
$i->periodicidade                = $_POST['periodicidade'];
$i->tendencia                    = $_POST['tendencia'];
$i->fonte                        = html_entity_decode($_POST['fonte']);
$i->linha_base                   = html_entity_decode($_POST['linha_base']);
$i->metodologia                  = html_entity_decode($_POST['metodologia']);
// var_dump($i);
$db_indicador         = new ManterIndicador();

$resultado            = $db_indicador->salvar($i);
if ($resultado) {
    header('Location: indicador.php?id=' . $id_objetivo);
    exit();
} else {
    echo $resultado;
     header('Location: indicador.php?id=' . $id_objetivo);
     echo "Falta Parametro";
     exit();
}

