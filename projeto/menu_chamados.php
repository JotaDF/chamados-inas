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
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="index.php">
        <i class="fa fa-home"></i>
        <span>Início</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider">
    <?php
    if ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 9) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
        Chamados UTIC
        </div>
        <?php
        if ($usuario_logado->perfil == 1) {
            ?>        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="categorias.php">
                <i class="fa fa-address-book"></i>
                <span>Categorias</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="gerar_relatorio_chamados.php">
                <i class="fa fa-user"></i>
                <span>Relatório</span>
            </a>
        </li>
        <?php
        }
        ?>        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="chamados.php?s=0">
                <i class="fa fa-address-book"></i>
                <span>Chamados Pendentes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="chamados.php?s=1">
                <i class="fa fa-user"></i>
                <span>Chamados Concluídos</span>
            </a>
        </li>
    <?php
    }
    ?>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="meus_chamados.php">
                <i class="fa fa-users"></i>
                <span>Meus Chamados</span>
            </a>
        </li> 
    <!-- Divider -->
<hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
