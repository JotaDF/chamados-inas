<?php 
require_once('actions/ManterBeneficiario.php');
$manterBeneficiario = new ManterBeneficiario();
$beneficiario = $manterBeneficiario->listar();


foreach($beneficiario as $obj) {

    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' onclick='alterar(\"" . $obj->cpf . "\",\"" . $obj->telefone . "\",\"" . $obj->email . "\",\"" . $obj->endereco . "\")'><i class='fas fa-edit'></i></button>";
    echo "<tr>";
    echo "<td><a href='atendimento_beneficiario.php?cpf=$obj->cpf'>" . $obj->nome.  "</a></td>";
    echo "<td>" . $obj->cpf. "</td>";
    echo "<td>" . $obj->carteirinha. "</td>";
    echo "<td>" . $obj->telefone. "</td>";
    echo "<td>" . $obj->email. "</td>";
    echo "<td align='center'>" . $btn_atualizar. "</td>";
    echo "</tr>";
}