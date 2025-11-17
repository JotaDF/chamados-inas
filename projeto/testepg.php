<?php 

include_once('actions/ManterFilaPericiaPg.php');
include_once('actions/ManterBeneficiarioPg.php');
include_once('actions/ManterContatoBeneficiarioPg.php');

include_once('actions/ManterBeneficiario.php');
include_once('actions/ManterFilaPericiaEco.php');
include_once('dto/Beneficiario.php');
include_once('dto/FilaPericiaEco.php');

// Conexão
$manterFilaPericia = new ManterFilaPericiaPg('df_regulacao_consulta_api_live');
$manterBeneficiarioPg = new ManterBeneficiarioPg('df_contrato_api_live');
$manterContatoBeneficiario = new ManterContatoBeneficiarioPg('df_pessoa_api_live');

$manterBeneficiario = new ManterBeneficiario();
$manterFilaPericiaEco = new ManterFilaPericiaEco();
// Consultas
$lista = $manterFilaPericia->listar();
$id_beneficiario = '';
foreach ($lista as $obj) {
    if ($id_beneficiario != $obj['id_beneficiario']) {
        echo "<br/><br/><hr/>";
        $id_beneficiario = $obj['id_beneficiario'];
        $obj2 = $manterBeneficiarioPg->getBeneficiarioPorId($obj['id_beneficiario']);
        //print_r($rs_beneficiario);
        if (!$manterBeneficiario->existeCpf($obj2['cpf_cnpj'])) {
            $b = new Beneficiario();
            $b->cpf = $obj2['cpf_cnpj'];
            $b->nome = $obj2['nome'];
            $b->carteirinha = $obj2['numero_cartao'];
            $b->telefone = '';
            $b->email = '';

            $rs_contatos = $manterContatoBeneficiario->getContadosPorCpf($obj2['cpf_cnpj']);
            foreach ($rs_contatos as $obj3) {
                if ($obj3['tipo'] == 'TELEFONE') {
                    $b->telefone .= $obj3['valor'] . " ";
                } 
                if ($obj3['tipo'] == 'EMAIL') {
                    $b->email .= $obj3['valor'] . " ";
                }
            }
            //$manterBeneficiario->salvar($b);
            print_r($b);
            echo "<br/><br/>";
        }
        if(!$manterFilaPericiaEco->existeGuia($obj['id'])) {
            $filaPericiaEco = new FilaPericiaEco();
            $filaPericiaEco->id_guia = $obj['id'];
            $filaPericiaEco->autorizacao = $obj['autorizacao'];
            $filaPericiaEco->data_solicitacao = $obj['data_solicitacao'];
            $filaPericiaEco->justificativa = $obj['justificativa'];
            $filaPericiaEco->situacao = $obj['situacao'];
            $filaPericiaEco->cpf = $obj2['cpf_cnpj'];
            $filaPericiaEco->codigo = '';
            $filaPericiaEco->descricao = '';
            $rs_itens = $manterFilaPericia->listarItensGuia($obj['id']);
            foreach ($rs_itens as $item) {
                $filaPericiaEco->codigo .= $item['codigo'] . " ";
                $filaPericiaEco->descricao .= $item['descricao'] . " ";
            }
            //$manterFilaPericiaEco->salvar($filaPericiaEco);
            print_r($filaPericiaEco);
            echo "<br/>";
        }
    }
}
