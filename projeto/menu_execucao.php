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
            GERÊNCIA
        </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="tipos_prestador.php">
                    <i class="fa fa-list"></i>
                    <span>Tipos Prestador</span>
                </a>
            </li>
              <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="prestadores.php">
                    <i class="fa fa-th-large"></i>
                    <span>Prestadores</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_execucao_pendentes.php">
                    <i class="fa fa-check-square"></i>
                    <span>Execução Pendentes</span>
                </a>
            </li> 
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_atestos_pendentes.php">
                    <i class="fa fa-check-square"></i>
                    <span>Atestos Pendentes</span>
                </a>
            </li>                         
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_pagamentos_pendentes.php">
                    <i class="fa fa-credit-card"></i>
                    <span>Pagamentos Pendentes</span>
                </a>
            </li>
           
        <?php
    }

    if ($usuario_logado->perfil >= 1) {
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
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_minha_execucao_pendentes.php">
                    <i class="fa fa-check-square"></i>
                    <span>Execução Pendentes</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="painel_meus_pagamentos_pendentes.php">
                    <i class="fa fa-check-square"></i>
                    <span>Pagamentos Pendentes</span>
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