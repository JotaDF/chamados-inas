<?php
include_once('actions/ManterUsuario.php');
include_once('actions/ManterAcessoOficio.php');
require_once('./dto/AcessoOficio.php');

$manterUsuario = new ManterUsuario();
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
    $manterUsuario->permitirAcesso(23,$id_usuario,3); //perfil usuário (3) módulo ofício (23)
} else {
    $manterAcessoOficio->excluir($id);
    $manterUsuario->removerAcesso(23,$id_usuario);
}
header('Location: gerenciar_acessos_oficio.php');