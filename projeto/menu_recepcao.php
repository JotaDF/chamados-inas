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
            VISITANTES
        </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="recepcoes.php">
                    <i class="fa fa-laptop"></i>
                    <span>Gerenciar Visitas</span>
                </a>
            </li>
            <?php
        if ($usuario_logado->perfil >= 1) {
            ?>
              <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerar_relatorio_visitas.php">
                    <i class="fa fa-laptop"></i>
                    <span>Relatório Visitas</span>
                </a>
            </li>
            <?php
        }
        ?>

        <?php
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