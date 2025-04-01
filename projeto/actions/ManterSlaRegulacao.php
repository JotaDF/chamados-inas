<?php
require_once('Model.php');
require_once('dto/SlaRegulacao.php');
class ManterSlaRegulacao extends Model
{
    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listaSlaRegulacaoAtrasado($fila)
    {
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.autorizado is  null AND s.atraso > 0 AND  s.fila ='" . $fila . "'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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
        return $array_dados;
    }
    function listaSlaRegulacaoNoPrazo($fila) 
    {
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao AS s WHERE s.autorizado IS NULL AND s.fila = '".$fila ."' AND s.atraso = 0";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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
        return $array_dados;
    }
    
    function listaSlaRegulacaoTemporaria() {
        $sql = "SELECT  autorizacao ,tipo_guia ,area ,fila ,encaminhamento_manual,data_solicitacao_t,data_solicitacao_d,atraso,autorizado FROM sla_regulacao_tmp";
        $resultado = $this->db->Execute($sql);
        $array_dados  = array();
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
        return $array_dados;
    }

    function listarSlaRegulacaoTodas() {
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
        $dados = new SlaRegulacao();
        $atributos = [
            "autorizacao", "tipo_guia", "area", "fila", "encaminhamento_manual", 
            "data_solicitacao_t", "data_solicitacao_d", "atraso", "autorizado"
        ];
        foreach ($atributos as $atributo) {
                $dados->$atributo = $registro[$atributo];
            }
            $array_dados[] = $dados;
        }
        return $array_dados;

    }

    function listarSlaRegulacao($fila="")
    {
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.autorizado is null";
        
        if($fila!=""){
            $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.fila = '" . $fila . "' AND s.autorizado is null";
        }
        
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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
        return $array_dados;
    }

    function listarSlaRegulacaoNaoAutorizados()
    {
        $sql = "SELECT s.autorizacao, s.tipo_guia, s.area, s.fila, s.encaminhamento_manual, s.data_solicitacao_t, s.data_solicitacao_d, s.atraso, s.autorizado FROM sla_regulacao as s WHERE s.autorizado is null";
         
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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
        return $array_dados;
    }

    function CountRegistrosRegulacaoTmp() {
        $sql = "SELECT COUNT(*) as total FROM sla_regulacao_tmp"; 
        $resultado = $this->db->Execute($sql);
        if($registro = $resultado->fetchRow()) {
            return $registro['total'];
        }
    }
    function listarSlaPrazo()
    {
        $sql = "SELECT s.id, s.tipo_guia, s.fila, s.prazo_dias, s.prazo_segundos FROM sla_prazo as s ORDER BY s.tipo_guia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new stdClass;
            $dados->tipo_guia = $registro['tipo_guia'];
            $dados->fila = $registro['fila'];
            $dados->prazo_dias = $registro['prazo_dias'];
            $dados->prazo_segundos = $registro['prazo_segundos'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getTotaisPrazo()
    {
        $sql = 'SELECT fila, 
                   SUM(CASE WHEN atraso > 0 THEN atraso ELSE 0 END) AS total_atraso,  -- Soma dos atrasos
                   COUNT(CASE WHEN atraso > 0 THEN 1 END) AS atraso_count,               -- Contagem de registros com atraso
                   COUNT(CASE WHEN atraso = 0 THEN 1 END) AS no_atraso_count            -- Contagem de registros sem atraso
            FROM sla_regulacao WHERE autorizado IS NULL
            GROUP BY fila';

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new stdClass;
            $dados->fila = $registro['fila'];  // Nome da fila
            $dados->total_atraso = $registro['total_atraso'];  // Soma dos dias de atraso
            $dados->atraso_count = $registro['atraso_count'];  // Quantidade de registros com atraso
            $dados->no_atraso_count = $registro['no_atraso_count'];  // Quantidade de registros sem atraso
            $array_dados[] = $dados;
        }

        return $array_dados;
    }
    function getTotaisPrazoZerado($listaFilas = "")	// Lista de filas a serem excluídas
    {   
        $array_dados = array();
        if($listaFilas != "") {
            $sql = "SELECT DISTINCT fila, autorizado FROM sla_regulacao WHERE fila NOT IN(".$listaFilas.")   ORDER BY fila";
            $resultado = $this->db->Execute($sql);
            
            while ($registro = $resultado->fetchRow()) {
                $dados = new stdClass;
                $dados->fila = $registro['fila'];  // Nome da fila
                $dados->total_atraso = 0;  // Soma dos dias de atraso
                $dados->atraso_count = 0;  // Quantidade de registros com atraso
                $dados->no_atraso_count = 0;  // Quantidade de registros sem atraso
                $array_dados[] = $dados;
            }
        }
        return $array_dados;
    }

    function getTotalGuias()
    {
        $sql = "SELECT COUNT(*) as total FROM sla_regulacao  WHERE autorizado IS NULL";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            return $registro['total'];
        }
        return 0;
    }
    function getPrazoGuia($tipo_guia, $fila)
    {
        $sql = "SELECT p.prazo_segundos FROM sla_prazo as p WHERE p.tipo_guia = '" . $tipo_guia . "' AND p.fila = '" . $fila . "'";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            return $registro['prazo_segundos'];
        }
        return 0;
    }


    function getTotaisAtraso()
    {
        $sql = 'SELECT 
        COUNT(CASE WHEN atraso = 0 THEN 1 END) as atraso_0,  -- Contagem dos registros sem atraso
        COUNT(CASE WHEN atraso > 0 THEN 1 END) as atraso_1,  -- Contagem dos registros com atraso
        SUM(CASE WHEN atraso > 0 THEN atraso ELSE 0 END) as total_atraso  -- Soma dos dias de atraso
        FROM sla_regulacao 
        WHERE atraso >= 0 AND autorizado IS NULL';  // Considera todos os registros onde atraso é maior ou igual a zero

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        if ($registro = $resultado->fetchRow()) {
            return array(
                'atraso_0' => $registro['atraso_0'],      // Registros sem atraso
                'atraso_1' => $registro['atraso_1'],      // Registros com atraso
                'total_atraso' => $registro['total_atraso']  // Total de dias de atraso
            );
        }

        return 0;
    }
    function getAutorizados() {
        $sql = "SELECT autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado FROM  sla_regulacao where autorizado is not null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao                 = $registro['autorizacao'];
            $dados->tipo_guia                   = $registro['tipo_guia'];
            $dados->area                        = $registro['area'];
            $dados->fila                        = $registro['fila'];
            $dados->encaminhamento_manual       = $registro['encaminhamento_manual'];
            $dados->data_solicitacao_d          = $registro['data_solicitacao_d'];
            $dados->atraso                      = $registro['atraso'];
            $dados->autorizado                  = $registro['autorizado'];
            $array_dados[]                      =  $dados;                                                
        }
        return $array_dados;
    }

    function getNaoAutorizados() {
        $sql = "SELECT autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado FROM  sla_regulacao where autorizado is null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaRegulacao();
            $dados->autorizacao                 = $registro['autorizacao'];
            $dados->tipo_guia                   = $registro['tipo_guia'];
            $dados->area                        = $registro['area'];
            $dados->fila                        = $registro['fila'];
            $dados->encaminhamento_manual       = $registro['encaminhamento_manual'];
            $dados->data_solicitacao_d          = $registro['data_solicitacao_d'];
            $dados->atraso                      = $registro['atraso'];
            $dados->autorizado                  = $registro['autorizado'];
            $array_dados[]                      =  $dados;                                                
        }
        return $array_dados;
    }

    function atualizaAtraso($autorizacao, $tempo)
    {
        $sql = "UPDATE sla_regulacao SET atraso = " . $tempo . " WHERE autorizacao=" . $autorizacao;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atualizaAutorizados()
    {
        $sql_count = "SELECT COUNT(*) as total FROM sla_regulacao_tmp";
        $rs = $this->db->Execute($sql_count);
        $processa = false;
        if ($registro = $rs->fetchRow()) {
            if ($registro['total'] > 0) {
                $processa = true;
            }
        }
        if ($processa) {
            $sql = 'UPDATE sla_regulacao SET sla_regulacao.autorizado = NOW() WHERE sla_regulacao.autorizacao IS NULL AND sla_regulacao.autorizacao NOT IN (SELECT sla_regulacao_tmp.autorizacao  FROM sla_regulacao_tmp  WHERE sla_regulacao_tmp.autorizacao IS NOT NULL)';
            $resultado = $this->db->Execute($sql);
            return $resultado;
        }
        return false;
    }
    function atualizaNovosSla()
    {
        $sql = 'INSERT INTO sla_regulacao ( autorizacao, tipo_guia, area, fila, encaminhamento_manual, data_solicitacao_t, data_solicitacao_d, atraso, autorizado) (SELECT * FROM sla_regulacao_tmp as srt WHERE srt.autorizacao NOT IN (select autorizacao from sla_regulacao))';
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function registraAtualizacao($id) {
        $sql = "INSERT INTO sla_atualizacao (atualizacao, id_usuario)  VALUES (NOW(), $id)";
        $resultado = $this->db->Execute($sql);
        if($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }

    function getUltimaAtualizacao() {
        $sql = "SELECT a.atualizacao, a.id_usuario, u.nome, u.id FROM sla_atualizacao as a, usuario as u WHERE a.id = (SELECT MAX(id) FROM sla_atualizacao) AND a.id_usuario = u.id";
        $resultado = $this->db->Execute($sql);
        if($registro = $resultado->fetchRow()) {
            $atualizacao = $registro['atualizacao'];
            $nome = $registro['nome'];
            return array('atualizacao' => $atualizacao, 'nome' => $nome);
        } else {
            return false;
        }
    }

    function limpaSlaTemporaria()
    {
        $sql = 'DELETE FROM sla_regulacao_tmp';
        $resultado = $this->db->Execute($sql);
        return $resultado;
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

    function calcularDataPascoa($ano)
    {
        $a = $ano % 19;
        $b = floor($ano / 100);
        $c = $ano % 100;
        $d = floor($b / 4);
        $e = $b % 4;
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return mktime(0, 0, 0, $month, $day, $ano);
    }
    function getListaDiasFeriado($ano = null)
    {

        if ($ano === null) {
            $ano = intval(date('Y'));
        }

        $pascoa = $this->calcularDataPascoa($ano); // retorna data da pascoa do ano especificado
        $diaPascoa = date('j', $pascoa);
        $mesPacoa = date('n', $pascoa);
        $anoPascoa = date('Y', $pascoa);

        $feriados = [
            // Feriados nacionais fixos
            mktime(0, 0, 0, 1, 1, $ano),   // Confraternização Universal
            mktime(0, 0, 0, 4, 21, $ano),  // Tiradentes
            mktime(0, 0, 0, 5, 1, $ano),   // Dia do Trabalhador
            mktime(0, 0, 0, 9, 7, $ano),   // Dia da Independência
            mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida
            mktime(0, 0, 0, 11, 2, $ano),  // Todos os santos
            mktime(0, 0, 0, 11, 15, $ano), // Proclamação da republica
            mktime(0, 0, 0, 12, 25, $ano), // Natal
            //
            // Feriados variaveis
            mktime(0, 0, 0, $mesPacoa, $diaPascoa - 48, $anoPascoa), // 2º feria Carnaval
            mktime(0, 0, 0, $mesPacoa, $diaPascoa - 47, $anoPascoa), // 3º feria Carnaval 
            mktime(0, 0, 0, $mesPacoa, $diaPascoa - 2, $anoPascoa),  // 6º feira Santa  
            mktime(0, 0, 0, $mesPacoa, $diaPascoa, $anoPascoa),      // Pascoa
            mktime(0, 0, 0, $mesPacoa, $diaPascoa + 60, $anoPascoa), // Corpus Christ
        ];

        sort($feriados);

        $listaDiasFeriado = [];
        foreach ($feriados as $feriado) {
            $data = date('Y-m-d', $feriado);
            $listaDiasFeriado[$data] = $data;
        }

        return $listaDiasFeriado;
    }

    function isFeriado($data)
    {
        $listaFeriado = $this->getListaDiasFeriado(date('Y', strtotime($data)));
        if (isset($listaFeriado[$data])) {
            return true;
        }

        return false;
    }

    function getDiasUteis($data_inicial, $data_final)
    {
        $dias_uteis = 0;

        // Enquanto a data inicial for menor ou igual à data final
        while ($data_inicial <= $data_final) {
            // Verifica se o dia é útil (não é sábado nem domingo)
            if (date('N', $data_inicial) <= 5) {  // 'N' retorna 1 para segunda-feira até 7 para domingo
                $dias_uteis++;
            }

            // Avançar para o próximo dia (em timestamp)
            $data_inicial = strtotime("+1 day", $data_inicial);
        }

        return $dias_uteis;
    }
}
