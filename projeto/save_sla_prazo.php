<?php
include_once('actions/ManterSlaPrazo.php');
include_once('dto/SlaPrazo.php');

$sla_prazo = new ManterSlaPrazo();
$sp = new SlaPrazo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $id = $_POST['id'] ?? null;  // Captura o id, pode ser vazio se for um novo cadastro
    $tipo_guia = $_POST['tipo_guia'];
    $fila = $_POST['fila'];
    $prazo = (int) $_POST['prazo'];
    $prazo_segundos = $prazo * 3600;  // Convertendo prazo para segundos

    // Array de erros de validação
    $erros = [];

    // Validação dos campos
    if (empty($tipo_guia)) {
        $erros[] = "Tipo de Guia não pode ser vazio ou zero.";
    }

    if (empty($fila)) {
        $erros[] = "Fila está vazia";
    }

    if (empty($prazo)) {
        $erros[] = "Prazo está vazio";
    }

    // Se houver erros, exibe-os
    if (!empty($erros)) {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
    } else {
        // Preenche o objeto SlaPrazo com os dados válidos
        $sp->tipo_guia = $tipo_guia;
        $sp->fila = $fila;
        $sp->prazo_dias = $prazo;
        $sp->prazo_segundos = $prazo_segundos;

        // Verifica se é uma operação de cadastro ou alteração
        if (empty($id)) {
            // Cadastro - Chama o método de salvar
            $resultado = $sla_prazo->salvar($sp);
            if ($resultado) {
                echo "<p style='color: green;'>Cadastro realizado com sucesso!</p>";
                header('Location: gerenciar_sla_prazo.php');
                exit();
            } else {
                echo "<p style='color: red;'>Erro ao salvar os dados durante o cadastro.</p>";
            }
        } else {
            // Alteração - Chama o método de alterar
            $sp->id = $id;  // Atribui o id do SLA para alterar
            $resultado = $sla_prazo->salvar($sp);
            if ($resultado) {
                echo "<p style='color: green;'>Alteração realizada com sucesso!</p>";
                header('Location: gerenciar_sla_prazo.php');
                exit();
            } else {
                echo "<p style='color: red;'>Erro ao salvar os dados durante a alteração.</p>";
            }
        }
    }
}
?>
