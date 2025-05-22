<?php 
require_once('Model.php');
require_once('dto/CartaRecursada.php');
require_once('dto/NotaGlosa.php');
require('dto/CartaRecurso.php');
Class ManterCartaRecursada extends Model {

    public function __construct() {
        parent::__construct();
    }
        

    function listar(){
        $sql = "select crg.id, crg.carta_recursada, crg.valor_original, crg.id_fiscal_prestador, (select count(*) from nota_glosa as ng where ng.id_recurso_glosa=crg.id ) as dep from carta_recursada_glosa as crg";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new CartaRecursada;
            $dados->excluir = true;
            if($registro['dep'] > 0) {
                $dados->excluir = false;
            }
                $dados->id = $registro['id'];
                $dados->carta_recursada = $registro['carta_recursada'];
                $dados->valor_original = $registro['valor_original'];
                $dados->id_fiscal_prestador =$registro['id_fiscal_prestador'];
                $array_dados[] = $dados;
           }
            return $array_dados;
        }

    function getCartaPorPrestador($id_prestador) {
        $sql = "SELECT cr.id, cr.carta_recursada, cr.valor_original, cr.id_fiscal_prestador,
                (SELECT COUNT(*) FROM nota_glosa AS ng WHERE ng.id_recurso_glosa = cr.id) AS dep
                FROM  carta_recursada_glosa AS cr, fiscal_prestador AS fp
                WHERE cr.id_fiscal_prestador = fp.id AND fp.id_prestador = ".$id_prestador." ORDER BY cr.id desc";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new CartaRecursada();
            $dados->excluir = true;
            if($registro['dep'] > 0) {
                $dados->excluir = false;
            }
                $dados->id                  = $registro['id'];
                $dados->carta_recursada     = $registro['carta_recursada'];
                $dados->valor_original      = $registro['valor_original'];
                $dados->id_fiscal_prestador =$registro['id_fiscal_prestador'];
                $array_dados[] = $dados;
           }
            return $array_dados;
        }

    function getCartaPorId($id) {
        $sql = "select cr.id, cr.carta_recursada, cr.valor_original, cr.id_fiscal_prestador from carta_recursada_glosa as cr where id=$id";
        $resultado = $this->db->Execute($sql);
        while ($registro = $resultado->fetchRow()) {
            $dados = new CartaRecursada();
            $dados->id = $registro['id'];
            $dados->carta_recursada =$registro['carta_recursada'];
            $dados->valor_original =$registro['valor_original'];
            $dados->id_fiscal_prestador =$registro['id_fiscal_prestador'];
        }
        return $dados;
    }
        
    function getNotasGlosaPorCarta($id) {
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao,
                ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.doc_sei, ng.status, 
                (select count(*) from carta_recurso as cr where cr.id_nota_glosa=ng.id ) as dep
                from nota_glosa as ng where id_recurso_glosa = ".$id;
        
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        
        while ($registro = $resultado->fetchRow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;  // Manter a propriedade excluir como true por padrão, ou remover se não for mais necessária
            if($registro['dep'] > 0) {
                $dados->excluir = false;
            }
            // Preenchendo os dados
            $dados->id               = $registro["id"];
            $dados->numero           = $registro["numero"];
            $dados->lote             = $registro["lote"];
            $dados->valor            = $registro["valor"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
            $dados->exercicio        = $registro["exercicio"];
            $dados->doc_sei          = $registro["doc_sei"];
            $dados->data_emissao     = $registro["data_emissao"];
            $dados->data_validacao   = $registro["data_validacao"];
            $dados->data_executado   = $registro["data_executado"];
            $dados->data_atesto      = $registro["data_atesto"];
            $dados->data_pagamento   = $registro["data_pagamento"];
            $dados->status           = $registro["status"];

            $array_dados[] = $dados;
        }
        
        return $array_dados;
    }

    function getCartasRecursoPorNota($id) { 
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.valor_deferido, cr.id_nota_glosa  
                FROM carta_recurso AS cr 
                WHERE cr.id_nota_glosa = ".$id." ORDER BY cr.id";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new CartaRecurso();
            $dados->excluir = true;

            $dados->id                  = $registro["id"];
            $dados->carta_informativo   = $registro["carta_informativo"];
            $dados->exercicio           = $registro["exercicio"];
            $dados->valor_deferido      = $registro["valor_deferido"];
            $dados->id_nota_glosa       = $registro["id_nota_glosa"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function salvar(CartaRecursada $dados) {
        $sql = "insert into carta_recursada_glosa (carta_recursada, valor_original, id_fiscal_prestador) values('".$dados->carta_recursada."', '".$dados->valor_original."', '".$dados->id_fiscal_prestador."')";
        if($dados->id > 0) {
            $sql = "update carta_recursada_glosa set carta_recursada='".$dados->carta_recursada."' , valor_original='".$dados->valor_original."' , id_fiscal_prestador='".$dados->id_fiscal_prestador."' where id =" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); 
        }
        return $dados;
    }
    function excluir($id) {
        $sql = "delete from carta_recursada_glosa where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function verificaInformativo($id_prestador, $informativo) {
        $sql = "select cr.id,cr.carta_recursada,cr.valor_original, cr.id_fiscal_prestador FROM carta_recursada_glosa as cr, fiscal_prestador as fp WHERE fp.id=cr.id_fiscal_prestador AND fp.id_prestador=".$id_prestador." AND cr.carta_recursada = '" . $informativo . "'";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $resp = 0;
        while ($registro = $resultado->fetchRow()) {
            $resp = 1;
        }
        return $resp;
    }
}


