<?php 

include_once('actions/ManterFilaPericiaPg.php');
include_once('actions/ManterBeneficiarioPg.php');
include_once('actions/ManterContatoBeneficiarioPg.php');
// Conexão
//$db1 = new ModelPg('df_regulacao_consulta_api_live');
//$db2 = new ModelPg('df_contrato_api_live');
//$db3 = new ModelPg('df_pessoa_api_live');
$manterFilaPericia = new ManterFilaPericiaPg('df_regulacao_consulta_api_live');
$manterBeneficiario = new ManterBeneficiarioPg('df_contrato_api_live');
$manterContatoBeneficiario = new ManterBeneficiarioPg('df_pessoa_api_live');
// Consultas
$lista = $manterFilaPericia->listar();
        
foreach ($lista as $obj) {
    echo "ID: ".$obj['id']."<br/>";
    echo "Autorização: ".$obj['autorizacao']."<br/>";
    echo "Solicitação: ".$obj['data_solicitacao']."<br/>";
    echo "Código: ".$obj['codigo']."<br/>";
    echo "Descrição: ".$obj['descricao']."<br/>";
    echo "Situação: ".$obj['situacao']."<br/>";
    $rs_beneficiario = $manterBeneficiario->getBeneficiarioPorId($obj['id_beneficiario']);
    //print_r($rs_beneficiario);
    foreach ($rs_beneficiario as $obj2) {
        echo "Carteirinha: ".$obj2['numero_cartao ']."<br/>";
        echo "Nome: ".$obj2['nome']."<br/>";
        echo "Data Nascimento: ".$obj2['data_nascimento']."<br/>";
        $rs_contatos = $manterContatoBeneficiario->getContadosPorIdPessoa($obj2['id']);
        print_r($rs_contatos);
    }

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