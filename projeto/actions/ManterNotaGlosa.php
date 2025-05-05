<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para São Paulo
require_once('Model.php'); // Inclui o arquivo com a classe Model (provavelmente o acesso ao banco)
require_once('dto/NotaGlosa.php'); // Inclui a definição da classe NotaGlosa
require_once('dto/CartaRecurso.php'); // Inclui a definição da classe CartaRecurso

Class ManterNotaGlosa extends Model {

    function __construct() { // Construtor da classe que chama o construtor da classe pai
        parent::__construct();
    }

    function listar() {
        // SQL para buscar todas as notas de glosa com contagem de cartas relacionadas
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.doc_sei, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.status, (select count(*) from carta_recurso as cr where cr.id_nota_glosa = ng.id) as dep from nota_glosa as ng order by id";
        $resultado = $this->db->Execute($sql); // Executa a query
        $array_dados = array(); // Inicializa array de retorno
        while ($registro = $resultado->fetchrow()) { // Itera pelos resultados
            $dados = new NotaGlosa(); // Cria um novo objeto NotaGlosa
            $dados->excluir = true; // Flag que pode ser usada para controle de exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false; // Se houver dependência (cartas), não pode excluir
            }
            // Atribui os valores retornados do banco aos atributos do objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->exercicio = $registro["exercicio"];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];

            $array_dados[] = $dados; // Adiciona ao array final
        }
        return $array_dados; // Retorna array de objetos NotaGlosa
    }

    function getNotaGlosaPorId($id) {
        // Busca uma nota de glosa pelo ID
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.doc_sei, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.status from nota_glosa as ng WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new NotaGlosa(); // Instancia a DTO
        while ($registro = $resultado->fetchrow()) {
            // Atribui os dados ao objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->exercicio = $registro["exercicio"];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
        }
        return $dados; // Retorna objeto NotaGlosa
    }

    function getCartasPorNotaGlosa($id) {
        // Busca todas as cartas relacionadas a uma nota de glosa
        $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
                FROM  carta_recurso as cr 
                WHERE cr.id_nota_glosa = " . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new CartaRecurso(); // Cria nova instância da DTO
            $dados->id = $registro["id"];
            $dados->carta_informativo = $registro["carta_informativo"]; // Este campo não está na consulta (possível erro)
            $dados->exercicio = $registro["exercicio"];
            $dados->valor_deferido = $registro["valor_deferido"];
            $dados->id_nota_glosa = $registro["id_nota_glosa"];
            $dados->exercicio = $registro["exercicio"];
            $array_dados[] = $dados;
        }
        return $array_dados; // Retorna array de objetos CartaRecurso
    }

    function salvar(NotaGlosa $dados) {
        // Insere ou atualiza uma nota de glosa
        $sql = "insert into nota_glosa (numero, lote, valor, exercicio, data_emissao, data_validacao, id_recurso_glosa, status) 
        values ('" . $dados->numero . "','" . $dados->lote . "','" . $dados->valor . "','" . $dados->exercicio . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','" . $dados->id_recurso_glosa . "','Em análise')";
        
        if ($dados->id > 0) { // Se já existe, atualiza
            $sql = "update nota_glosa set numero='" . $dados->numero . "', lote='" . $dados->lote . "', valor='" . $dados->valor . "', exercicio='" . $dados->exercicio
             . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "', id_recurso_glosa='" . $dados->id_recurso_glosa . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql); // Insere novo registro
            $dados->id = $this->db->insert_Id(); // Recupera o ID inserido
        }
        return $dados; // Retorna o objeto com o ID atualizado
    }

    function excluir($id) {
        // Exclui nota de glosa pelo ID
        $sql = "delete from nota_glosa where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function executar($id) {
        // Marca a nota como executada com data atual
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_executado=". $timestamp.", status='Executado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function reverterExecucao($id) {
        // Reverte a execução da nota
        $sql = "update nota_glosa set data_executado=null, status='Em análise' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function atestar($id) {
        // Atesta a nota com data atual
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_atesto=". $timestamp.", status='Atestado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function atestarLote($lista) {
        // Atesta um lote de notas
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_atesto=". $timestamp.", status='Atestado' where id IN (" . $lista . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function pagar($id, $data, $doc_sei) {
        // Registra o pagamento da nota
        $sql = "update nota_glosa set data_pagamento=". $data.", doc_sei='".$doc_sei."', status='Pago' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function getPagamentosPentendesPrestador($id_prestador) {
        // Lista notas atestadas e ainda não pagas para um prestador
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.status, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.id_recurso_glosa
                FROM nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador."
                AND ng.data_atesto is not null
                AND ng.data_pagamento is null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            // Atribui dados ao objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->exercicio = $registro["exercicio"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getAtestosPentendesPrestador($id_prestador) {
        // Lista notas executadas e não atestadas
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.status, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.id_recurso_glosa
                FROM nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador." 
                AND ng.data_executado is not null
                AND ng.data_atesto is null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->exercicio = $registro["exercicio"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getExecucaoPentendesPrestador($id_prestador) {
        // Lista notas ainda não executadas
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.status, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.id_recurso_glosa
                FROM nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador." 
                AND ng.data_executado is null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->exercicio = $registro["exercicio"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
}
