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
    <?php
    if ($usuario_logado->perfil >= 1) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            AGENDA
        </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="agenda.php?id=<?=$usuario_logado->id ?>">
                    <i class="fa fa-id-badge"></i>
                    <span>Minha Agenda</span>
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