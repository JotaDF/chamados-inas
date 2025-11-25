<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<br/>
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon mx-1"><img src="img/inas.svg" width="100%" /></div>
</a>
<br/>
<!-- Divider -->
<hr class="sidebar-divider">

    <?php
    if ($usuario_logado->perfil >= 1) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            SISTEMAS
        </div>
<?php
$agenda = false;
foreach ($acessos as $acesso) {
    if($acesso->id_modulo != 1){
        $request = "";
        $icon_css = "";
        switch ($acesso->id_modulo) {
            case 2:
                $icon_css = "fa fa-cogs";
                break;
            case 3:
                $icon_css = "fa fa-history";
                break;
            case 4:
                $icon_css = "fa fa-laptop";
                break;
            case 5:
                $icon_css = "fa fa-tasks";
                break;
            case 6:
                $icon_css = "fa fa-balance-scale";
                break; 
            case 7:
                $icon_css = "fa fa-id-badge"; 
                break; 
            case 8:
                $icon_css = "fa fa-calendar";
                $agenda = true;
                break;  
            case 9:
                $icon_css = "fa fa-address-book";
                break; 
            case 10:
                $icon_css = "fa fa-suitcase";
                break;
            case 11:
                $icon_css = "fa fa-file-pdf";
                break; 
            case 12:
                $icon_css = "fa fa-file";
                break;    
            case 13:
                $icon_css = "fa fa-calculator";
                break; 
            case 14:
                $icon_css = "fa fa-hourglass-half";
                break;     
            case 15:
                $icon_css = "fa fa-signal";
                $request = "?texto=". $db_usuario->encryptarMensagem("nome=".$usuario_logado->nome."&login=".$usuario_logado->login."&matricula=".$usuario_logado->matricula."&perfil=".$db_usuario->getAcessoUsuario($usuario_logado->id,15));
                break; 
            case 16:
                $icon_css = "fa fa-question-circle";
                break;  
            case 17:
                $icon_css = "fa fa-shopping-cart";
                break;
            case 18:
                $icon_css = "fa fa-puzzle-piece";
                break;
            case 19:
                $icon_css = "fa fa-list-alt";
                $request = "?texto=". $db_usuario->encryptarMensagem("nome=".$usuario_logado->nome."&login=".$usuario_logado->login."&matricula=".$usuario_logado->matricula."&perfil=".$db_usuario->getAcessoUsuario($usuario_logado->id,15));
                break;               
            case 20:
                $icon_css = "fa fa-credit-card";
                break;    
            case 21:
                $icon_css = "fa fa-comments";
                break; 
            case 22:
                $icon_css = "fa fa-user-md";
                break;                                                           
        }
        
?> 
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?=$acesso->link . $request ?>">
                    <i class="<?=$icon_css ?>"></i>
                    <span><?=$acesso->modulo ?></span>
                </a>
            </li>
            <!-- Divider -->
        <hr class="sidebar-divider">
            <?php
    }
    }

    if(!$agenda){
        if($usuario_logado->agenda == 1){
?>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="agendas.php">
                    <i class="fa fa-calendar"></i>
                    <span>Agenda</span>
                </a>
            </li>
            <!-- Divider -->
        <hr class="sidebar-divider">
<?php
        } else {
            require_once('./actions/ManterAgenda.php');
            $db_agenda = new ManterAgenda();
            if(count($db_agenda->getAgendasQueAcesso($usuario_logado->id)) > 0){
                ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="agendas.php">
                        <i class="fa fa-calendar"></i>
                        <span>Agenda</span>
                    </a>
                </li>
                <!-- Divider -->
            <hr class="sidebar-divider">
            <?php 
            }
        }
    }

}

?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->