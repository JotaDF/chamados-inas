<?php

require_once('Model.php'); // Importa a classe base Model que contém conexão com o banco
require_once('dto/Processo.php'); // Importa o DTO (objeto de transferência de dados) Processo

class ManterProcesso extends Model // Classe responsável pela manipulação de dados da tabela "processo"
{

    function __construct()
    {
        parent::__construct(); // Chama o construtor da classe pai (Model), inicializando a conexão
    }

    function listar($filtro = "")
    {
        // Monta a query SQL para selecionar todos os dados da tabela "processo", aplicando um filtro opcional
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo $filtro ORDER BY autuacao";

        $resultado = $this->db->Execute($sql); // Executa a query no banco de dados
        $array_dados = array(); // Cria um array para armazenar os resultados

        // Percorre os registros retornados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Processo(); // Cria uma nova instância de Processo
            $dados->excluir = true; // Marca como "excluível"

            // Atribui os dados de cada campo retornado ao objeto Processo
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];

            $array_dados[] = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna todos os objetos Processo encontrados
    }

    function getProcessoPorId($id)
    {
        // Retorna um único processo com base no ID
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
                       data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo WHERE id=$id";

        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Processo(); // Cria novo DTO

        while ($registro = $resultado->fetchRow()) {
            // Preenche o DTO com os dados retornados
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];
        }
        return $dados; // Retorna o objeto com os dados do processo
    }

    function getProcessoPorNumero($numero)
    {
        // Busca processo pelo número
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
                       data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo WHERE numero=$numero";

        $resultado = $this->db->Execute($sql); // Executa a query
        $dados = new Processo(); // Cria DTO

        while ($registro = $resultado->fetchRow()) {
            // Preenche os dados do DTO
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];
        }
        return $dados;
    }

    function salvar(Processo $dados)
    {
        // Prepara os dados antes de montar a query de insert/update
        if ($dados->classe_judicial == "") $dados->classe_judicial = "null";
        if ($dados->liminar == "") {
            $dados->liminar = "null";
            $dados->data_cumprimento_liminar = 0;
        }
        if ($dados->data_cumprimento_liminar == "") $dados->data_cumprimento_liminar = 0;
        if ($dados->autor_inas == "") $dados->autor_inas = 0;

        // Query de inserção
        $sql = "insert into processo (...) values (...)";

        // Se já existe ID, executa update ao invés de insert
        if ($dados->id > 0) {
            $sql = "update processo set ... where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Recupera o ID do novo registro
        }
        return $resultado;
    }

    function excluir($id)
    {
        // Deleta um processo pelo ID
        $sql = "delete from processo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function relatorioTotalPorAssunto($ano = '0')
    {
        // Gera um relatório com total de processos por assunto, opcionalmente filtrado por ano
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }

        $sql = "SELECT a.id, a.assunto, 
               (SELECT COUNT(*) FROM processo as p WHERE p.id_assunto=a.id $filtro) as total 
               FROM assunto as a ORDER BY total;";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            if ($registro["total"] > 0) {
                $dados = new stdClass(); // Cria objeto genérico
                $dados->id = $registro["id"];
                $dados->assunto = $registro["assunto"];
                $dados->total = $registro["total"];
                $array_dados[] = $dados;
            }
        }
        return $array_dados;
    }

    function relatorioTotais($ano = '0')
    {
        // Gera totais gerais de processos por tipo de decisão e situação
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }

        $sql = "SELECT 
                ... 
                LIMIT 1"; // A query calcula os totais por tipo de liminar, arquivamento, danos morais e total

        $resultado = $this->db->Execute($sql);
        $dados = new stdClass();

        if ($registro = $resultado->fetchRow()) {
            // Preenche os dados retornados
            $dados->total_deferido = $registro["total_deferido"];
            $dados->total_indeferido = $registro["total_indeferido"];
            $dados->total_arquivado = $registro["total_arquivado"];
            $dados->total_danos_moraes = $registro["total_danos_moraes"];
            $dados->total_processos = $registro["total_processos"];
        }
        return $dados;
    }

    function getAnos()
    {
        // Retorna todos os anos com processos com liminar deferida ou indeferida
        $sql = "SELECT YEAR(FROM_UNIXTIME(p.autuacao)) AS ano 
                FROM processo AS p 
                WHERE p.id_liminar IN (1, 2) GROUP BY ano ORDER BY ano desc";

        $resultado = $this->db->Execute($sql);
        if ($resultado) {
            $anos = [];
            while ($row = $resultado->FetchRow()) {
                $anos[] = $row['ano']; // Armazena os anos no array
            }
        }
        return $anos;
    }

    function relatorioTotaisPorMes($ano = '0')
    {
        // Gera um total mensal de processos no ano selecionado
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }

        $sql = "SELECT 
                MONTH(FROM_UNIXTIME(p.autuacao)) AS mes,
                COUNT(*) AS total
                FROM processo AS p
                WHERE p.id_liminar IN (1, 2) " . $filtro . "
                GROUP BY mes
                ORDER BY mes";

        $resultado = $this->db->Execute($sql);
        $dados = array_fill(1, 12, 0); // Inicializa array com 12 meses

        while ($registro = $resultado->fetchRow()) {
            $dados[(int) $registro['mes']] = $registro['total']; // Atribui total ao mês correspondente
        }
        return $dados;
    }

    function relatoriosTotaisPorAno($anos)
    {
        // Gera relatório agrupado por ano e mês para os anos informados
        if (is_array($anos)) {
            $anos = implode(",", $anos); // Transforma array em string separada por vírgulas
        }

        $sql = "SELECT YEAR(FROM_UNIXTIME(p.autuacao)) AS ano, 
                   MONTH(FROM_UNIXTIME(p.autuacao)) AS mes, 
                   COUNT(*) AS total_processos 
                   FROM processo AS p 
                   WHERE p.id_liminar IN (1, 2) 
                   AND YEAR(FROM_UNIXTIME(p.autuacao)) IN ($anos) 
                   GROUP BY ano, mes 
                   ORDER BY ano, mes";

        $resultado = $this->db->Execute($sql);
        $totaisPorAno = [];

        while ($registro = $resultado->fetchRow()) {
            // Aqui continuaria preenchendo a estrutura $totaisPorAno[ano][mes] = total
        }
    }
}
