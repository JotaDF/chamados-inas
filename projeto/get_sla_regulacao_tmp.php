<?php


$manterSlaRegulacao = new ManterSlaRegulacao;
$regulacao = $manterSlaRegulacao->listaSlaRegulacaoTemporaria();
foreach ($regulacao as $r) {
    $encaminhamento_manual = ($r->encaminhamento_manual == "1") ? "SIM" :  "NÃO";
    echo "<tr>";
    echo "<td>" . $r->autorizacao . "</td>";
    echo "<td>" . $r->tipo_guia . "</td>";
    echo "<td>" . $r->area . "</td>";
    echo "<td>" . $encaminhamento_manual . "</td>";
    echo "<td>" . $r->data_solicitacao_d . "</td>";
    echo "</tr>";
}
?>
<script>
    function Mudarestado(form_sla_prazo) {
        var elemento = document.getElementById(form_sla_prazo);
        <?php if ($regulacao < 0) { ?>
            // Se for, oculta o elemento
            elemento.style.display = 'none';
        <?php }  ?>
    }
    Mudarestado('form_sla_prazo')
</script>
