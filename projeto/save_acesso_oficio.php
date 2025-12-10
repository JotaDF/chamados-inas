<?php

include_once('actions/ManterAcessoOficio.php');
require_once('./dto/AcessoOficio.php');

$manterAcessoOficio = new ManterAcessoOficio();
$id =  isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$setor  = $_REQUEST['setor'];
$id_usuario = $_REQUEST['id_usuario'];
$editor =  isset($_REQUEST['editor']) ? $_REQUEST['editor'] : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;

$acessoOficio = new AcessoOficio();
$acessoOficio->id = $id;
$acessoOficio->setor = $setor;
$acessoOficio->usuario = $id_usuario;
$acessoOficio->editor = $editor;

if ($op == 1) {
    $manterAcessoOficio->salvar($acessoOficio);
} else {
    $manterAcessoOficio->excluir($id);
}
header('Location: gerenciar_acessos_oficio.php');