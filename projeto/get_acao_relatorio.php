<?php


$lista_acoes = $manterAcao->listarAcoes($id_etapa);
$lista_notas = $manterAcao->listarNotas($id_etapa);
$total_acoes = count($lista_acoes);
$total_notas = count($lista_notas);
?>

<div class="editar mb-4" style="max-width:100%">
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
                    $btn_check = 'btn-success btn-sm text-white';
                    if ($obj->data_prevista > 0 && $obj->data_check > $data_prevista) {
                        $icon_check = 'fa fa-exclamation-triangle';
                        $btn_check = 'btn-warning btn-sm text-white';                        
                    }
                    if ($executar || $editar) {
                        
                        ?>
                        <button type="button" class="btn btn-sm <?=$btn_check ?>"><i class="<?=$icon_check ?>"></i></button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success btn-sm text-white"><i class="fa fa-check"></i></button>                
                        <?php
                    }
                } else {
                    if ($executar || $editar) {
                        ?>
                        <button type="button" class="btn btn-danger btn-sm text-white" onclick="checkAcao('<?= $obj->id ?>','<?= $data_prevista_txt ?>')"><i class="fa fa-cog"></i></button>                
                        <?php
                       } else {
                        ?>
                        <button type="button" class="btn btn-danger btn-sm text-white"><i class="fa fa-cog"></i></button>                
                        <?php                           
                       } 
                }
                ?>
            </div>
                            </div></div>
                        
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
                    $btn_check = 'btn-success btn-sm text-white';
                    if ($obj->data_prevista > 0 && $obj->data_check > $data_prevista) {
                        $icon_check = 'fa fa-exclamation-triangle';
                        $btn_check = 'btn-warning btn-sm text-white';                        
                    }
                    if ($executar || $editar) {
                        
                        ?>
                        <button type="button" class="btn <?=$btn_check ?>"><i class="<?=$icon_check ?>"></i></button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-success btn-sm text-white"><i class="fa fa-check"></i></button>                
                        <?php
                    }
                } else {
                    if ($executar || $editar) {
                        ?>
                        <button type="button" class="btn btn-danger btn-sm text-white"><i class="fa fa-cog"></i></button>                
                        <?php
                       } else {
                        ?>
                        <button type="button" class="btn btn-danger btn-sm text-white"><i class="fa fa-cog"></i></button>                
                        <?php                           
                       } 
                }
                ?>
            </div>
                            </div></div>
        </div>
    </div>
    <?php
}
echo "</div>
    </div>
  </div>
  </div>";