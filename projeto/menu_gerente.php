<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <br />
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon mx-1"><img src="img/inas.svg" width="100%" /></div>
    </a>
    <br />
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
    <!-- Heading -->
    <div class="sidebar-heading">
        Gestão de Tarefas
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index_gerente.php">
            <i class="fa fa-id-card"></i>
            <span>Home Gerente</span>
        </a>
    </li>

    <?php
    if ($usuario_logado->perfil <= 2) {

        if ($usuario_logado->perfil == 1) {
            ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="tarefas.php">
                    <i class="fa fa-tasks"></i>
                    <span>Tarefas</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerar_relatorio.php">
                    <i class="fa fa-file"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tipo_tarefa.php">
                    <i class="fa fa-tasks"></i>
                    <span>Tipo de Tarefas</span>
                </a>
            </li>
            <?php
        }
        ?>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="equipes.php">
                <i class="fa fa-users"></i>
                <span>Equipes</span>
            </a>
        </li>

        <?php
    }
    ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="tarefas.php?filtro=equipe">
            <i class="fa fa-tasks"></i>
            <span>Tarefas por Equipe</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="tarefas.php?filtro=criador">
            <i class="fa fa-tasks"></i>
            <span>Minhas Tarefas</span>
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