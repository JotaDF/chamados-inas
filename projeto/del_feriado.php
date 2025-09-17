<?php 
require_once('actions/ManterFeriadoAno.php');
$db_feriado_ano = new ManterFeriadoAno();
$id_feriado = $_GET['id'];

$resultado = $db_feriado_ano->excluir($id_feriado);

if($resultado) {
    header('Location: feriados.php');
} 