<?php 
include ('actions/ManterAtendimentoPericia.php');

header('Content-Type: application/json');

$manterAtendimentoPericia = new ManterAtendimentoPericia();

$resultado = $manterAtendimentoPericia->desmarcaAgendamento($_POST['id_atendimento']);

if ($resultado) {
    echo json_encode([
        "status" => "success",
        "msg" => "Agendamento desmarcado com sucesso"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "msg" => "Erro ao desmarcar o agendamento"
    ]);
}
