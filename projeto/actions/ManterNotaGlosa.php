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
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.doc_sei, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.status, (select count(*) from carta_recurso as cr where cr.id_nota_glosa = ng.id) as dep from nota_glosa as ng order by id";
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
            $dados->doc_sei             = $registro["doc_sei"];
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
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.doc_sei, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao, ng.status from nota_glosa as ng WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new NotaGlosa();
        while ($registro = $resultado->fetchrow()) {   
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor               = $registro["valor"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->doc_sei             = $registro["doc_sei"];
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
        $sql = "SELECT cr.id, cr.carta_informativo, cr.valor_deferido, cr.status, cr.id_nota_glosa, cr.exercicio, cr.competencia, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.doc_sei
                FROM  carta_recurso as cr 
                WHERE cr.id_nota_glosa = " . $id;

        $resultado = $this->db->Execute($sql);
        $array_dados = array(); 
        while ($registro = $resultado->fetchrow()) {
            $dados = new CartaRecurso();
            $dados->id                     = $registro["id"];
            $dados->carta_informativo      = $registro["carta_informativo"];
            $dados->exercicio              = $registro["exercicio"];
            $dados->competencia            = $registro["competencia"];
            $dados->valor_deferido         = $registro["valor_deferido"];
            $dados->id_nota_glosa          = $registro["id_nota_glosa"];
	        $dados->doc_sei             = $registro["doc_sei"];
            $dados->data_emissao        = $registro["data_emissao"];
            $dados->data_validacao      = $registro["data_validacao"];
            $dados->data_executado      = $registro["data_executado"];
            $dados->data_atesto         = $registro["data_atesto"];
            $dados->data_pagamento      = $registro["data_pagamento"];
            $dados->status              = $registro["status"];
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
    function getMaioresValoresNotaGlosaPorCompetencia($ano) {
        $sql = "SELECT cr.competencia, SUM(CAST(REPLACE(REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2))) AS valor_real, ROUND(SUM(CAST(REPLACE(REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2))), 0) AS valor_para_dashboard 
        FROM prestador p, fiscal_prestador fp, nota_glosa as ng, carta_recursada_glosa as crg, carta_recurso as cr, tipo_prestador as tp WHERE p.id_tipo_prestador = tp.id AND tp.id != '12' AND p.id = fp.id_prestador AND fp.id = crg.id_fiscal_prestador AND crg.id = ng.id_recurso_glosa AND ng.id = cr.id_nota_glosa AND cr.data_pagamento IS NOT NULL AND TRIM(cr.competencia) LIKE '%".$ano."' GROUP BY cr.competencia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new stdClass();
            $dados->valor = $registro['valor_para_dashboard'];
            $dados->valor_real = $registro['valor_real'];
            $dados->competencia = $registro['competencia'];
            $array_dados[]  = $dados;
        }
        return $array_dados;
    }
    function getMaioresValoresNotaGlosaPorCompetenciaAdm($ano) {
        $sql = "SELECT cr.competencia, SUM(CAST(REPLACE(REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2))) AS valor_real, ROUND(SUM(CAST(REPLACE(REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2))), 0) AS valor_para_dashboard 
        FROM prestador p, fiscal_prestador fp, nota_glosa as ng, carta_recursada_glosa as crg, carta_recurso as cr, tipo_prestador as tp WHERE p.id_tipo_prestador = tp.id AND tp.id != '12' AND p.id = fp.id_prestador AND fp.id = crg.id_fiscal_prestador AND crg.id = ng.id_recurso_glosa AND ng.id = cr.id_nota_glosa AND cr.data_pagamento IS NOT NULL AND TRIM(cr.competencia) LIKE '%".$ano."' GROUP BY cr.competencia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new stdClass();
            $dados->valor = $registro['valor_para_dashboard'];
            $dados->valor_real = $registro['valor_real'];
            $dados->competencia = $registro['competencia'];
            $array_dados[]  = $dados;
        }
        return $array_dados;
    }
    function getNotaGlosaTodasCompetencias($anos_competencia) {
        $prestadores = $this->getMaioresValoresNotaGlosaPorCompetencia($anos_competencia);
        $lista_final = [];
        $soma_anual = 0;

        foreach ($prestadores as $p) {
            // Acumulamos os dados em um array
            $lista_final[] = [
                'valor' => $p->valor,
                'competencia' => $p->competencia,
                'razao_social' => $p->razao_social // Importante para o gráfico
            ];
            // Se o seu objeto já traz o total do mês, podemos usar para o total anual
            $soma_anual += (float) $p->valor;
        }

        $dados = [
            'dados' => $lista_final,
            'total' => $soma_anual
        ];
        return $dados;
    }
    function getNotaGlosaTodasCompetenciasAdm($anos_competencia) {
        $prestadores = $this->getMaioresValoresNotaGlosaPorCompetenciaAdm($anos_competencia);
        $lista_final = [];
        $soma_anual = 0;

        foreach ($prestadores as $p) {
            // Acumulamos os dados em um array
            $lista_final[] = [
                'valor' => $p->valor,
                'competencia' => $p->competencia,
                'razao_social' => $p->razao_social // Importante para o gráfico
            ];
            // Se o seu objeto já traz o total do mês, podemos usar para o total anual
            $soma_anual += (float) $p->valor;
        }

        $dados = [
            'dados' => $lista_final,
            'total' => $soma_anual
        ];
        return $dados;
    }

    function getPrestadoresMaioresValoresPorCompetencia($competencia = "", $limit = 5) {
        $sql = "SELECT p.razao_social, ng.valor, cr.competencia FROM prestador p, fiscal_prestador fp, nota_glosa as ng, tipo_prestador as tp, carta_recursada_glosa as crg, carta_recurso as cr 
        WHERE p.id_tipo_prestador = tp.id AND tp.id != '12' AND p.id = fp.id_prestador AND fp.id = crg.id_fiscal_prestador AND crg.id = ng.id_recurso_glosa AND ng.id = cr.id_nota_glosa AND cr.competencia = '".$competencia."' ORDER BY CAST( REPLACE( REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2)) DESC LIMIT $limit";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()){
            $dados = new stdClass();
            $dados->razao_social  = strtoupper($registro["razao_social"]);
            $dados->valor         = $registro["valor"];
            $dados->competencia   = $registro["competencia"];
            $array_dados[]        = $dados;
        }
        return $array_dados;
    }
    function getPrestadoresMaioresValoresPorCompetenciaAdm($competencia = "", $limit = 5) {
        $sql = "SELECT p.razao_social, ng.valor, cr.competencia FROM prestador p, fiscal_prestador fp, nota_glosa as ng, tipo_prestador as tp, carta_recursada_glosa as crg, carta_recurso as cr 
        WHERE p.id_tipo_prestador = tp.id AND tp.id != '12' AND p.id = fp.id_prestador AND fp.id = crg.id_fiscal_prestador AND crg.id = ng.id_recurso_glosa AND ng.id = cr.id_nota_glosa AND cr.competencia = '".$competencia."' ORDER BY CAST( REPLACE( REGEXP_REPLACE(ng.valor, '[^0-9,]', ''), ',', '.') AS DECIMAL(15,2)) DESC LIMIT $limit";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()){
            $dados = new stdClass();
            $dados->razao_social  = strtoupper($registro["razao_social"]);
            $dados->valor         = $registro["valor"];
            $dados->competencia   = $registro["competencia"];
            $array_dados[]        = $dados;
        }
        return $array_dados;
    }

    function getDadosPrestadoresNotaGlosa($quantidade_exibicao, $competencia){
        $total = $this->getMaioresValoresNotaGlosaPorCompetencia($competencia)[0]->valor_real;
        $dados = [
            'dados' => $this->getPrestadoresMaioresValoresPorCompetencia($competencia, $quantidade_exibicao),
            'total' => $total
        ];
        return $dados;
    }
    function getDadosPrestadoresNotaGlosaAdm($quantidade_exibicao, $competencia){
        $total = $this->getMaioresValoresNotaGlosaPorCompetenciaAdm($competencia)[0]->valor_real;
        $dados = [
            'dados' => $this->getPrestadoresMaioresValoresPorCompetenciaAdm($competencia, $quantidade_exibicao),
            'total' => $total
        ];
        return $dados;
    }
}
