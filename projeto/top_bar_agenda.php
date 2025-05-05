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
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item no-arrow">
                                <a class="nav-link" href="index.php" role="button">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600" style="font-size: small;"><?=$usuario_logado->nome ?>( <?=$mSetor->getSetorPorId($usuario_logado->setor)->sigla ?> )</span>
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
                            </li>
                        </ul>
                        
                    </nav>
                    <!-- End of Topbar -->
                    
