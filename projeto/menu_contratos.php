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
            CONTRATOS
        </div>

              <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="contratos.php">
                    <i class="fa fa-th-large"></i>
                    <span>Prestadores</span>
                </a>
            </li>
    <?php
    }

    if ($usuario_logado->perfil == 1) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            EXECUÇÃO
        </div>
            <?php
        if ($usuario_logado->perfil >= 2) {
            ?>
              <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="meus_prestadores.php">
                    <i class="fa fa-th-large"></i>
                    <span>Meus Prestadores</span>
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
