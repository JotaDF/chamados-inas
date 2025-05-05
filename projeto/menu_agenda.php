<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<br/>
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon mx-1"><img src="img/inas.svg" width="100%" /></div>
</a>
<br/>
<!-- Divider -->
<hr class="sidebar-divider" style="color:white;">
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="index.php">
        <i class="fa fa-home"></i>
        <span>Início</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider" style="color:white;">
        <!-- Heading -->
        <div class="sidebar-heading">
            AGENDA
        </div>
    <?php
    if ($usuario_logado->perfil == 1 || $usuario_logado->agenda == 1) {
        ?>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="agenda.php?id=<?=$usuario_logado->id ?>">
                    <i class="fa fa-calendar-check"></i>
                    <span>Minha Agenda</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerenciar_acesso_agenda.php?id=<?=$usuario_logado->id ?>">
                    <i class="fa fa-calendar-plus"></i>
                    <span>Visitantes a minha Agenda</span>
                </a>
            </li>
        <?php
    }
    require_once('./actions/ManterAgenda.php');
    $db_agenda = new ManterAgenda();
    if(count($db_agenda->getAgendasQueAcesso($usuario_logado->id)) > 0){
        ?>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="agendas.php">
                <i class="fa fa-calendar"></i>
                <span>Agendas que tenho acesso</span>
            </a>
        </li>
        <?php
    }
    ?>
<!-- Divider -->
<hr class="sidebar-divider" style="color:white;">
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->
