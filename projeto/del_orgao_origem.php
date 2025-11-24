<?php

require_once('./actions/ManterOrgaoOrigem.php');
require_once('./dto/OrgaoOrigem.php');

$db_orga_origem = new ManterOrgaoOrigem();
$orgao_origem= new OrgaoOrigem();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_orgao_origem->excluir($id);
    header('Location: orgao_origem.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: orgao_origem.php');
}
