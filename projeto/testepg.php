<?php 

include_once('actions/ManterFilaPericia.php');
include_once('actions/ManterBeneficiario.php');
// Conexão
//$db1 = new ModelPg('df_regulacao_consulta_api_live');
//$db2 = new ModelPg('df_contrato_api_live');
//$db3 = new ModelPg('df_pessoa_api_live');
$manterFilaPericia = new ManterFilaPericia('df_regulacao_consulta_api_live');
$manterBeneficiario = new ManterBeneficiario('df_contrato_api_live');
// Consultas
$lista = $manterFilaPericia->listar();
        
foreach ($lista as $obj) {
    echo $obj['id']."<br/>";
    echo $obj['autorizacao']."<br/>";
    echo $obj['data_solicitacao']."<br/>";
    echo $obj['id_beneficiario']."<br/>";
    $rs_beneficiario = $manterBeneficiario->listar($obj['id_beneficiario']);
    print_r($rs_beneficiario);
    echo $obj['justificativa']."<br/>";
    echo $obj['situacao']."<br/>";
    echo "<hr/>";
}
//print_r($rs1);
//echo "<hr><br/>";

//$rs2 = $db2->db->Execute("SELECT * FROM segurado WHERE uuid = '85b4ad5d-e7fd-4d5d-9c57-40ec929bde81'");
//print_r($rs2);
//echo "<hr><br/>";
//$rs3 = $db3->db->Execute("SELECT * FROM pessoa WHERE cpf_cnpj ='868.303.331-72'");
//print_r($rs3);
//echo "<hr><br/>";