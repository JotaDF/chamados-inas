<?php
	include_once('actions/ManterInteracao.php'); 
    include_once('actions/ManterUsuario.php'); 
	
	$manterInteracao = new ManterInteracao();
    $manterUsuario = new ManterUsuario();
	
	$lista = $manterInteracao->listar($id_chamado);
    $titulo = true;
    foreach ($lista as $obj) {
        $class_color = "border-left-primary";
        if($obj->usuario != $chamado->usuario){
            $class_color = "border-left-warning ml-4";
        }
        if ($titulo) {
        ?>
            <div class="col-xl-3 col-md-6 mb-2" style="max-width: 750px;" >
                <span class="h6">INTERAÇÕES</span>
            </div>
            <?php
            $titulo = false;
        }
        ?>
        
        <div class="col-xl-3 col-md-6 mb-2" style="max-width: 750px;" >
            <div class="card <?=$class_color ?> shadow py-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <span class="text-xs font-weight-bold text-uppercase mb-1" id="titulo_interacao"><?=$manterUsuario->getUsuarioPorId($obj->usuario)->nome ?></span><br/>
                        <span><?=$obj->texto ?><br/><code class="highlighter-rouge"><i><?=date('d/m/Y H:i', strtotime($obj->data)) ?></i></code>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

