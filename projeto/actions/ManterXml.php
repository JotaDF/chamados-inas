<?php
require 'Model.php'; // Inclui a classe base de acesso ao banco de dados

class ManterXml extends Model
{
    function __construct() {
        parent::__construct(); // Chama o construtor da classe Model para conectar ao banco
    }

    function salvaXml($path) // Método para carregar e salvar os dados do XML no banco
    {
        $xml = simplexml_load_file($path); // Carrega o arquivo XML

        $namespace = 'http://www.reinf.esocial.gov.br/schemas/evt4020PagtoBeneficiarioPJ/v2_01_02';
        $xml->registerXPathNamespace('ns', $namespace); // Registra o namespace para poder usar XPath com prefixo

        // Verifica se houve erro de conexão com o banco
        if ($this->db->connect_error) {
            die("Falha na conexão: " . $this->db->connect_error);
        }

        // Busca o ID do evento no XML
        foreach ($xml->xpath('//ns:evtRetPJ') as $evtRetPJ) {
            $id = (string) $evtRetPJ['id']; // Pega o atributo 'id'
        }

        // Busca os dados do evento
        foreach ($xml->xpath('//ns:ideEvento') as $ideEvento) {
            $indRetif = (int) $ideEvento->indRetif;
            $perApur = (string) $ideEvento->perApur;
            $tpAmb = (int) $ideEvento->tpAmb;
            $procEmi = (int) $ideEvento->procEmi;
            $verProc = (string) $ideEvento->verProc;
        }

        // Busca os dados do contribuinte
        foreach ($xml->xpath('//ns:ideContri') as $ideContri) {
            $tpInsc = (int) $ideContri->tpInsc;
            $nrInsc = (int) $ideContri->nrInsc;
        }

        // Busca os dados de pagamento
        foreach ($xml->xpath('//ns:infoPgto') as $infoPgto) {
            $dataPagamento = (string) $infoPgto->DATA_PAGAMENTO;
            $processo = (string) $infoPgto->PROCESSO;
            $valorCalculoImpostos = (float) $infoPgto->VALOR_B_CALCULO_IMPOSTOS;
            $nota = (string) $infoPgto->NOTA_FISCAL;
            $retencoes = (float) $infoPgto->retencoes->RETENCAO_IRRF;
            $cnpj = (string) $infoPgto->CNPJ;

            // Converte a data de número de dias para formato YYYY-MM-DD, se necessário
            if (is_numeric($dataPagamento)) {
                $dataPagamentoTimestamp = strtotime("1900-01-01 +$dataPagamento days -2 days");
                $dataPagamentoFormatada = date("Y-m-d", $dataPagamentoTimestamp);
            } else {
                $dataPagamentoFormatada = $dataPagamento;
            }

            // Busca os dados do beneficiário
            foreach ($xml->xpath('//ns:ideBenef') as $ideBenef) {
                $cnpjBenf = (string) $ideBenef->cnpjBenef;
                $natRend = (string) $ideBenef->idePgto->natRend;

                // Busca os dados do estabelecimento
                foreach ($xml->xpath('//ns:ideEstab') as $ideEstab) {
                    $tipo_insc_estab = (string) $ideEstab->tpInscEstab;
                    $numero_insc_estab = (string) $ideEstab->nrInscEstab;
                }
            }

            // Monta a SQL para inserir os dados extraídos do XML na tabela XML
            $sql = "INSERT INTO XML (data_pagamento, processo, valor_calculo_imposto, cnpj_benef, natRend, nota, nrInscEstab, tpInscEstab, retencao, tpInsc, nrInsc, indRetif, perApur, tpAmb, procEmi, verProc, evtRetPJ)
            VALUES ('$dataPagamentoFormatada', '$processo', $valorCalculoImpostos, '$cnpj', '$natRend', '$nota', '$numero_insc_estab', '$tipo_insc_estab', $retencoes, $tpInsc, $nrInsc, $indRetif, '$perApur', $tpAmb, $procEmi, '$verProc', '$id')";

            // Executa a SQL e trata possíveis erros
            if (!$this->db->query($sql)) {
                echo "Erro ao inserir: " . $this->db->error . "\n";
            }
        }

        echo "Dados inseridos com sucesso!"; // Mensagem final
    }
}
