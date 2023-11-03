<?php

require_once('./actions/ManterEquipe.php');
require_once('./dto/Usuario.php');

$mEquipe = new ManterEquipe();

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
                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600"><?=$usuario_logado->nome ?>( <?=$mEquipe->getSetorPorId($usuario_logado->setor)->sigla ?> )</span>
                                    <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                                </a>
                      
                                <!-- Dropdown - User Information --> 
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="altera_senha_usuario.php">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Alterar senha
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