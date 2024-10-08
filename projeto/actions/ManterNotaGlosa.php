<?php
date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');
require_once('dto/NotaGlosa.php');
require_once('dto/CartaRecurso.php');


Class ManterNotaGlosa extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }   

    function listar() {
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao (select count(*) from carta_recurso as cr where cr.id_nota_glosa = ng.id) as dep from nota_glosa as ng order by id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
            $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];            

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getNotaGlosaPorId($id) {
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao from nota_glosa as ng WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new NotaGlosa();
        while ($registro = $resultado->fetchrow()) {   
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
            $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];            
        }
        return $dados;
    }
    function getCartasPorNotaGlosa($id) {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.valor_deferido, cr.id_nota_glosa
                FROM  carta_recurso as cr 
                WHERE cr.id_nota_glosa = " . $id;

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new CartaRecurso();
            $dados->id                     = $registro["id"];
            $dados->carta_informativo      = $registro["carta_informativo"];
            $dados->exercicio              = $registro["exercicio"];
            $dados->valor_deferido         = $registro["valor_deferido"];
            $dados->id_nota_glosa          = $registro["id_nota_glosa"];
            $dados->exercicio              = $registro["exercicio"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function salvar(NotaGlosa $dados) {
        $sql = "insert into nota_glosa (numero, lote, valor, exercicio, data_emissao, data_validacao, id_recurso_glosa, status) 
        values ('" . $dados->numero . "','" . $dados->lote . "','" . $dados->valor . "','" . $dados->exercicio . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','" . $dados->id_recurso_glosa . "','Em análise')";
        if ($dados->id > 0) {
            $sql = "update nota_glosa set numero='" . $dados->numero . "', lote='" . $dados->lote . "', valor='" . $dados->valor . "', exercicio='" . $dados->exercicio
             . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "', id_recurso_glosa='" . $dados->id_recurso_glosa . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }

    function excluir($id) {
        $sql = "delete from nota_glosa where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function executar($id) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_executado=". $timestamp.", status='Executado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function reverterExecucao($id) {
        $sql = "update nota_glosa set data_executado=null, status='Em análise' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestar($id) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_atesto=". $timestamp.", status='Atestado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestarLote($lista) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update nota_glosa set data_atesto=". $timestamp.", status='Atestado' where id IN (" . $lista . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function pagar($id, $data, $doc_sei) {
        $sql = "update nota_glosa set data_pagamento=". $data.", doc_sei='".$doc_sei."', status='Pago' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getPagamentosPentendesPrestador($id_prestador) {
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
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
            $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];            

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getAtestosPentendesPrestador($id_prestador) {
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
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
            $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];            

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getExecucaoPentendesPrestador($id_prestador) {
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
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
            $dados->id_recurso_glosa    = $registro["id_recurso_glosa"];            

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
}
