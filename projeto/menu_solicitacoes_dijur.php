<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <?php $parametro = $setor == "dijur" ? "setor=dijur" : "" ?>
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
    <?php
    if ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 9) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            Solicitações <?= $setor == "dijur" ? "DIJUR" : "" ?>
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
            <a class="nav-link collapsed" href="formulario_solicitacoes_dijur.php?<?= $parametro ?>">
                <i class="fa fa-plus-circle"></i>
                <span>Nova Solicitação</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="solicitacoes_dijur.php?s=0&<?= $parametro ?>">
                <i class="fa fa-hourglass-start"></i>
                <span>Solicitacões Em Andamento</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="solicitacoes_dijur.php?s=1&<?= $parametro ?>">
                <i class="fa fa-check-circle"></i>
                <span>Solicitacões Concluídas</span>
            </a>
        </li>
        <?php
    }
    ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="minhas_solicitacoes_dijur.php?<?= $parametro ?>">
            <i class="fa fa-id-card"></i>
            <span>Minhas Solicitações</span>
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