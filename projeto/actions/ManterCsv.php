<?php
include('Model.php');
require 'vendor/autoload.php'; // Certifique-se de que o caminho está correto para o arquivo autoload.php gerado pelo Composer
use League\Csv\Reader;

class ManterCsv extends Model
{

    function uploadCsv($file)
    {
        // Define o diretório de upload
        $uploadDir = "/var/www/html/inas/chamados-inas/projeto/csv_teste/";  // Caminho relativo ao diretório do script PHP


        // Verifica se ocorreu algum erro no envio do arquivo
        if ($file['error'] != 0) {
            return ['success' => false, 'message' => 'Erro no envio do arquivo.'];
        }

        // Verifica a extensão e o tipo_guia do arquivo
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($fileType) !== 'csv') {
            return ['success' => false, 'message' => 'O arquivo não é um CSV válido.'];
        }

        // Garante que o nome do arquivo seja único para evitar sobreposição
        $fileName = 'relatorio_csv-' . basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return ['success' => true, 'message' => 'Arquivo enviado com sucesso!', 'filePath' => $uploadFilePath];
        } else {
            return ['success' => false, 'message' => 'Erro ao enviar o arquivo.'];
        }
    }

    function insereCsv()
    {
        // Caminho do arquivo CSV
        $caminho_csv = "/var/www/html/inas/chamados-inas/projeto/csv_teste/relatorio_csv-relatorio_sla.csv";

        try {
            // Verificar se o arquivo pode ser aberto
            if (($handle = fopen($caminho_csv, 'r')) !== false) {

                // Ignorar a primeira linha (cabeçalho do CSV)
                fgetcsv($handle, 9000, ',');

                // Definir a consulta SQL com placeholders
                $sql = "INSERT INTO sla_regulacao (autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

        
                    // Ler o arquivo CSV linha por linha
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        // Atribuir os valores do CSV às variáveis
                        $autorizacao = $data[0];
                        $tipo_guia = $data[1];
                        $area = $data[2];
                        $fila = $data[3];
                        $encaminhamento_manual = $data[4];
                        $data_solicitacao_t = $data[5];
                        $data_solicitacao_d = $data[5];


                        // Converter a data solicitacão para timestamp
                        $date_t = DateTime::createFromFormat('d/m/Y H:i', $data_solicitacao_t); // Formato completo com hora e minuto
                        $data_solicitacao_convertida = $date_t ? $date_t->getTimestamp() : null; // Verifica se a data foi convertida corretamente

                        // Converter a data solicitacão para Datetime
                        $date_d = DateTime::createFromFormat('d/m/Y H:i', $data_solicitacao_d);
                        $data_solicitacao_d = $date_d->format('Y-m-d H:i:s');

                        // Converter o valor "SIM" para 1 e "NAO" para 0
                        $encaminhamento_manual_convertido = ($encaminhamento_manual == "SIM") ? 1 : 0;

                        // fazendo a condificação para utf8
                        $this->db->Execute("SET NAMES 'utf8mb4'");

                        $result = $this->db->Execute($sql, [
                            $autorizacao,
                            $tipo_guia,
                            $area,
                            $fila,
                            $encaminhamento_manual_convertido,
                            $data_solicitacao_convertida,
                            $data_solicitacao_d
                        ]);

                        // Verifica se a execução foi bem-sucedida
                        if (!$result) {
                            echo "Erro ao inserir dados: " . $this->db->ErrorMsg();
                        }
                    }

                    // Fechar o arquivo após a leitura
                    fclose($handle);

                    echo "Dados importados com sucesso!";
                
            } else {
                echo "Erro ao abrir o arquivo CSV.";
            }
        } catch (Exception $e) {
            echo "Erro ao processar o arquivo CSV: " . $e->getMessage();
        }
    }



}