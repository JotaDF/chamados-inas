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
                    if($b->telefone != '') {
                        $b->telefone .= "; ";
                    }
                    $b->telefone .= $obj3['valor'];
                } 
                if ($obj3['tipo'] == 'EMAIL') {
                    if($b->email != '') {
                        $b->email .= "; ";
                    }
                    $b->email .= $obj3['valor'];
                }
            }
            //print_r($b);
            $manterBeneficiario->salvar($b);
            echo "Salvou!! (".$b->cpf.")<br/><br/>";
        }
        if(!$manterFilaPericiaEco->existeGuia($obj['id']) && $manterBeneficiario->existeCpf($obj2['cpf_cnpj'])) {
            $f = new FilaPericiaEco();
            $f->id_guia = $obj['id'];
            $f->autorizacao = $obj['autorizacao'];
            $f->data_solicitacao = $obj['data_solicitacao'];
            $f->justificativa = $obj['justificativa'];
            $f->situacao = $obj['situacao'];
            $f->cpf = $obj2['cpf_cnpj'];
            $f->descricao = '';
            $rs_itens = $manterFilaPericia->listarItensGuia($obj['id']);
            foreach ($rs_itens as $item) {
                if($f->descricao != '') {
                    $f->descricao .= "; ";
                }
                $f->descricao .= $item['codigo'] . " - " . $item['descricao'];
            }
            $manterFilaPericiaEco->salvar($f);
            print_r($f);
            echo "Salvou!! (".$f->id_guia.")<br/><hr/>";
        }
    }
}
