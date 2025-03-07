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
    if ($usuario_logado->perfil <= 2) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
        Gestão do Sistema
        </div>
        <?php
        if ($usuario_logado->perfil == 1) {
            ?>        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="setores.php">
                <i class="fa fa-address-book"></i>
                <span>Setores</span>
            </a>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="perfis.php">
                <i class="fa fa-users"></i>
                <span>Perfis</span>
            </a>
        </li> 
                <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="modulos.php">
                <i class="fa fa-window-restore"></i>
                <span>Módulos</span>
            </a>
        </li> 
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="enquetes.php">
                <i class="fa fa-list-ul"></i>
                <span>Enquetes</span>
            </a>
        </li> 
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
            <a class="nav-link collapsed" href="eventos.php">
                <i class="fa fa-list-ul"></i>
                <span>Eventos</span>
            </a>
        </li> 
            <?php
        }
    }
    ?>
    <!-- Divider -->
<hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
