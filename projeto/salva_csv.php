<?php
include('./actions/ManterCsv.php');
$mCsv = new ManterCsv();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    $resultado = $mCsv->uploadCsv($_FILES['csv']); // Realiza o upload do arquivo CSV

    if ($resultado['success']) {
        // Chama a função insereCsv e passa o caminho do arquivo
        $mCsv->insereCsv();

        // Verificar se a inserção foi bem-sucedida e definir a mensagem
        //$_SESSION['messagem'] = "Arquivo salvo com sucesso!";
        header('Location: enviar_csv.php?msg=1');
        exit(); // Não esquecer o exit() após redirecionamento
    } else {
        $_SESSION['messagem'] = "Erro: " . $resultado['messagem'];
        header('Location: enviar_csv.php?msg=2');
        exit(); // Não esquecer o exit() após redirecionamento
    }
}
?>
