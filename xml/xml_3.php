<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel'])) {
    $file = $_FILES['excel']['tmp_name'];
    $data = $_POST['data'];
    $reti = $_POST['reti'];
    $tpAmb = $_POST['tpamb'];
    $procEmi = $_POST['procEmi'];
    $netRend = $_POST['rend'];

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        function cleanTagName($name) {
            $name = preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name));
            $name = preg_replace('/_{2,}/', '_', $name);
            return $name;
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('Reinf');
        $root->setAttribute('xmlns', 'http://www.reinf.esocial.gov.br/schemas/evt4020PagtoBeneficiarioPJ/v2_01_02');
        $root->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $dom->appendChild($root);

        $evtRetPJ = $dom->createElement('evtRetPJ');
        $uniqueId = bin2hex(random_bytes(16));
        $uniqueId = strtoupper($uniqueId);
        $evtRetPJ->setAttribute('id', 'ID' . $uniqueId);
        $root->appendChild($evtRetPJ);

        $ideEvento = $dom->createElement('ideEvento');
        $evtRetPJ->appendChild($ideEvento);
        $ideEvento->appendChild($dom->createElement('indRetif', $reti));
        $date = new DateTime($data);
        $formatada = $date->format('Y-m');
        $ideEvento->appendChild($dom->createElement('perApur', $formatada));
        $ideEvento->appendChild($dom->createElement('tpAmb', $tpAmb));
        $ideEvento->appendChild($dom->createElement('procEmi', $procEmi));
        $ideEvento->appendChild($dom->createElement('verProc', 'REINF.Web'));

        $ideContri = $dom->createElement('ideContri');
        $evtRetPJ->appendChild($ideContri);
        $tpInsc = '02002020154'; // Exemplo de CPF

        if (strlen($tpInsc) == 11) {
            $ideContri->appendChild($dom->createElement('tpInsc', '2'));
        } else if (strlen($tpInsc) == 14) {
            $ideContri->appendChild($dom->createElement('tpInsc', '1'));
        }
        $ideContri->appendChild($dom->createElement('nrInsc', '8302402'));

        $ideEstab = $dom->createElement('ideEstab');
        $evtRetPJ->appendChild($ideEstab);
        $ideEstab->appendChild($dom->createElement('tpInscEstab', '1'));
        $ideEstab->appendChild($dom->createElement('nrInscEstab', '8302402000152'));

        $ideBenef = $dom->createElement('ideBenef');
        $ideEstab->appendChild($ideBenef);
        $ideBenef->appendChild($dom->createElement('cnpjBenef', '00531954000120'));

        $idePgto = $dom->createElement('idePgto');
        $ideBenef->appendChild($idePgto);
        $idePgto->appendChild($dom->createElement('natRend', $netRend));

        $headers = [];

        foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex == 1) {
                foreach ($row->getCellIterator() as $cell) {
                    $headers[] = cleanTagName($cell->getValue() ?? '');
                }
                continue;
            }

            $infoPgto = $dom->createElement('infoPgto');
            $hasData = false;

            $cellIndex = 0;
            foreach ($row->getCellIterator() as $cell) {
                $cellValue = $cell->getValue();
                if ($cellValue !== null && trim($cellValue) !== '') {
                    if (isset($headers[$cellIndex])) {
                        $tagName = cleanTagName($headers[$cellIndex]);
                        if ($tagName === 'DATA_PAGAMENTO') {
                            if (is_numeric($cellValue)) {
                                $dataPagamento = DateTime::createFromFormat('Y-m-d', '1900-01-01')->modify("+$cellValue days -2 days")->format('Y-m-d');
                                $infoPgto->appendChild($dom->createElement($tagName, htmlspecialchars($dataPagamento)));
                            } else {
                                $infoPgto->appendChild($dom->createElement($tagName, htmlspecialchars((string) $cellValue)));
                            }
                            $hasData = true;
                        } elseif ($tagName === 'VALOR_B_CALCULO_IMPOSTOS' || $tagName === 'PROCESSO') {
                            $infoPgto->appendChild($dom->createElement($tagName, htmlspecialchars((string) $cellValue)));
                            $hasData = true;
                        } elseif ($tagName === 'NOTA_FISCAL') {
                            $infoPgto->appendChild($dom->createElement($tagName, htmlspecialchars((string) $cellValue)));
                            $hasData = true;
                        } elseif ($tagName === 'RETENCAO_IRRF') {
                            $retencoes = $dom->createElement('retencoes');
                            $infoPgto->appendChild($retencoes);
                            $retencoes->appendChild($dom->createElement($tagName, htmlspecialchars((string) $cellValue)));
                            $hasData = true;
                        } elseif ($tagName === 'CNPJ') {
                            $infoPgto->appendChild($dom->createElement($tagName, htmlspecialchars((string) $cellValue)));
                            $hasData = true;
                        }
                    }
                }
                $cellIndex++;
            }

            if ($hasData) {
                $idePgto->appendChild($infoPgto);
            }
        }

        if (isset($_POST['baixar'])) {
            header('Content-Type: application/xml');
            header('Content-Disposition: attachment; filename="saida.xsd"');
            echo $dom->saveXML();
            exit;
        }
        $dom->save('saida.xml');
        header('Location: saida.xml');
        exit;
    } catch (Exception $e) {
        echo 'Erro ao processar o arquivo: ' . $e->getMessage();
    }
}
?>
