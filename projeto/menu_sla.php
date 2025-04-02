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
            Gerenciar SLA Regulação
        </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_regulacao_prazo.php">
                    <i class="fa fa-signal"></i>
                    <span>Painel</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="enviar_arquivo_sla_regulacao.php">
                    <i class="fa fa-folder-open"></i>
                    <span>Importar arquivo SLA</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="prazos.php">
                    <i class="fa fa-hourglass-half"></i>
                    <span>Gerenciar Prazos SLA</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="sla_regulacao_temporaria.php">
                <i class="fa fa-clock"></i>
                    <span>Regulação Temporaria</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="gerar_relatorio_sla.php">
                <i class="fa fa-laptop"></i>
                    <span>Gerar Relatório SLA</span>
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