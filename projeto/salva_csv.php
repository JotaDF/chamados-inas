<?php
include('./actions/ManterSlaRegulacao.php');
$mCsv = new ManterSlaRegulacao();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    $resultado = $mCsv->uploadCsv($_FILES['csv']); // Realiza o upload do arquivo CSV

    if ($resultado['success']) {
    
        $mCsv->insereCsv();
        header('Location: sla_regulacao_temporaria.php');
        exit(); // Não esquecer o exit() após redirecionamento
    } else {
        $_SESSION['messagem'] = "Erro: " . $resultado['messagem'];
        header('Location: enviar_arquivo_sla_regulacao.php?msg=2');
    }
}