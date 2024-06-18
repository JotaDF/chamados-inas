<?php

require_once('./actions/ManterValorProcesso.php');
require_once('./dto/OpcaoValorProcesso.php');

$db_valor_processo = new ManterValorProcesso();
$vp = new ValorProcesso();

$id_processo = $_POST['id_processo'];
$id_tipo_valor = $_POST['id_tipo_valor'];
$valor = $_POST['valor'];

$vp->id_processo    = $id_processo;
$vp->id_tipo_valor  = $id_tipo_valor;
$vp->valor          = $valor;

$db_valor_processo->save($vp);
header('Location: gerenciar_valores_processo.php?id='.$id_processo);

