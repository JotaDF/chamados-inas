<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterProcesso.php');
require_once('./dto/Processo.php');

$db_processo = new ManterProcesso();

$processos = $db_processo->listar(" WHERE id=1669 ");
foreach ($processos as $proc) {
    $proc->beneficiario = $db_processo->removerAcentos($proc->beneficiario);
    $db_processo->salvar($proc);
}
