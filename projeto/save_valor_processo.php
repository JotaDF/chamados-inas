<?php

require_once('./actions/ManterValorProcesso.php');
require_once('./dto/OpcaoValorProcesso.php');

$db_valor_processo = new ManterValorProcesso();
$vp = new ValorProcesso();

$id_processo = $_POST['id_processo'];
$id_tipo_valor = $_POST['id_tipo_valor'];
$valor = $_POST['valor'];
$data_pagamento   = isset($_POST['data_pagamento']) ? strtotime($_POST['data_pagamento']) : 0;

$vp->id_processo    = $id_processo;
$vp->id_tipo_valor  = $id_tipo_valor;
$vp->valor          = $valor;
$vp->data_pagamento = $data_pagamento;

$db_valor_processo->save($vp);
header('Location: gerenciar_valores_processo.php?id='.$id_processo);

