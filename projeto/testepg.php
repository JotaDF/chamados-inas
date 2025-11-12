<?php 

include_once('actions/ModelPg.php');
// Conexão
$db1 = new ModelPg('df_regulacao_consulta_api_live');
$db2 = new ModelPg('df_contrato_api_live');
$db3 = new ModelPg('df_pessoa_api_live');

// Consultas
$rs1 = $db1->db->Execute('SELECT * FROM guia WHERE fila_id =18 or id_fila =18');
print_r($rs1);
echo "<hr><br/>";
$rs2 = $db2->db->Execute("SELECT * FROM segurado WHERE uuid = '85b4ad5d-e7fd-4d5d-9c57-40ec929bde81'");
print_r($rs2);
echo "<hr><br/>";
$rs3 = $db3->db->Execute("SELECT * FROM pessoa WHERE cpf_cnpj ='868.303.331-72'");
print_r($rs3);
echo "<hr><br/>";