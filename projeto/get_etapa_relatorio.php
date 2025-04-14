<?php
include_once('actions/ManterEtapa.php');

$manterEtapa = new ManterEtapa();

$lista = $manterEtapa->listar($id_tarefa);
$total_etapas = count($lista);
?>
<?php
echo '<div class="accordion border-bottom border-info" style="max-width:100%">';
foreach ($lista as $obj) {
    $id_etapa = $obj->id;
    if ($obj->data_base > 0) {
        $data_base =$obj->data_base;
    }
    
    ?>
    <div class="card border-secondary">
        <div class="card-header row bg-gradient-secondary" style="height: 2.5rem;" id="etapa<?= $obj->ordem ?>">
            <div class="col mb-0  align-top" style="max-width:100%">
                <span class="align-middle btn btn-link" onclick="mostrarEtapa(<?= $obj->id ?>,<?= $obj->mostrar ?>)" data-toggle="collapse" data-target="#collapse<?= $obj->ordem ?>" aria-expanded="true" aria-controls="collapse<?= $obj->ordem ?>">
                    <i class="fas fa-random text-white"></i>
                </span>               
            </div>
            <div class="col mb-0 align-top" style="max-width:55%">
                <span class="text-white"><b><?= $obj->nome ?></b></span>
            </div>
            <div class="col mb-0 align-top" style="max-width:35%">
                <span class="text-white"><b><?= ($obj->data_base > 0 ? date('d/m/Y',$obj->data_base) : ' - ') ?></b></span>
            </div>
        </div>
        <?php
        $txt_mostrar = 'show';
        if($obj->mostrar == 0) {
            $txt_mostrar = 'hide';
        }
        ?>
        <div id="collapse<?= $obj->ordem ?>" class="collapse <?=$txt_mostrar ?>" aria-labelledby="etapa<?= $obj->ordem ?>">
            <div class="card-body border-info">
                <!-- ETAPAS -->
                <?php include './get_acao_relatorio.php'; ?>
                <!-- FIM ETAPAS -->
            </div>
        </div>
    </div>
    <?php
}
echo "</div>";