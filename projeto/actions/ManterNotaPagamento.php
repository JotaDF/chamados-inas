<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário padrão para São Paulo
require_once('Model.php'); // Importa a classe base Model
require_once('dto/NotaPagamento.php'); // Importa o DTO da Nota de Pagamento

class ManterNotaPagamento extends Model { // Classe que herda de Model

    function __construct() {
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar() {
        // Consulta todas as notas de pagamento, ordenadas por ID
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.doc_sei, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np order by np.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Inicializa o array para armazenar os objetos retornados

        while ($registro = $resultado->fetchRow()) { // Percorre os registros da consulta
            $dados = new NotaPagamento(); // Cria uma nova instância de NotaPagamento
            $dados->excluir = true; // Define como verdadeiro inicialmente
            if ($registro["dep"] > 0) { // Verifica se há dependência (campo "dep")
                $dados->excluir = false; // Se houver dependência, não pode excluir
            }
            // Atribui os valores do banco aos atributos do objeto NotaPagamento
            $dados->id              = $registro["id"];
            $dados->numero          = $registro["numero"];
            $dados->valor           = $registro["valor"];
            $dados->exercicio       = $registro["exercicio"];
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->data_emissao    = $registro["data_emissao"];
            $dados->data_validacao  = $registro["data_validacao"];
            $dados->data_executado  = $registro["data_executado"];
            $dados->data_atesto     = $registro["data_atesto"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->id_pagamento    = $registro["id_pagamento"];
            $dados->status          = $registro["status"];

            $array_dados[] = $dados; // Adiciona o objeto ao array de retorno
        }
        return $array_dados; // Retorna o array de objetos NotaPagamento
    }

    function listarNotaPorExercicio($exercicio) {
        // Consulta notas de pagamento com detalhes adicionais, filtrando por exercício
        $sql = "SELECT np.status, pr.cnpj, pr.razao_social,np.id, np.numero, np.valor, p.informativo, p.competencia, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, u.nome, np.data_pagamento, np.id_pagamento, np.doc_sei
        FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp, prestador as pr, usuario as u
        WHERE np.id_pagamento=p.id 
        AND p.id_fiscal_prestador = fp.id
        AND fp.id_prestador = pr.id
        AND u.id = fp.id_usuario
        AND np.exercicio = '".$exercicio."'"; // Filtra pelo exercício passado

        $resultado = $this->db->Execute($sql); // Executa a query
        $array_dados = array(); // Inicializa o array de retorno

        while ($registro = $resultado->fetchRow()) { // Percorre os registros
            $dados = new stdClass(); // Cria um objeto genérico (sem classe definida)
            $dados->excluir = true;
            // Atribui os dados do banco ao objeto
            $dados->id                   = $registro["id"];
            $dados->numero               = $registro["numero"];
            $dados->cnpj                 = $registro["cnpj"];
            $dados->razao_social         = $registro["razao_social"];
            $dados->informativo          = $registro["informativo"];
            $dados->competencia          = $registro["competencia"];
            $dados->nome                 = $registro["nome"];
            $dados->valor                = $registro["valor"];
            $dados->exercicio            = $registro["exercicio"];
            $dados->doc_sei              = $registro["doc_sei"];
            $dados->data_emissao         = $registro["data_emissao"];
            $dados->data_validacao       = $registro["data_validacao"];
            $dados->data_executado       = $registro["data_executado"];
            $dados->data_atesto          = $registro["data_atesto"];
            $dados->data_pagamento       = $registro["data_pagamento"];
            $dados->id_pagamento         = $registro["id_pagamento"];
            $dados->status               = $registro["status"];

            $array_dados[] = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna o array de objetos
    }

    function listarNotaPorFiltro($filtro) {
        // Consulta notas de pagamento aplicando um filtro adicional passado como parâmetro
        $sql = "SELECT np.status, pr.cnpj, pr.razao_social,np.id, np.numero, np.valor, p.informativo, p.competencia, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, u.nome, np.data_pagamento, np.id_pagamento, np.doc_sei, fp.id_prestador
        FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp, prestador as pr, usuario as u
        WHERE np.id_pagamento=p.id 
        AND p.id_fiscal_prestador = fp.id
        AND fp.id_prestador = pr.id
        AND u.id = fp.id_usuario" . $filtro; // Filtro é concatenado à consulta

        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Inicializa o array de retorno

        while ($registro = $resultado->fetchRow()) { // Percorre os resultados
            $dados = new stdClass(); // Cria objeto genérico
            $dados->tipo                 = 'nota'; // Define o tipo como "nota"
            $dados->id                   = $registro["id"];
            $dados->numero               = $registro["numero"];
            $dados->cnpj                 = $registro["cnpj"];
            $dados->id_prestador         = $registro['id_prestador'];
            $dados->razao_social         = $registro["razao_social"];
            $dados->informativo          = $registro["informativo"];
            $dados->competencia          = $registro["competencia"];
            $dados->nome                 = $registro["nome"];
            $dados->valor                = $registro["valor"];
            $dados->exercicio            = $registro["exercicio"];
            $dados->doc_sei              = $registro["doc_sei"];
            $dados->data_emissao         = $registro["data_emissao"];
            $dados->data_validacao       = $registro["data_validacao"];
            $dados->data_executado       = $registro["data_executado"];
            $dados->data_atesto          = $registro["data_atesto"];
            $dados->data_pagamento       = $registro["data_pagamento"];
            $dados->id_pagamento         = $registro["id_pagamento"];
            $dados->status               = $registro["status"];

            $array_dados[] = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna os dados encontrados
    }

    function getNotaPagamentoPorId($id) {
        // Busca uma nota de pagamento específica pelo ID
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.doc_sei, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new NotaPagamento(); // Cria um novo objeto NotaPagamento

        while ($registro = $resultado->fetchRow()) { // Se encontrou registro
            // Preenche os atributos com os dados do banco
            $dados->id              = $registro["id"];
            $dados->numero          = $registro["numero"];
            $dados->valor           = $registro["valor"];
            $dados->exercicio       = $registro["exercicio"];
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->data_emissao    = $registro["data_emissao"];
            $dados->data_validacao  = $registro["data_validacao"];
            $dados->data_executado  = $registro["data_executado"];
            $dados->data_atesto     = $registro["data_atesto"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->status          = $registro["status"];
            $dados->id_pagamento    = $registro["id_pagamento"];
        }
        return $dados; // Retorna o objeto preenchido
    }

    // Função que verifica se uma nota com determinado número já foi registrada por um prestador específico
function verificaNotaPorPrestador($id_prestador, $numero) {
    // Consulta que busca a nota com o número e prestador informados
    $sql = "select np.id, np.numero FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp 
            WHERE np.id_pagamento = p.id AND p.id_fiscal_prestador=fp.id AND fp.id_prestador=".$id_prestador." AND np.numero='".$numero."'" ;
    
    // Executa a consulta no banco
    $resultado = $this->db->Execute($sql);
    $resp = 0;

    // Se encontrou algum registro, define resposta como 1
    while ($registro = $resultado->fetchRow()) {
        $resp = 1;
    }

    // Retorna se a nota já existe (1) ou não (0)
    return $resp;
}

// Função para inserir ou atualizar uma nota de pagamento
function salvar(NotaPagamento $dados) {
    // Se for novo (sem ID), insere
    $sql = "insert into nota_pagamento (numero, valor, exercicio, data_emissao, data_validacao, id_pagamento, status) 
    values ('" . $dados->numero . "','" . $dados->valor . "','" . $dados->exercicio . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','" . $dados->pagamento . "','Em análise')";

    // Se já tiver ID, atualiza os dados existentes
    if ($dados->id > 0) {
        $sql = "update nota_pagamento set numero='" . $dados->numero . "', valor='" . $dados->valor . "', exercicio='" . $dados->exercicio
         . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "', id_pagamento='" . $dados->pagamento . "' where id=" . $dados->id;
        $resultado = $this->db->Execute($sql);
    } else {
        $resultado = $this->db->Execute($sql);
        $dados->id = $this->db->insert_Id(); // Recupera ID inserido
    }

    // Retorna resultado da execução
    return $resultado;
}

// Função para excluir uma nota de pagamento pelo ID
function excluir($id) {
    $sql = "delete from nota_pagamento where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Marca nota como "Executado" com data atual
function executar($id) {
    $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y")); // Data atual como timestamp
    $sql = "update nota_pagamento set data_executado=". $timestamp.", status='Executado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Reverte o status de "Executado" para "Em análise"
function reverterExecucao($id) {
    $sql = "update nota_pagamento set data_executado=null, status='Em análise' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Reverte o status de "Atestado" para "Executado"
function reverterAtesto($id) {
    $sql = "update nota_pagamento set data_atesto=null, status='Executado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Reverte o status de "Pago" para "Atestado"
function reverterPagamento($id) {
    $sql = "update nota_pagamento set data_pagamento=null, doc_sei=null, status='Atestado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Marca a nota como "Atestado" com data atual
function atestar($id) {
    $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y")); // Data atual
    $sql = "update nota_pagamento set data_atesto=". $timestamp.", status='Atestado' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Atesta um conjunto de notas (em lote)
function atestarLote($lista) {
    $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
    $sql = "update nota_pagamento set data_atesto=". $timestamp.", status='Atestado' where id IN (" . $lista . ")";
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Marca a nota como "Pago", adicionando data e documento SEI
function pagar($id, $data, $doc_sei) {
    $sql = "update nota_pagamento set data_pagamento=". $data.", doc_sei='".$doc_sei."', status='Pago' where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Retorna notas atestadas e ainda não pagas do prestador
function getPagamentosPentendesPrestador($id_prestador) {
    $sql = "SELECT np.id, np.numero, np.valor, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento
            FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp 
            WHERE np.id_pagamento=p.id 
            AND p.id_fiscal_prestador = fp.id
            AND fp.id_prestador = ".$id_prestador."
            AND np.data_atesto is not null
            AND np.data_pagamento is null";

    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    // Percorre cada nota encontrada
    while ($registro = $resultado->fetchRow()) {
        $dados = new NotaPagamento();
        $dados->excluir = true;
        if ($registro["dep"] > 0) {
            $dados->excluir = false;
        }
        // Atribui os valores do banco ao objeto NotaPagamento
        $dados->id              = $registro["id"];
        $dados->numero          = $registro["numero"];
        $dados->valor           = $registro["valor"];
        $dados->exercicio       = $registro["exercicio"];
        $dados->data_emissao    = $registro["data_emissao"];
        $dados->data_validacao  = $registro["data_validacao"];
        $dados->data_executado  = $registro["data_executado"];
        $dados->data_atesto     = $registro["data_atesto"];
        $dados->data_pagamento  = $registro["data_pagamento"];
        $dados->id_pagamento    = $registro["id_pagamento"];
        $dados->status = $registro["status"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

// Retorna notas executadas e ainda não atestadas do prestador
function getAtestosPentendesPrestador($id_prestador) {
    $sql = "SELECT np.id, np.numero, np.valor, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento
            FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp 
            WHERE np.id_pagamento=p.id 
            AND p.id_fiscal_prestador = fp.id
            AND fp.id_prestador = ".$id_prestador."
            AND np.data_executado is not null
            AND np.data_atesto is null";

    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    // Monta array de objetos NotaPagamento
    while ($registro = $resultado->fetchRow()) {
        $dados = new NotaPagamento();
        $dados->excluir = true;
        if ($registro["dep"] > 0) {
            $dados->excluir = false;
        }
        $dados->id              = $registro["id"];
        $dados->numero          = $registro["numero"];
        $dados->valor           = $registro["valor"];
        $dados->exercicio       = $registro["exercicio"];
        $dados->data_emissao    = $registro["data_emissao"];
        $dados->data_validacao  = $registro["data_validacao"];
        $dados->data_executado  = $registro["data_executado"];
        $dados->data_atesto     = $registro["data_atesto"];
        $dados->data_pagamento  = $registro["data_pagamento"];
        $dados->id_pagamento    = $registro["id_pagamento"];
        $dados->status = $registro["status"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

// Retorna notas ainda não executadas do prestador
    function getExecucaoPentendesPrestador($id_prestador) {
        $sql = "SELECT np.id, np.numero, np.valor, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento
            FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp 
            WHERE np.id_pagamento=p.id 
            AND p.id_fiscal_prestador = fp.id
            AND fp.id_prestador = ".$id_prestador."
            AND np.data_executado is null";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new NotaPagamento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id              = $registro["id"];
            $dados->numero          = $registro["numero"];
            $dados->valor           = $registro["valor"];
            $dados->exercicio       = $registro["exercicio"];
            $dados->data_emissao    = $registro["data_emissao"];
            $dados->data_validacao  = $registro["data_validacao"];
            $dados->data_executado  = $registro["data_executado"];
            $dados->data_atesto     = $registro["data_atesto"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->id_pagamento    = $registro["id_pagamento"];
            $dados->status = $registro["status"];

            $array_dados[] = $dados;
        }

        return $array_dados;
    }
}