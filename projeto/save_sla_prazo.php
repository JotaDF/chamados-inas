<?php
include_once('actions/ManterSlaPrazo.php');
include_once('dto/SlaPrazo.php');

$sla_prazo = new ManterSlaPrazo();
$sp = new SlaPrazo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $tipo_guia = $_POST['tipo_guia'];
    $fila = $_POST['fila'];
    $prazo = (int) $_POST['prazo'];
    $prazo_segundos = $prazo * 3600;  // Convertendo prazo para segundos

   
    $erros = [];

    if (empty($tipo_guia)) {
        $erros[] = "Tipo de Guia não pode ser vazio ou zero.";
    }

    if (empty($fila)) {
        $erros[] = "Fila está vazia";
    }

    if (empty($prazo)) {
        $erros[] = "Prazo está vazio";
    }

    
    if (!empty($erros)) {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
    } else {
       
        $sp->tipo_guia = $tipo_guia;
        $sp->fila = $fila;
        $sp->prazo_dias = $prazo;
        $sp->prazo_segundos = $prazo_segundos;
        if (empty($id)) {
            $resultado = $sla_prazo->salvar($sp);
            if ($resultado) {
                echo "<p style='color: green;'>Cadastro realizado com sucesso!</p>";
                header('Location: prazos.php');
                exit();
            } else {
                echo "<p style='color: red;'>Erro ao salvar os dados durante o cadastro.</p>";
            }
        } else {
            $sp->id = $id; 
            $resultado = $sla_prazo->salvar($sp);
            if ($resultado) {
                echo "<p style='color: green;'>Alteração realizada com sucesso!</p>";
                header('Location: prazos.php');
                exit();
            } else {
                echo "<p style='color: red;'>Erro ao salvar os dados durante a alteração.</p>";
            }
        }
    }
}
?>
