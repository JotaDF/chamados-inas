<?php
// Requer os arquivos necessários para o funcionamento do modelo
require_once('Model.php');
require_once('dto/SlaRegulacao.php');

// Classe que gerencia os dados de SLA de regulacao
class ManterSlaRegulacao extends Model {

    // Método construtor
    function __construct() {
        parent::__construct();  // Chama o construtor da classe pai (Model)
    }

    // Função para listar os registros de SLA de regulação com atraso
    function listaSlaRegulacaoAtrasado($fila) {
        // Consulta SQL para selecionar os registros com atraso na fila especificada
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado 
                FROM sla_regulacao as s 
                WHERE s.autorizado is  null AND s.atraso > 0 AND s.fila ='" . $fila . "'";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados
        $array_dados = array();
        
        // Itera sobre os resultados e preenche o array com os objetos SlaRegulacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao = $registro["autorizacao"];
            $dados->tipo_guia = $registro["tipo_guia"];
            $dados->area = $registro["area"];
            $dados->fila = $registro["fila"];
            $dados->encaminhamento_manual = $registro["encaminhamento_manual"];
            $dados->data_solicitacao_t = $registro["data_solicitacao_t"];
            $dados->data_solicitacao_d = $registro["data_solicitacao_d"];
            $dados->atraso = $registro["atraso"];
            $dados->autorizado = $registro["autorizado"];
            $array_dados[] = $dados;
        }
        return $array_dados;  // Retorna o array com os dados
    }

    // Função para listar os registros de SLA de regulação dentro do prazo
    function listaSlaRegulacaoNoPrazo($fila) {
        // Consulta SQL para selecionar os registros dentro do prazo na fila especificada
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado 
                FROM sla_regulacao AS s 
                WHERE s.autorizado IS NULL AND s.fila = '".$fila."' AND s.atraso = 0";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados
        $array_dados = array();
        
        // Itera sobre os resultados e preenche o array com os objetos SlaRegulacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao = $registro["autorizacao"];
            $dados->tipo_guia = $registro["tipo_guia"];
            $dados->area = $registro["area"];
            $dados->fila = $registro["fila"];
            $dados->encaminhamento_manual = $registro["encaminhamento_manual"];
            $dados->data_solicitacao_t = $registro["data_solicitacao_t"];
            $dados->data_solicitacao_d = $registro["data_solicitacao_d"];
            $dados->atraso = $registro["atraso"];
            $dados->autorizado = $registro["autorizado"];
            $array_dados[] = $dados;
        }
        return $array_dados;  // Retorna o array com os dados
    }

    // Função para listar os registros temporários de SLA de regulação
    function listaSlaRegulacaoTemporaria() {
        // Consulta SQL para selecionar os registros temporários de SLA de regulação
        $sql = "SELECT autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado FROM sla_regulacao_tmp";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados
        $array_dados = array();
        
        // Itera sobre os resultados e preenche o array com os objetos SlaRegulacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao = $registro["autorizacao"];
            $dados->tipo_guia = $registro["tipo_guia"];
            $dados->area = $registro["area"];
            $dados->fila = $registro["fila"];
            $dados->encaminhamento_manual = $registro["encaminhamento_manual"];
            $dados->data_solicitacao_t = $registro["data_solicitacao_t"];
            $dados->data_solicitacao_d = $registro["data_solicitacao_d"];
            $dados->atraso = $registro["atraso"];
            $dados->autorizado = $registro["autorizado"];
            $array_dados[] = $dados;
        }
        return $array_dados;  // Retorna o array com os dados
    }

    // Função para listar todos os registros de SLA de regulação
    function listarSlaRegulacaoTodas() {
        // Consulta SQL para selecionar todos os registros de SLA de regulação
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados
        $array_dados = array();
        
        // Itera sobre os resultados e preenche o array com os objetos SlaRegulacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            // Atribui os valores dos atributos ao objeto SlaRegulacao
            $atributos = [
                "autorizacao", "tipo_guia", "area", "fila", "encaminhamento_manual", 
                "data_solicitacao_t", "data_solicitacao_d", "atraso", "autorizado"
            ];
            // Preenche o objeto SlaRegulacao com os dados do banco
            foreach ($atributos as $atributo) {
                $dados->$atributo = $registro[$atributo];
            }
            $array_dados[] = $dados;  // Adiciona o objeto ao array
        }
        return $array_dados;  // Retorna o array com os dados
    }

    // Função para listar os registros de SLA de regulação com base na fila, se fornecida
    function listarSlaRegulacao($fila="") {
        // Consulta SQL base para selecionar os registros de SLA de regulação onde autorizado é null
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.autorizado is null";
        
        // Se uma fila for fornecida, a consulta é modificada para filtrar pela fila específica
        if ($fila != "") {
            $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado 
                    FROM sla_regulacao as s WHERE s.fila = '" . $fila . "' AND s.autorizado is null";
        }
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados
        $array_dados = array();
        
        // Itera sobre os resultados e preenche o array com os objetos SlaRegulacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao = $registro["autorizacao"];
            $dados->tipo_guia = $registro["tipo_guia"];
            $dados->area = $registro["area"];
            $dados->fila = $registro["fila"];
            $dados->encaminhamento_manual = $registro["encaminhamento_manual"];
            $dados->data_solicitacao_t = $registro["data_solicitacao_t"];
            $dados->data_solicitacao_d = $registro["data_solicitacao_d"];
            $dados->atraso = $registro["atraso"];
            $dados->autorizado = $registro["autorizado"];
            $array_dados[] = $dados;
        }
        return $array_dados;  // Retorna o array com os dados
    }

// Função para listar os registros de SLA de regulamentação não autorizados
function listarSlaRegulacaoNaoAutorizados()
{
    // SQL que seleciona registros de sla_regulacao onde o campo 'autorizado' é nulo
    $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.autorizado is null";
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    
    // Loop para processar os registros retornados
    while ($registro = $resultado->fetchRow()) {
        // Cria um novo objeto SlaRegulacao para armazenar os dados
        $dados = new SlaRegulacao();
        // Atribui os valores dos campos aos atributos do objeto
        $dados->autorizacao = $registro["autorizacao"];
        $dados->tipo_guia = $registro["tipo_guia"];
        $dados->area = $registro["area"];
        $dados->fila = $registro["fila"];
        $dados->encaminhamento_manual = $registro["encaminhamento_manual"];
        $dados->data_solicitacao_t = $registro["data_solicitacao_t"];
        $dados->data_solicitacao_d = $registro["data_solicitacao_d"];
        $dados->atraso = $registro["atraso"];
        $dados->autorizado = $registro["autorizado"];
        // Adiciona o objeto ao array de dados
        $array_dados[] = $dados;
    }
    
    // Retorna o array com os dados
    return $array_dados;
}

// Função para contar os registros temporários de SLA de regulamentação
function CountRegistrosRegulacaoTmp() {
    // SQL que conta o número total de registros na tabela sla_regulacao_tmp
    $sql = "SELECT COUNT(*) as total FROM sla_regulacao_tmp"; 
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    
    // Se um registro for encontrado, retorna o total
    if($registro = $resultado->fetchRow()) {
        return $registro['total'];
    }
}

// Função para listar os prazos de SLA
function listarSlaPrazo()
{
    // SQL que seleciona os prazos de SLA
    $sql = "SELECT s.id, s.tipo_guia, s.fila, s.prazo_dias, s.prazo_segundos FROM sla_prazo as s ORDER BY s.tipo_guia";
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    
    // Loop para processar os registros retornados
    while ($registro = $resultado->fetchRow()) {
        // Cria um objeto stdClass para armazenar os dados
        $dados = new stdClass;
        // Atribui os valores dos campos aos atributos do objeto
        $dados->tipo_guia = $registro['tipo_guia'];
        $dados->fila = $registro['fila'];
        $dados->prazo_dias = $registro['prazo_dias'];
        $dados->prazo_segundos = $registro['prazo_segundos'];
        // Adiciona o objeto ao array de dados
        $array_dados[] = $dados;
    }
    
    // Retorna o array com os dados
    return $array_dados;
}

// Função para obter os totais de SLA por prazo
function getTotaisPrazo()
{
    // SQL que soma os atrasos e conta os registros com atraso e sem atraso
    $sql = 'SELECT fila, 
               SUM(CASE WHEN atraso > 0 THEN atraso ELSE 0 END) AS total_atraso,  -- Soma dos atrasos
               COUNT(CASE WHEN atraso > 0 THEN 1 END) AS atraso_count,               -- Contagem de registros com atraso
               COUNT(CASE WHEN atraso = 0 THEN 1 END) AS no_atraso_count            -- Contagem de registros sem atraso
        FROM sla_regulacao WHERE autorizado IS NULL
        GROUP BY fila';
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    // Loop para processar os registros retornados
    while ($registro = $resultado->fetchRow()) {
        // Cria um objeto stdClass para armazenar os dados
        $dados = new stdClass;
        $dados->fila = $registro['fila'];  // Nome da fila
        $dados->total_atraso = $registro['total_atraso'];  // Soma dos dias de atraso
        $dados->atraso_count = $registro['atraso_count'];  // Quantidade de registros com atraso
        $dados->no_atraso_count = $registro['no_atraso_count'];  // Quantidade de registros sem atraso
        // Adiciona o objeto ao array de dados
        $array_dados[] = $dados;
    }

    // Retorna o array com os dados
    return $array_dados;
}

// Função para obter os totais de SLA com prazo zerado, excluindo filas específicas
function getTotaisPrazoZerado($listaFilas = "") // Lista de filas a serem excluídas
{   
    $array_dados = array();
    // Se uma lista de filas for fornecida
    if($listaFilas != "") {
        // SQL que seleciona filas excluindo as listadas
        $sql = "SELECT DISTINCT fila, autorizado FROM sla_regulacao WHERE fila NOT IN(".$listaFilas.")   ORDER BY fila";
        $resultado = $this->db->Execute($sql);
        
        // Loop para processar os registros retornados
        while ($registro = $resultado->fetchRow()) {
            // Cria um objeto stdClass para armazenar os dados
            $dados = new stdClass;
            $dados->fila = $registro['fila'];  // Nome da fila
            $dados->total_atraso = 0;  // Soma dos dias de atraso
            $dados->atraso_count = 0;  // Quantidade de registros com atraso
            $dados->no_atraso_count = 0;  // Quantidade de registros sem atraso
            // Adiciona o objeto ao array de dados
            $array_dados[] = $dados;
        }
    }
    // Retorna o array com os dados
    return $array_dados;
}

// Função para obter o total de guias não autorizadas
function getTotalGuias()
{
    // SQL que conta o número total de registros na tabela sla_regulacao onde 'autorizado' é nulo
    $sql = "SELECT COUNT(*) as total FROM sla_regulacao  WHERE autorizado IS NULL";
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    if ($registro = $resultado->fetchRow()) {
        return $registro['total'];
    }
    return 0;
}

// Função para obter o prazo de uma guia específica
function getPrazoGuia($tipo_guia, $fila)
{
    // SQL que seleciona o prazo em segundos para o tipo de guia e fila fornecidos
    $sql = "SELECT p.prazo_segundos FROM sla_prazo as p WHERE p.tipo_guia = '" . $tipo_guia . "' AND p.fila = '" . $fila . "'";
    
    // Executa a consulta no banco de dados
    $resultado = $this->db->Execute($sql);
    if ($registro = $resultado->fetchRow()) {
        return $registro['prazo_segundos'];
    }
    return 0;
}



function getTotaisAtraso() {
    $sql = 'SELECT 
    COUNT(CASE WHEN atraso = 0 THEN 1 END) as atraso_0,  -- Contagem dos registros sem atraso
    COUNT(CASE WHEN atraso > 0 THEN 1 END) as atraso_1,  -- Contagem dos registros com atraso
    SUM(CASE WHEN atraso > 0 THEN atraso ELSE 0 END) as total_atraso  -- Soma dos dias de atraso
    FROM sla_regulacao 
    WHERE atraso >= 0 AND autorizado IS NULL';  // Considera todos os registros onde atraso é maior ou igual a zero

    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    if ($registro = $resultado->fetchRow()) {
        // Retorna os totais de registros com atraso, sem atraso e o total de dias de atraso
        return array(
            'atraso_0' => $registro['atraso_0'],      // Registros sem atraso
            'atraso_1' => $registro['atraso_1'],      // Registros com atraso
            'total_atraso' => $registro['total_atraso']  // Total de dias de atraso
        );
    }

    return 0;  // Retorna 0 se não houver registros encontrados
}

// Função que retorna os registros de sla_regulacao onde já foram autorizados
function getAutorizados() {
    $sql = "SELECT autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado FROM  sla_regulacao where autorizado is not null";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        // Cria objeto SlaRegulacao para armazenar os dados
        $dados = new SlaRegulacao();
        $dados->autorizacao = $registro['autorizacao'];
        $dados->tipo_guia = $registro['tipo_guia'];
        $dados->area = $registro['area'];
        $dados->fila = $registro['fila'];
        $dados->encaminhamento_manual = $registro['encaminhamento_manual'];
        $dados->data_solicitacao_d = $registro['data_solicitacao_d'];
        $dados->atraso = $registro['atraso'];
        $dados->autorizado = $registro['autorizado'];
        $array_dados[] = $dados;  // Adiciona o objeto ao array de dados
    }
    return $array_dados;  // Retorna todos os registros autorizados
}

// Função que retorna os registros de sla_regulacao onde ainda não foram autorizados
function getNaoAutorizados() {
    $sql = "SELECT autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado FROM  sla_regulacao where autorizado is null";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        // Cria objeto SlaRegulacao para armazenar os dados
        $dados = new SlaRegulacao();
        $dados->autorizacao = $registro['autorizacao'];
        $dados->tipo_guia = $registro['tipo_guia'];
        $dados->area = $registro['area'];
        $dados->fila = $registro['fila'];
        $dados->encaminhamento_manual = $registro['encaminhamento_manual'];
        $dados->data_solicitacao_d = $registro['data_solicitacao_d'];
        $dados->atraso = $registro['atraso'];
        $dados->autorizado = $registro['autorizado'];
        $array_dados[] = $dados;  // Adiciona o objeto ao array de dados
    }
    return $array_dados;  // Retorna todos os registros não autorizados
}

// Função que atualiza o atraso de um registro específico, identificando-o pela autorização
function atualizaAtraso($autorizacao, $tempo) {
    $sql = "UPDATE sla_regulacao SET atraso = " . $tempo . " WHERE autorizacao=" . $autorizacao;
    $resultado = $this->db->Execute($sql);  // Executa a atualização do atraso
    return $resultado;  // Retorna o resultado da operação
}

// Função que atualiza os registros autorizados, se houver registros na tabela temporária
function atualizaAutorizados() {
    $sql_count = "SELECT COUNT(*) as total FROM sla_regulacao_tmp";
    $rs = $this->db->Execute($sql_count);
    $processa = false;
    if ($registro = $rs->fetchRow()) {
        if ($registro['total'] > 0) {
            $processa = true;  // Verifica se há registros na tabela temporária
        }
    }
    if ($processa) {
        // Atualiza registros não autorizados com o timestamp de autorização
        $sql = 'UPDATE sla_regulacao SET sla_regulacao.autorizado = NOW() WHERE sla_regulacao.autorizacao IS NULL AND sla_regulacao.autorizacao NOT IN (SELECT sla_regulacao_tmp.autorizacao  FROM sla_regulacao_tmp  WHERE sla_regulacao_tmp.autorizacao IS NOT NULL)';
        $resultado = $this->db->Execute($sql);  // Executa a atualização
        return $resultado;  // Retorna o resultado da operação
    }
    return false;  // Retorna false se não houver registros a atualizar
}

// Função que insere novos registros de sla_regulacao a partir da tabela temporária
function atualizaNovosSla() {
    $sql = 'INSERT INTO sla_regulacao ( autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado) (SELECT * FROM sla_regulacao_tmp as srt WHERE srt.autorizacao NOT IN (select autorizacao from sla_regulacao))';
    $resultado = $this->db->Execute($sql);  // Executa a inserção dos novos registros
    return $resultado;  // Retorna o resultado da operação
}

// Função que registra uma atualização com a data e o ID do usuário
function registraAtualizacao($id) {
    $sql = "INSERT INTO sla_atualizacao (atualizacao, id_usuario)  VALUES (NOW(), $id)";
    $resultado = $this->db->Execute($sql);  // Registra a atualização no banco
    if($resultado) {
        return $resultado;  // Retorna o resultado da operação
    } else {
        return false;  // Retorna false se ocorrer algum erro
    }
}

// Função que retorna a última atualização registrada, com os detalhes do usuário responsável
function getUltimaAtualizacao() {
    $sql = "SELECT a.atualizacao, a.id_usuario, u.nome, u.id FROM sla_atualizacao as a, usuario as u WHERE a.id = (SELECT MAX(id) FROM sla_atualizacao) AND a.id_usuario = u.id";
    $resultado = $this->db->Execute($sql);
    if($registro = $resultado->fetchRow()) {
        // Retorna a data da última atualização e o nome do usuário responsável
        $atualizacao = $registro['atualizacao'];
        $nome = $registro['nome'];
        return array('atualizacao' => $atualizacao, 'nome' => $nome);
    } else {
        return false;  // Retorna false se não houver registro de atualização
    }
}

// Função que limpa a tabela temporária de sla_regulacao
function limpaSlaTemporaria() {
    $sql = 'DELETE FROM sla_regulacao_tmp';
    $resultado = $this->db->Execute($sql);  // Executa a exclusão de dados na tabela temporária
    return $resultado;  // Retorna o resultado da operação
}

    function uploadCsv($file)
    {
        // Define o diretório de upload CAUÊ
       //$uploadDir = "/var/www/html/inas/chamados-inas/projeto/csv_teste/";  // Caminho relativo ao diretório do script PHP
        //  Define o diretório de upload INAS
        $uploadDir = "/var/www/html/sinas/csv_sla/";  // Caminho relativo ao diretório do script PHP


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
        $fileName = 'relatorio_sla.csv';
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
        // Caminho do arquivo CSV CAUÊ
        //$caminho_csv = "/var/www/html/inas/chamados-inas/projeto/csv_teste/relatorio_sla.csv";
        // CAMINHO INAS
         $caminho_csv = "/var/www/html/sinas/csv_sla/relatorio_sla.csv";

        try {
            // Verificar se o arquivo pode ser aberto
            if (($handle = fopen($caminho_csv, 'r')) !== false) {

                // Ignorar a primeira linha (cabeçalho do CSV)
                fgetcsv($handle, 9000, ',');

                // Definir a consulta SQL com placeholders
                $sql = "INSERT INTO sla_regulacao_tmp (autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


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
                    $atraso = 0;
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
                        $data_solicitacao_d,
                        $atraso
                    ]);

                    if (!$result) {
                        echo "Erro ao inserir dados: " . $this->db->ErrorMsg();
                    } else {
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

// Função que calcula a data da Páscoa para um ano específico
function calcularDataPascoa($ano)
{
    $a = $ano % 19;  // Ciclo Metônico
    $b = floor($ano / 100);  // Século
    $c = $ano % 100;  // Ano dentro do século
    $d = floor($b / 4);  // Correção do ano de acordo com o século
    $e = $b % 4;  // Resto da divisão do século por 4
    $f = floor(($b + 8) / 25);  // Ajuste para o cálculo do equinócio
    $g = floor(($b - $f + 1) / 3);  // Ajuste adicional
    $h = (19 * $a + $b - $d - $g + 15) % 30;  // Cálculo da data da Páscoa
    $i = floor($c / 4);  // Ajuste para o século
    $k = $c % 4;  // Resto da divisão do ano dentro do século por 4
    $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;  // Ajuste final para a data da Páscoa
    $m = floor(($a + 11 * $h + 22 * $l) / 451);  // Cálculo final
    $month = floor(($h + $l - 7 * $m + 114) / 31);  // Mês da Páscoa
    $day = (($h + $l - 7 * $m + 114) % 31) + 1;  // Dia da Páscoa

    // Retorna a data da Páscoa como timestamp
    return mktime(0, 0, 0, $month, $day, $ano);
}

// Função que retorna a lista de dias de feriado para um ano específico
function getListaDiasFeriado($ano = null)
{
    // Se o ano não for passado, usa o ano atual
    if ($ano === null) {
        $ano = intval(date('Y'));
    }

    // Calcula a data da Páscoa do ano especificado
    $pascoa = $this->calcularDataPascoa($ano); 
    $diaPascoa = date('j', $pascoa);  // Dia da Páscoa
    $mesPacoa = date('n', $pascoa);   // Mês da Páscoa
    $anoPascoa = date('Y', $pascoa);  // Ano da Páscoa

    // Define os feriados fixos e variáveis (relativos à Páscoa)
    $feriados = [
        mktime(0, 0, 0, 1, 1, $ano),   // Confraternização Universal
        mktime(0, 0, 0, 4, 21, $ano),  // Tiradentes
        mktime(0, 0, 0, 5, 1, $ano),   // Dia do Trabalhador
        mktime(0, 0, 0, 9, 7, $ano),   // Dia da Independência
        mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida
        mktime(0, 0, 0, 11, 2, $ano),  // Todos os Santos
        mktime(0, 0, 0, 11, 15, $ano), // Proclamação da República
        mktime(0, 0, 0, 12, 25, $ano), // Natal
        // Feriados variáveis relacionados à Páscoa
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 48, $anoPascoa), // 2ª-feira de Carnaval
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 47, $anoPascoa), // 3ª-feira de Carnaval
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 2, $anoPascoa),  // 6ª-feira Santa
        mktime(0, 0, 0, $mesPacoa, $diaPascoa, $anoPascoa),      // Páscoa
        mktime(0, 0, 0, $mesPacoa, $diaPascoa + 60, $anoPascoa), // Corpus Christi
    ];

    // Ordena os feriados
    sort($feriados);

    // Converte os feriados para o formato 'Y-m-d' e os armazena em um array
    $listaDiasFeriado = [];
    foreach ($feriados as $feriado) {
        $data = date('Y-m-d', $feriado);
        $listaDiasFeriado[$data] = $data;
    }

    return $listaDiasFeriado;
}

// Função para verificar se uma data é feriado
function isFeriado($data)
{
    // Obtém a lista de feriados para o ano da data passada
    $listaFeriado = $this->getListaDiasFeriado(date('Y', strtotime($data)));

    // Verifica se a data está na lista de feriados
    if (isset($listaFeriado[$data])) {
        return true;
    }

    return false;
}

// Função que calcula o número de dias úteis entre duas datas
function getDiasUteis($data_inicial, $data_final)
{
    $dias_uteis = 0;

    // Enquanto a data inicial for menor ou igual à data final
    while ($data_inicial <= $data_final) {
        // Verifica se o dia é útil (não é sábado nem domingo)
        if (date('N', $data_inicial) <= 5) {  // 'N' retorna 1 para segunda-feira até 7 para domingo
            $dias_uteis++;
        }

        // Avança para o próximo dia (em timestamp)
        $data_inicial = strtotime("+1 day", $data_inicial);
    }

    return $dias_uteis;
}

}