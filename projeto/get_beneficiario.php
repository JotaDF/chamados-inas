<?php 
require_once('actions/ManterBeneficiario.php');
$manterBeneficiario = new ManterBeneficiario();
$beneficiario = $manterBeneficiario->listar();


foreach($beneficiario as $obj) {

    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' onclick='alterar(\"" . $obj->nome . "\",\"" . $obj->cpf . "\",\"" . $obj->carteirinha . "\",\"" . $obj->telefone . "\",\"" . $obj->email . "\")'><i class='fas fa-edit'></i></button>";
    $btn_atendimentos = "&nbsp<a href='atendimento_beneficiario.php?cpf=$obj->cpf' class='btn btn-warning btn-sm' title='Histórico'><i class='fa fa-user-md'></i></a>";
    
    echo "<tr>";
    echo "<td>" . $obj->nome.  "</a></td>";
    echo "<td>" . $obj->cpf. "</td>";
    echo "<td>" . $obj->carteirinha. "</td>";
    echo "<td>" . $obj->telefone. "</td>";
    echo "<td>" . $obj->email. "</td>";
    echo "<td align='center'>" . $btn_atualizar . $btn_atendimentos . "</td>";
    echo "</tr>";

}