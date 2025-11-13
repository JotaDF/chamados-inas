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
$manterContatoBeneficiario = new ManterContatoBeneficiarioPg('df_pessoa_api_live');
// Consultas
$lista = $manterFilaPericia->listar();
$id_beneficiario = '';
foreach ($lista as $obj) {
    if ($id_beneficiario != $obj['id_beneficiario']) {
        echo "<hr/>";
        $id_beneficiario = $obj['id_beneficiario'];
        $rs_beneficiario = $manterBeneficiario->getBeneficiarioPorId($obj['id_beneficiario']);
        //print_r($rs_beneficiario);
        foreach ($rs_beneficiario as $obj2) {
            echo "Carteirinha: ".$obj2['numero_cartao']."<br/>";
            echo "CPF: ".$obj2['cpf_cnpj']."<br/>";
            echo "Nome: ".$obj2['nome']."<br/>";
            echo "Data Nascimento: ".$obj2['data_nascimento']."<br/>";
            $rs_contatos = $manterContatoBeneficiario->getContadosPorCpf($obj2['cpf_cnpj']);
            //print_r($rs_contatos);
            foreach ($rs_contatos as $obj3) {
                echo  $obj3['tipo'] . ": " .$obj3['valor']."<br/>";
            }
            echo "<br/>";
            echo "ID: ".$obj['id']."<br/>";
            echo "Autorização: ".$obj['autorizacao']."<br/>";
            echo "Solicitação: ".$obj['data_solicitacao']."<br/>";
        }
        
    }
    echo "Código: ".$obj['codigo']."<br/>";
    echo "Descrição: ".$obj['descricao']."<br/>";
    //echo "Situação: ".$obj['situacao']."<br/>";
    //echo "id_beneficiario: ".$obj['id_beneficiario']."<br/>";
}
//print_r($rs1);
//echo "<hr><br/>";

//$rs2 = $db2->db->Execute("SELECT * FROM segurado WHERE uuid = '85b4ad5d-e7fd-4d5d-9c57-40ec929bde81'");
//print_r($rs2);
//echo "<hr><br/>";
//$rs3 = $db3->db->Execute("SELECT * FROM pessoa WHERE cpf_cnpj ='868.303.331-72'");
//print_r($rs3);
//echo "<hr><br/>";