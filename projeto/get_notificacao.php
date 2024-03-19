<?php
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
	
$db_notificacao = new ManterNotificacao();
$n = new Notificacao();
	
$lista = $db_notificacao->listarPorUsuario($usuario_logado->id);

foreach ($lista as $obj) {
    $icon = " fas fa-exclamation-triangle ";
    if ($obj->tipo == "interacao") {
        $icon = " fa fa-envelope ";
    }
    ?>
    <a class="dropdown-item d-flex align-items-center" href="ler_notificacao.php?id=<?=$obj->id ?>">
    <div class="mr-3">
        <div class="icon-circle bg-warning">
            <i class="<?=$icon ?> text-white"></i>
        </div>
    </div>
    <div>
        <div class="small text-gray-500"><?= date('d/m/Y h:m', strtotime($obj->data)) ?></div>
        <?=$obj->texto ?>
    </div>
</a>
<?php
}
