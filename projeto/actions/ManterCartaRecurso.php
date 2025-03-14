<?php 

require_once ('actions/Model.php');
require_once ('dto/CartaRecurso.php');

Class ManterCartaRecurso extends Model {

    function __construct() {
        parent::__construct();
    }


    function listar () {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.valor_deferido, cr.doc_sei, cr.id_nota_glosa, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.status from carta_recurso as cr";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new CartaRecurso();
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->valor_deferido =$registro['valor_deferido'];
            $dados->id_nota_glosa =$registro['id_nota_glosa'];
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

    function listarExercicio () {
        $sql = ('SELECT DISTINCT cr.exercicio FROM carta_recurso as cr order by cr.exercicio DESC');
        $resultado = $this->db->Execute($sql);
        if($resultado) {
            $anos = [];
            while ($registro = $resultado->fetchRow()) {
                $anos[] = $registro['exercicio'];
            }
        }
        return $anos;
    }

    function listarCartaPorExercicio($exercicio) {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.status, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.id_nota_glosa, cr.doc_sei, ng.id, ng.numero, ng.valor, ng.id_recurso_glosa, crg.id, crg.id_fiscal_prestador, p.cnpj, p.razao_social, p.id, p.cnpj, u.nome FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp, prestador as p, usuario as u
WHERE cr.id_nota_glosa = ng.id
AND ng.id_recurso_glosa = crg.id 
AND crg.id_fiscal_prestador = fp.id
AND fp.id_prestador = p.id
AND u.id = fp.id_usuario
AND cr.exercicio = '".$exercicio."'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new stdClass;
            $dados->informativo                 = $registro["carta_informativo"];
            $dados->status                      = $registro["status"];
            $dados->exercicio                   = $registro["exercicio"];
            $dados->data_emissao                = $registro["data_emissao"];
            $dados->data_validacao              = $registro["data_validacao"];
            $dados->data_executado              = $registro["data_executado"];
            $dados->data_atesto                 = $registro["data_atesto"];
            $dados->data_pagamento              = $registro["data_pagamento"];
            $dados->doc_sei                     = $registro["doc_sei"];
            $dados->numero                      = $registro["numero"];
            $dados->valor                       = $registro["valor"];
            $dados->cnpj                        = $registro["cnpj"];
            $dados->razao_social                = $registro["razao_social"];
            $dados->nome                        = $registro["nome"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getRecursoPorNotaGlosa ($id) {
        $sql = "SELECT cr.id, cr.informativo, cr.valor_deferido, cr.exercicio, cr.id_nota_glosa, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento, cr.status from  carta_recurso as cr inner join nota_glosa as ng where cr.id_nota_glosa = ng.id"; 
        $resultado = $this->db->Execute($sql);
        $dados = new CartaRecurso();
        while($registro = $resultado->fetchRow()) {
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->valor_deferido =$registro['valor_deferido'];
            $dados->id_nota_glosa =$registro['id_nota_glosa'];
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

    function salvar (CartaRecurso $dados) {
        $sql = "insert into carta_recurso (carta_informativo, exercicio, valor_deferido, id_nota_glosa, data_emissao, data_validacao, status) 
        values ('" . $dados->carta_informativo . "', '".$dados->exercicio."', '" . $dados->valor_deferido . "','" . $dados->id_nota_glosa . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','Em análise')";
        if ($dados->id > 0) {
            $sql = "update nota_glosa set numero='" . $dados->carta_informativo . "', valor='" . $dados->exercicio . "', exercicio='" . $dados->valor_deferido
             . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }
    function excluir($id) {
        $sql = "delete from carta_recurso where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function somarValorDeferidoPorNota($id) {
        $sql = "SELECT SUM(valor_deferido) AS total FROM carta_recurso where id_nota_glosa =$id";
        $resultado = $this->db->Execute($sql);
        if ($resultado && $row = $resultado->FetchRow()) {
            return $row['total'] ?? 0;
        }
        return 0;
    }
    function executar($id) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update carta_recurso set data_executado=". $timestamp.", status='Executado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function reverterExecucao($id) {
        $sql = "update carta_recurso set data_executado=null, status='Em análise' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestar($id) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update carta_recurso set data_atesto=". $timestamp.", status='Atestado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestarLote($lista) {
        $timestamp = mktime (0, 0, 0, date("m"), date("d"),  date("Y"));
        $sql = "update carta_recurso set data_atesto=". $timestamp.", status='Atestado' where id IN (" . $lista . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function pagar($id, $data, $doc_sei) {
        $sql = "update carta_recurso set data_pagamento=". $data.", doc_sei='".$doc_sei."', status='Pago' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getPagamentosPentendesPrestador($id_prestador) {
        $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
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
            $dados = new CartaRecurso();
            $dados->excluir = true;
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor_deferido      = $registro["valor_deferido"];
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
        $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
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
            $dados = new CartaRecurso();
            $dados->excluir = true;
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor_deferido      = $registro["valor_deferido"];
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
        $sql = "SELECT cr.id, ng.numero, ng.lote, cr.valor_deferido, cr.status, cr.id_nota_glosa, ng.id_recurso_glosa, cr.exercicio, cr.data_emissao, cr.data_validacao, cr.data_executado, cr.data_atesto, cr.data_pagamento
                FROM carta_recurso as cr, nota_glosa as ng, carta_recursada_glosa as crg, fiscal_prestador as fp 
                WHERE cr.id_nota_glosa = ng.id
                AND ng.id_recurso_glosa=crg.id 
                AND crg.id_fiscal_prestador = fp.id
                AND fp.id_prestador = ".$id_prestador." 
                AND cr.data_executado is null";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new CartaRecurso();
            $dados->excluir = true;
            $dados->id                  = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote                = $registro["lote"];
            $dados->valor_deferido      = $registro["valor_deferido"];
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
    function migrar(CartaRecurso $dados) {
        $sql = "update carta_recurso set data_emissao='". $dados->data_emissao."', data_validacao='". $dados->data_validacao."',
        data_executado='". $dados->data_executado."',data_atesto='". $dados->data_atesto."',data_pagamento='". $dados->data_pagamento."',
        doc_sei='".$dados->doc_sei."', status='".$dados->status."' where id_nota_glosa=" . $dados->id_nota_glosa;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
 }   

