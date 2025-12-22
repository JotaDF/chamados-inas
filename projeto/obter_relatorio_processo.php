<?php
require_once('actions/ManterProcesso.php');
header('Content-Type: application/json; charset=utf-8');
$ano = $_GET['ano'];
$tipo= $_GET['tipo'];
$arquivado= $_GET['arquivado'];
$ordem= $_GET['ordem'];
$manterProcesso = new ManterProcesso();
if($tipo == 'grafico_motivo')
    if(isset($ordem))
        $dados = $manterProcesso->getRelatorioTotalMotivosPorAno($ano, $arquivado, $ordem);
    else 
        $dados = $manterProcesso->getRelatorioTotalMotivosPorAno($ano, $arquivado, 'm.motivo');
else if($tipo == 'grafico_assunto'){
    if(isset($ordem))
        $dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado, $ordem);
    else
    $dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado, 'a.assunto, sa.sub_assunto');
} 

echo json_encode($dados);

