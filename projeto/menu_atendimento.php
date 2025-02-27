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
    if ($usuario_logado->perfil >= 1) {
        ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            SISTEMAS
        </div>
        <?php
        if ($usuario_logado->perfil <= 2) {
            ?>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="perguntas.php">
                    <i class="fa fa-cogs"></i>
                    <span>Gerenciar Perguntas</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerar_relatorio_perguntas.php">
                    <i class="fa fa-laptop"></i>
                    <span>Relatório das avaliações</span>
                </a>
            </li>
            <!-- Divider -->
             <hr class="sidebar-divider">            
        <?php
        }
        if ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 8) {
            ?>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="servicos.php">
                    <i class="fa fa-cogs"></i>
                    <span>Gerenciar Serviços</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="guiches.php">
                    <i class="fa fa-laptop"></i>
                    <span>Gerenciar Guichês</span>
                </a>
            </li>
              <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerar_relatorio_atendimento.php">
                    <i class="fa fa-laptop"></i>
                    <span>Relatório Atendimento</span>
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

<!-- Nav Item - Pages Collapse Menu -->
<?php
    if ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 8 || $usuario_logado->perfil == 9) {
        ?>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerenciar_fila.php">
                    <i class="fa fa-list-ol"></i>
                    <span>Gerenciar Fila</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerenciar_atendimento.php">
                    <i class="fa fa-laptop"></i>
                    <span>Gerenciar atendimento</span>
                </a>
            </li>
             <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                <a class="nav-link collapsed" target="_black" href="atendimento/painel.php">
                    <i class="fa fa-window-maximize"></i>
                    <span>Painel</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" target="_black" href="consulta_irrf.php">
                    <i class="fa fa-window-maximize"></i>
                    <span>Consultar IRRF Beneficiário</span>
                </a>
            </li>
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