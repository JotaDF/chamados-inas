<?php


$lista_acoes = $manterAcao->listarAcoes($id_etapa);
$lista_notas = $manterAcao->listarNotas($id_etapa);
$total_acoes = count($lista_acoes);
$total_notas = count($lista_notas);
?>

<div class="editar mb-4" style="max-width:100%">
    <div class="card border-left-secondary shadow pb-0 py-0">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="mb-0">
                        <form class="form-inline" id="form_cadastro" action="save_acao.php" method="post">
                            <input type="hidden" id="id_acao<?= $id_etapa ?>" name="id"/>
                            <input type="hidden" id="tarefa" name="tarefa" value="<?= $id_tarefa ?>"/>
                            <input type="hidden" id="etapa" name="etapa" value="<?= $id_etapa ?>"/>
                            <input type="hidden" id="ordem_acao<?= $id_etapa ?>" name="ordem_acao" value="<?= ($total_acoes + 1) ?>"/>
                            <input type="hidden" id="ordem_nota<?= $id_etapa ?>" name="ordem_nota" value="<?= ($total_notas + 1) ?>"/>                           
                            <div class="row no-gutters align-items-center" style="width:100%">
                                <div class="col mr-2" style="width:80%">
                                    <div class="text-xs font-weight-bold text-uppercase ml-1 mb-2">
                                        <input type="radio" id="tipo_acao_a<?= $id_etapa ?>" name="tipo_acao" value="1" checked>AÇÃO &nbsp;&nbsp;
                                        <input type="radio" id="tipo_acao_p<?= $id_etapa ?>" name="tipo_acao" value="2">NOTA
                                    </div>
                                    <input style="width:100%" type="text" name="acao" class=" mw-100 form-control form-control-sm" id="acao<?= $id_etapa ?>" placeholder="Detalhamento" required>
                                </div>
                                <div class="col mr-2" style="max-width:20%">
                                <div class="text-xs font-weight-bold text-uppercase ml-1 mb-2">DATA LIMITE <small><sup>(Opcional)</sup></small></div>
                                <input  style="width:122px;" type="date" name="data_prevista" class="form-control form-control-sm" id="data_prevista_acao<?= $id_etapa ?>">
                                </div>
                                <div class="float-right align-bottom"> 
                                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>  

<?php
echo '<div class="container" style="max-width:100%">
  <div class="row">
    <div class="col"><b>Ações</b>';
echo '<div class="accordion" style="max-width:100%">';

foreach ($lista_acoes as $obj) {
    $data_prevista = 0;
    ?>
    <div class="card pb-1 border-0">
        <div class="card-header row bg-light" id="acao<?= $obj->ordem ?>">
            <div class="col-sm mb-0 col-xs-4 col-md-4 col-sm-4" style="min-width: 3%; max-width: 3%">
                <?= $obj->ordem ?>
            </div>
            <div class="col mb-2 col-xs-4 col-md-4 col-sm-4" style="min-width:60%; max-width: 100%">
                <?= $obj->acao ?>
            </div>
            <div class="col mb-0  col-xs-4 col-md-4 col-sm-4">
                <div class="row">
                    <div class="col text-center small">
                <?php
                    $data_prevista_txt="";
                    $data_check_txt="";
                    if ($obj->dias > 0 && $obj->data_prevista == 0) {
                        if ($obj->data_check > 0) {
                            //$data_prevista = $obj->data_check;
                            $data_check_txt= ' (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                            //$data_prevista_txt=' <del>(' .date('d/m/Y',$obj->data_prevista).')</del>';
                        }
                          $data_prevista = $manterAcao->somar_dias_uteis(date('d/m/Y',$data_base), $obj->dias);
                          $data_prevista_txt=' (' .date('d/m/Y',$data_prevista).')<i class="text-primary far fa-clock"></i>';
                        
                        //echo 'DATABASE:'.date('d/m/Y',$data_base);
                        
                        echo $obj->dias . ' dia(s)<br/>' . $data_prevista_txt . $data_check_txt;
                        $data_base = $data_prevista;
                        $data_prevista_txt = date('Y-m-d', $data_prevista);
                        if ($obj->data_prevista > 0) {
                            $data_prevista_txt = date('Y-m-d', $obj->data_prevista);
                        }
                        
                        
                    } else if ($obj->data_prevista != 0){
                        $data_prevista_txt = date('Y-m-d', $obj->data_prevista);
                        echo ' (' .date('d/m/Y',$obj->data_prevista).')<i class="text-primary far fa-clock"></i>';
                        $data_prevista = $obj->data_prevista;
                    } else {
                        echo '-';
                    }
                    if ($obj->data_check > 0) {
                        echo '<br/> (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                    }
                    ?>
            </div>            
            <div class="col text-right col-xs-4 col-md-4 col-sm-4" id="btn_<?= $obj->id ?>">
                <?php
                    //echo 'DATA: '.$obj->data_check . '#' . $obj->data_prevista;

                if ($obj->data_check > 0) {
                    $data_check_txt= ' (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                    $icon_check = 'fa fa-check';
                    $btn_check = 'btn-success  text-white';
                    if ($obj->data_prevista > 0 && $obj->data_check > $data_prevista) {
                        $icon_check = 'fa fa-exclamation-triangle';
                        $btn_check = 'btn-warning text-white';                        
                    }
                    if ($executar || $editar) {
                        
                        ?>
                        <button type="button" class="btn <?=$btn_check ?>" onclick="retiraCheckAcao('<?= $obj->id ?>','<?= $data_prevista_txt ?>')"><i class="<?=$icon_check ?>"></i></button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success text-white"><i class="fa fa-check"></i></button>                
                        <?php
                    }
                } else {
                    if ($executar || $editar) {
                        ?>
                        <button type="button" class="btn btn-danger text-white" onclick="checkAcao('<?= $obj->id ?>','<?= $data_prevista_txt ?>')"><i class="fa fa-cog"></i></button>                
                        <?php
                       } else {
                        ?>
                        <button type="button" class="btn btn-danger text-white"><i class="fa fa-cog"></i></button>                
                        <?php                           
                       } 
                }
                ?>
            </div>
                            </div></div>
            <div class="editar col float-right" style="max-width:30%">
                <?php
                if($obj->ordem >= 1 && $obj->ordem < $total_acoes ){
                ?>
                <a class="text-primary" href="muda_ordem_acao.php?op=d&id=<?= $obj->id ?>&tipo=<?= $obj->tipo ?>&etapa=<?= $id_etapa ?>&ordem=<?= $obj->ordem ?>&tarefa=<?= $id_tarefa ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>&nbsp;
                <?php
                } 
                if($obj->ordem > 1 && $obj->ordem <= $total_acoes ){
                ?>
                <a class="text-primary" href="muda_ordem_acao.php?op=s&id=<?= $obj->id ?>&tipo=<?= $obj->tipo ?>&etapa=<?= $id_etapa ?>&ordem=<?= $obj->ordem ?>&tarefa=<?= $id_tarefa ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                <?php
                }
                ?>
                &nbsp;&nbsp;&nbsp;
                <span class="text-primary" onclick="alterarAcao('<?= $obj->id ?>', '<?= $obj->tipo ?>', '<?= $obj->acao ?>', '<?= $obj->ordem ?>','<?= $obj->dias ?>','<?= $obj->data_prevista>0 ? date('Y-m-d',$obj->data_prevista) : '' ?>', '<?= $id_etapa ?>')"><i class="fas fa-edit"></i></span>
                &nbsp;
                <span class="text-primary" onclick="excluirAcao('<?= $obj->id ?>', '<?= $obj->acao ?>')"><i class="far fa-trash-alt"></i></span>
            </div>
        </div>
    </div>
    <?php
}
echo "</div>";
echo "</div>
    <div class='col'><b>Notas</b>";
echo '<div class="accordion" style="max-width:100%">';
foreach ($lista_notas as $obj) {
    $data_prevista = 0;
    ?>
    <div class="card pb-1 border-0">
        <div class="card-header alert-warning row" id="acao<?= $obj->ordem ?>">
            <div class="col-sm mb-0 col-xs-4 col-md-4 col-sm-4" style="min-width: 3%; max-width: 3%">
                <?= $obj->ordem ?>
            </div>
            <div class="col mb-2 col-xs-4 col-md-4 col-sm-4" style="min-width:60%; max-width: 100%">
                <?= $obj->acao ?>
            </div>
            <div class="col mb-0  col-xs-4 col-md-4 col-sm-4">
                <div class="row">
                    <div class="col text-center small">
                <?php
                    $data_prevista_txt="";
                    $data_check_txt="";
                    if ($obj->dias > 0 && $obj->data_prevista == 0) {
                        if ($obj->data_check > 0) {
                            //$data_prevista = $obj->data_check;
                            $data_check_txt= ' (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                            //$data_prevista_txt=' <del>(' .date('d/m/Y',$obj->data_prevista).')</del>';
                        }
                          $data_prevista = $manterAcao->somar_dias_uteis(date('d/m/Y',$data_base), $obj->dias);
                          $data_prevista_txt=' (' .date('d/m/Y',$data_prevista).')<i class="text-primary far fa-clock"></i>';
                        
                        //echo 'DATABASE:'.date('d/m/Y',$data_base);
                        
                        echo $obj->dias . ' dia(s)<br/>' . $data_prevista_txt . $data_check_txt;
                        $data_base = $data_prevista;
                        $data_prevista_txt = date('Y-m-d', $data_prevista);
                        if ($obj->data_prevista > 0) {
                            $data_prevista_txt = date('Y-m-d', $obj->data_prevista);
                        }
                        
                        
                    } else if ($obj->data_prevista != 0){
                        $data_prevista_txt = date('Y-m-d', $obj->data_prevista);
                        echo ' (' .date('d/m/Y',$obj->data_prevista).')<i class="text-primary far fa-clock"></i>';
                        $data_prevista = $obj->data_prevista;
                    } else {
                        echo '-';
                    }
                    if ($obj->data_check > 0) {
                        echo '<br/> (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                    }
                    
                    ?>
            </div>            
            <div class="col text-right col-xs-4 col-md-4 col-sm-4" id="btn_<?= $obj->id ?>">
                <?php
                    //echo 'DATA: '.$obj->data_check . '#' . $obj->data_prevista;

                if ($obj->data_check > 0) {
                    $data_check_txt= ' (' .date('d/m/Y',$obj->data_check).')<i class="text-success fas fa-check"></i>';
                    $icon_check = 'fa fa-check';
                    $btn_check = 'btn-success  text-white';
                    if ($obj->data_prevista > 0 && $obj->data_check > $data_prevista) {
                        $icon_check = 'fa fa-exclamation-triangle';
                        $btn_check = 'btn-warning text-white';                        
                    }
                    if ($executar || $editar) {
                        
                        ?>
                        <button type="button" class="btn <?=$btn_check ?>" onclick="retiraCheckAcao('<?= $obj->id ?>','<?= $data_prevista_txt ?>')"><i class="<?=$icon_check ?>"></i></button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success text-white"><i class="fa fa-check"></i></button>                
                        <?php
                    }
                } else {
                    if ($executar || $editar) {
                        ?>
                        <button type="button" class="btn btn-danger text-white" onclick="checkAcao('<?= $obj->id ?>','<?= $data_prevista_txt ?>')"><i class="fa fa-cog"></i></button>                
                        <?php
                       } else {
                        ?>
                        <button type="button" class="btn btn-danger text-white"><i class="fa fa-cog"></i></button>                
                        <?php                           
                       } 
                }
                ?>
            </div>
                            </div></div>
            <div class="editar col float-right" style="max-width:30%">
                <?php
                if($obj->ordem >= 1 && $obj->ordem < $total_notas ){
                ?>
                <a class="text-primary" href="muda_ordem_acao.php?op=d&id=<?= $obj->id ?>&tipo=<?= $obj->tipo ?>&etapa=<?= $id_etapa ?>&ordem=<?= $obj->ordem ?>&tarefa=<?= $id_tarefa ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>&nbsp;
                <?php
                } 
                if($obj->ordem > 1 && $obj->ordem <= $total_notas ){
                ?>
                <a class="text-primary" href="muda_ordem_acao.php?op=s&id=<?= $obj->id ?>&tipo=<?= $obj->tipo ?>&etapa=<?= $id_etapa ?>&ordem=<?= $obj->ordem ?>&tarefa=<?= $id_tarefa ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                <?php
                }
                ?>
                &nbsp;&nbsp;&nbsp;
                <span class="text-primary" onclick="alterarAcao('<?= $obj->id ?>', '<?= $obj->tipo ?>', '<?= $obj->acao ?>', '<?= $obj->ordem ?>','<?= $obj->dias ?>','<?= $obj->data_prevista>0 ? date('Y-m-d',$obj->data_prevista) : '' ?>', '<?= $id_etapa ?>')"><i class="fas fa-edit"></i></span>
                &nbsp;
                <span class="text-primary" onclick="excluirAcao('<?= $obj->id ?>', '<?= $obj->acao ?>')"><i class="far fa-trash-alt"></i></span>
            </div>
        </div>
    </div>
    <?php
}
echo "</div>
    </div>
  </div>
  </div>";
