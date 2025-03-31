<?php


$manterSlaRegulacao = new ManterSlaRegulacao;
$regulacao = $manterSlaRegulacao->listaSlaRegulacaoTemporaria();

foreach ($regulacao as $r) {
    echo "<tr>";
    echo "<td>" . $r->autorizacao . "</td>";
    echo "<td>" . $r->tipo_guia . "</td>";
    echo "<td>" . $r->area . "</td>";
    echo "<td>" . $r->encaminhamento_manual . "</td>";
    echo "<td>" . $r->data_solicitacao_d . "</td>";
    echo "</tr>";
}
?>
<script>
    function Mudarestado(form_sla_prazo) {
        // Captura o elemento pelo ID
        var elemento = document.getElementById(form_sla_prazo);

        // Verifica se a variável PHP $regulacao é menor que 0
        <?php if ($regulacao < 0) { ?>
            // Se for, oculta o elemento
            elemento.style.display = 'none';
        <?php }  ?>
    }
    Mudarestado('form_sla_prazo')
</script>
