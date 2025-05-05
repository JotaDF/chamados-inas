<?php 

require_once ('actions/Model.php');
require_once ('dto/CartaRecurso.php');

// Classe que herda da classe Model, responsável por manter as operações relacionadas à "Carta Recurso"
Class ManterCartaRecurso extends Model {

    // Construtor que chama o construtor da classe base
    function __construct() {
        parent::__construct(); // Chama o construtor da classe Model
    }

    // Função para listar todas as cartas de recurso
    function listar () {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.competencia, cr.valor_deferido, cr.doc_sei, cr.id_nota_glosa, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.status from carta_recurso as cr";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Cria um array para armazenar os resultados
        // Itera sobre os registros retornados pela consulta
        while($registro = $resultado->fetchRow()) {
            // Cria um objeto CartaRecurso e preenche os dados
            $dados = new CartaRecurso();
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->competencia = $registro['competencia'];
            $dados->valor_deferido = $registro['valor_deferido'];
            $dados->id_nota_glosa = $registro['id_nota_glosa'];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            // Adiciona o objeto à lista de resultados
            $array_dados[] = $dados;
        }
        return $array_dados; // Retorna a lista de cartas de recurso
    }

    // Função para listar os exercícios distintos (anos) encontrados nas cartas de recurso
    function listarExercicio () {
        $sql = 'SELECT DISTINCT TMP.* FROM (SELECT DISTINCT cr.exercicio FROM carta_recurso as cr UNION SELECT DISTINCT p.exercicio FROM nota_pagamento as p ) TMP ORDER BY exercicio DESC';
        $resultado = $this->db->Execute($sql);
        if($resultado) {
            $anos = []; // Cria um array para armazenar os anos
            while ($registro = $resultado->fetchRow()) {
                $anos[] = $registro['exercicio']; // Adiciona o ano ao array
            }
        }
        return $anos; // Retorna os anos encontrados
    }

    // Função para listar as cartas de recurso para um exercício específico
    function listarCartaPorExercicio($exercicio) {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.status, cr.exercicio, cr.competencia, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.id_nota_glosa, cr.doc_sei, ng.id, ng.numero, ng.valor, ng.id_recurso_glosa, crg.id, crg.id_fiscal_prestador, p.cnpj, p.razao_social, p.id, p.cnpj, u.nome FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp, prestador as p, usuario as u
        WHERE cr.id_nota_glosa = ng.id
        AND ng.id_recurso_glosa = crg.id 
        AND crg.id_fiscal_prestador = fp.id
        AND fp.id_prestador = p.id
        AND u.id = fp.id_usuario
        AND cr.exercicio = '".$exercicio."'"; // Filtra as cartas de recurso por exercício
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new stdClass; // Cria um objeto genérico para armazenar os dados
            $dados->informativo = $registro["carta_informativo"];
            $dados->status = $registro["status"];
            $dados->exercicio = $registro["exercicio"];
            $dados->competencia = $registro['competencia'];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->numero = $registro["numero"];
            $dados->valor = $registro["valor"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->nome = $registro["nome"];
            $array_dados[] = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna os dados das cartas de recurso para o exercício
    }

    // Função para listar as cartas de recurso com base em um filtro passado como parâmetro
    function listarCartaPorFiltro($filtro) {
        // Executa uma consulta SQL com o filtro passado
        $sql = "SELECT cr.id, cr.carta_informativo, cr.status, cr.competencia, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.id_nota_glosa, cr.doc_sei, ng.id, ng.numero, ng.valor, ng.id_recurso_glosa, crg.id, crg.id_fiscal_prestador, pr.cnpj,  pr.razao_social, pr.id, u.nome, fp.id_prestador 
        FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp, prestador as pr, usuario as u
        WHERE cr.id_nota_glosa = ng.id
        AND ng.id_recurso_glosa = crg.id 
        AND crg.id_fiscal_prestador = fp.id
        AND fp.id_prestador = pr.id
        AND u.id = fp.id_usuario" . $filtro; // Aplica o filtro à consulta
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new stdClass;
            $dados->tipo = 'carta'; // Define o tipo como 'carta'
            $dados->id_prestador = $registro["id_prestador"];
            $dados->informativo = $registro["carta_informativo"];
            $dados->status = $registro["status"];
            $dados->exercicio = $registro["exercicio"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->informativo = $registro["carta_informativo"];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->competencia = $registro['competencia'];
            $dados->numero = $registro["numero"];
            $dados->valor = $registro["valor"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->nome = $registro["nome"];
            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados
        }
        return $array_dados; // Retorna as cartas de recurso filtradas
    }

    // Função para obter o recurso associado a uma nota glosa
    function getRecursoPorNotaGlosa ($id) {
        $sql = "SELECT cr.id, cr.informativo, cr.valor_deferido, cr.exercicio, cr.competencia, cr.id_nota_glosa, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.status from  carta_recurso as cr inner join nota_glosa as ng where cr.id_nota_glosa = ng.id"; 
        $resultado = $this->db->Execute($sql);
        $dados = new CartaRecurso();
        while($registro = $resultado->fetchRow()) {
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->competencia = $registro['competencia'];
            $dados->valor_deferido = $registro['valor_deferido'];
            $dados->id_nota_glosa = $registro['id_nota_glosa'];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
        }
        return $dados; // Retorna os dados do recurso associado
    }

 // Função para salvar um objeto CartaRecurso no banco de dados
function salvar(CartaRecurso $dados) {
    // Verifica se o objeto CartaRecurso tem um ID, indicando que deve ser atualizado
    if ($dados->id > 0) {
        // Se o ID for maior que 0, realiza uma atualização de nota glosa
        $sql = "update nota_glosa set numero='" . $dados->carta_informativo . "', valor='" . $dados->valor_deferido . "', exercicio='" . $dados->valor_deferido . "', competencia='" . $dados->competencia
             . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "' where id=" . $dados->id;
        $resultado = $this->db->Execute($sql);
    } else {
        // Se não existir ID, insere uma nova carta de recurso na tabela
        $sql = "insert into carta_recurso (carta_informativo, exercicio, competencia, valor_deferido, id_nota_glosa, data_emissao, data_validacao, status) 
        values ('" . $dados->carta_informativo . "', '".$dados->exercicio."', '".$dados->competencia."', '" . $dados->valor_deferido . "','" . $dados->id_nota_glosa . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','Em análise')";
        $resultado = $this->db->Execute($sql);
        // Obtém o ID da última inserção e atribui ao objeto
        $dados->id = $this->db->insert_Id();
    }
    return $dados; // Retorna os dados do recurso associado
}

// Função para excluir uma carta de recurso do banco de dados
function excluir($id) {
    $sql = "delete from carta_recurso where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da exclusão
}

// Função para somar os valores deferidos por nota glosa
function somarValorDeferidoPorNota($id) {
    $sql = "SELECT SUM(valor_deferido) AS total FROM carta_recurso where id_nota_glosa =$id";
    $resultado = $this->db->Execute($sql);
    if ($resultado && $row = $resultado->FetchRow()) {
        return $row['total'] ?? 0; // Retorna a soma dos valores ou 0 se não houver resultado
    }
    return 0; // Caso não haja resultado, retorna 0
}

// Função para marcar a execução de uma carta de recurso
function executar($id) {
    $timestamp = mktime(0, 0, 0, date("m"), date("d"),  date("Y"));
    $sql = "update carta_recurso set data_executado=". $timestamp.", status='Executado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da execução
}

// Função para reverter a execução de uma carta de recurso
function reverterExecucao($id) {
    $sql = "update carta_recurso set data_executado=null, status='Em análise' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da reversão
}

// Função para reverter o atesto de uma carta de recurso
function reverterAtesto($id) {
    $sql = "update carta_recurso set data_atesto=null, status='Executado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da reversão do atesto
}

// Função para reverter o pagamento de uma carta de recurso
function reverterPagamento($id) {
    $sql = "update carta_recurso set data_pagamento=null, doc_sei=null, status='Atestado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da reversão do pagamento
}

// Função para atestar uma carta de recurso
function atestar($id) {
    $timestamp = mktime(0, 0, 0, date("m"), date("d"),  date("Y"));
    $sql = "update carta_recurso set data_atesto=". $timestamp.", status='Atestado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado do ateste
}

// Função para atestar um lote de cartas de recurso
function atestarLote($lista) {
    $timestamp = mktime(0, 0, 0, date("m"), date("d"),  date("Y"));
    $sql = "update carta_recurso set data_atesto=". $timestamp.", status='Atestado' where id IN (" . $lista . ")";
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado do ateste em lote
}

// Função para pagar uma carta de recurso
function pagar($id, $data, $doc_sei) {
    $sql = "update carta_recurso set data_pagamento=". $data.", doc_sei='".$doc_sei."', status='Pago' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado do pagamento
}

// Função para obter pagamentos pendentes de um prestador
function getPagamentosPentendesPrestador($id_prestador) {
    $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.competencia, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
                FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE cr.id_nota_glosa = ng.id
                AND ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador."
                AND cr.data_atesto is not null
                AND cr.data_pagamento is null";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchrow()) {
        // Cria um novo objeto CartaRecurso e atribui os valores retornados pelo banco
        $dados = new CartaRecurso();
        $dados->excluir = true;
        $dados->id                  = $registro["id"];
        $dados->numero              = $registro["numero"];
        $dados->lote                = $registro["lote"];
        $dados->valor_deferido      = $registro["valor_deferido"];
        $dados->exercicio           = $registro["exercicio"];
        $dados->competencia         = $registro["competencia"];
        $dados->data_emissao        = $registro["data_emissao"];
        $dados->data_validacao      = $registro["data_validacao"];
        $dados->data_executado      = $registro["data_executado"];
        $dados->data_atesto         = $registro["data_atesto"];
        $dados->data_pagamento      = $registro["data_pagamento"];
        $dados->status              = $registro["status"];
        $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];
        
        $array_dados[] = $dados;
    }
    return $array_dados; // Retorna os dados dos pagamentos pendentes
}

// Função para obter atestos pendentes de um prestador
function getAtestosPentendesPrestador($id_prestador) {
    $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.competencia, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
                FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE cr.id_nota_glosa = ng.id
                AND ng.id_recurso_glosa=crg.id
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador." 
                AND cr.data_executado is not null
                AND cr.data_atesto is null";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchrow()) {
        // Processa os dados de cada carta de recurso
        $dados = new CartaRecurso();
        $dados->excluir = true;
        $dados->id                  = $registro["id"];
        $dados->numero              = $registro["numero"];
        $dados->lote                = $registro["lote"];
        $dados->valor_deferido      = $registro["valor_deferido"];
        $dados->exercicio           = $registro["exercicio"];
        $dados->competencia         = $registro["competencia"];
        $dados->data_emissao        = $registro["data_emissao"];
        $dados->data_validacao      = $registro["data_validacao"];
        $dados->data_executado      = $registro["data_executado"];
        $dados->data_atesto         = $registro["data_atesto"];
        $dados->data_pagamento      = $registro["data_pagamento"];
        $dados->status              = $registro["status"];
        $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];
        
        $array_dados[] = $dados;
    }
    return $array_dados; // Retorna os dados dos atestos pendentes
}

// Função para obter execuções pendentes de um prestador
function getExecucaoPentendesPrestador($id_prestador) {
    $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.competencia, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
                FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE cr.id_nota_glosa = ng.id
                AND ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador." 
                AND cr.data_executado is null";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchrow()) {
        // Processa os dados de cada carta de recurso
        $dados = new CartaRecurso();
        $dados->excluir = true;
        $dados->id                  = $registro["id"];
        $dados->numero              = $registro["numero"];
        $dados->lote                = $registro["lote"];
        $dados->valor_deferido      = $registro["valor_deferido"];
        $dados->exercicio           = $registro["exercicio"];
        $dados->competencia         = $registro["competencia"];
        $dados->data_emissao        = $registro["data_emissao"];
        $dados->data_validacao      = $registro["data_validacao"];
        $dados->data_executado      = $registro["data_executado"];
        $dados->data_atesto         = $registro["data_atesto"];
        $dados->data_pagamento      = $registro["data_pagamento"];
        $dados->status              = $registro["status"];
        $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];
        
        $array_dados[] = $dados;
    }
    return $array_dados; // Retorna os dados das execuções pendentes
}

// Função para migrar dados de uma carta de recurso
function migrar(CartaRecurso $dados) {
    $sql = "update carta_recurso set data_emissao='". $dados->data_emissao."', data_validacao='". $dados->data_validacao."',
        data_executado='". $dados->data_executado."',data_atesto='". $dados->data_atesto."',data_pagamento='". $dados->data_pagamento."',
        doc_sei='".$dados->doc_sei."', status='".$dados->status."' where id_nota_glosa=" . $dados->id_nota_glosa;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da migração
}


}

