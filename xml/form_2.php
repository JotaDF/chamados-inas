<?php
// Carregar o arquivo XML
$xml = simplexml_load_file('saida.xml');

$namespace = 'http://www.reinf.esocial.gov.br/schemas/evt4020PagtoBeneficiarioPJ/v2_01_02';
$xml->registerXPathNamespace('ns', $namespace);
// colocar sua conexão aqui 
$conn = new mysqli('db', 'root', 'root', 'chamados');

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

foreach ($xml->xpath('//ns:evtRetPJ') as $evtRetPJ) {
    $id = (string) $evtRetPJ['id'];
}

foreach ($xml->xpath('//ns:ideEvento') as $ideEvento) {
    $indRetif = (int) $ideEvento->indRetif;
    $perApur = (string) $ideEvento->perApur;
    $tpAmb = (int) $ideEvento->tpAmb;
    $procEmi = (int) $ideEvento->procEmi;
    $verProc = (string) $ideEvento->verProc;
}

foreach ($xml->xpath('//ns:ideContri') as $ideContri) {
    $tpInsc = (int) $ideContri->tpInsc;
    $nrInsc = (int) $ideContri->nrInsc;
}

foreach ($xml->xpath('//ns:infoPgto') as $infoPgto) {
    $dataPagamento = (string) $infoPgto->DATA_PAGAMENTO;
    $processo = (string) $infoPgto->PROCESSO;
    $valorCalculoImpostos = (float) $infoPgto->VALOR_B_CALCULO_IMPOSTOS;
    $nota = (string) $infoPgto->NOTA_FISCAL;
    $retencoes = (float) $infoPgto->retencoes->RETENCAO_IRRF;
    $cnpj = (string) $infoPgto->CNPJ;

    if (is_numeric($dataPagamento)) {
        $dataPagamentoTimestamp = strtotime("1900-01-01 +$dataPagamento days -2 days");
        $dataPagamentoFormatada = date("Y-m-d", $dataPagamentoTimestamp);
    } else {
        $dataPagamentoFormatada = $dataPagamento;
    }

    $valorRetencaoIRRF = 0;

    foreach ($xml->xpath('//ns:ideBenef') as $ideBenef) {
        $cnpjBenf = (string) $ideBenef->cnpjBenef;
        $natRend = (string) $ideBenef->idePgto->natRend;

        foreach ($xml->xpath('//ns:ideEstab') as $ideEstab) {
            $tipo_insc_estab = (string) $ideEstab->tpInscEstab;
            $numero_insc_estab = (string) $ideEstab->nrInscEstab;
        }
    }

    $stmt = $conn->prepare("INSERT INTO XML (data_pagamento, processo, valor_calculo_imposto, cnpj_benef, natRend, nota, nrInscEstab, tpInscEstab, retencao, tpInsc, nrInsc, indRetif, perApur, tpAmb, procEmi, verProc, evtRetPJ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    $stmt->bind_param('ssdsssssdssssiiss', $dataPagamento, $processo, $valorCalculoImpostos, $cnpj, $natRend, $nota, $numero_insc_estab, $tipo_insc_estab, $retencoes, $tpInsc, $nrInsc, $indRetif, $perApur, $tpAmb, $procEmi, $verProc, $id);

    if (!$stmt->execute()) {
        echo "Erro ao inserir: " . $stmt->error . "\n";
    }
}

$stmt->close();
$conn->close();
echo "Dados inseridos com sucesso!";
?>
