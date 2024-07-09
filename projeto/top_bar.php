<?php

require_once('./actions/ManterSetor.php');
require_once('./dto/Usuario.php');

$mSetor = new ManterSetor();

?>        
        <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Search -->
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </form>
                        
                        <!-- Topbar Navbar-->
                        <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                require_once('./actions/ManterNotificacao.php');
                                require_once('./dto/Notificacao.php');
                                    
                                $db_notificacao = new ManterNotificacao();
                                $total_notificacoes = $db_notificacao->getTotalNotificacaoUsuario($usuario_logado->id);
                                $total = "";
                                if($total_notificacoes > 0){
                                    $total = $total_notificacoes;
                                }
                                ?>
                                <span class="badge badge-danger badge-counter" id="total_not"><?=$total ?></span>
                            </a>

                            <!-- Dropdown - Alerts -->
                            <div  class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <span id="notifica"><?php include './get_notificacao.php';  ?></spam>
                                <a class="dropdown-item text-center small text-gray-500" href="gerenciar_notificacoes.php">Ver todas</a>
                            </div>
                        </li>                                                                   
                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600"><?=$usuario_logado->nome ?>( <?=$mSetor->getSetorPorId($usuario_logado->setor)->sigla ?> )</span>
                                    <?php
                                    $dir = './ft/';
                                    $imagem = '<i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>';
                                    $style = 'style=" border-radius: 50%; background-color: #ddd; height: 60px; object-fit: cover; width: 60px;"';
                                    if (file_exists($dir .$usuario_logado->id . '.jpg' )) {
                                        $foto = $dir . $usuario_logado->id . '.jpg';
                                        $imagem = '<img '.$style.' src="'.$foto.'" alt="Foto perfil" />';
                                    } else if (file_exists($dir .$usuario_logado->id . '.jpeg' )) {
                                        $foto = $dir . $usuario_logado->id . '.jpeg';
                                        $imagem = '<img '.$style.' src="'.$foto.'" alt="Foto perfil" />';
                                    } 
                                    echo $imagem;
                                    ?>        
                                </a>
                      
                                <!-- Dropdown - User Information --> 
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="perfil_usuario.php?id=<?=$usuario_logado->id ?>">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Meu perfil
                                    </a>
                                    <a class="dropdown-item" href="alterar_foto.php">
                                        <i class="fas fa-id-badge fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Alterar Foto
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="consultar_usuario.php">
                                        <i class="fa fa-search fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Buscar Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="sair.php" >
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Sair
                                    </a>
                                </div>
                            </li>

                        </ul>
                        
                    </nav>
                    <!-- End of Topbar -->
                    