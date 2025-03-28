<?php 
require_once('./actions/ManterSlaRegulacao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['envio'])) {
        header('Location: painel_regulacao_prazo.php');
        exit(); 
    } else if (isset($_POST['cancelar'])) {
        $manterSlaRegulacao = new ManterSlaRegulacao();
        $manterSlaRegulacao->limpaSlaTemporaria();
        header('Location: enviar_arquivo_sla_regulacao.php');
        exit(); // Garantir que o script pare após o redirecionamento
    }
}




