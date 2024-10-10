<?php

require_once('Model.php');
require_once('dto/OcorrenciaNota.php');


class ManterOcorrenciaNota extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o $filtro order by o.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota();
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    
    function getOcorrenciaNotaPorId($id) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new OcorrenciaNota();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
        }
        return $dados;
    }
    function getOcorrenciasPorIdNotaGlosa($id_nota_glosa) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id_nota_glosa=".$id_nota_glosa." order by o.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota();
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getOcorrenciasPorIdNotaPagamento($id_nota_pagamento) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id_nota_pagamento=".$id_nota_pagamento." order by o.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota();
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function salvar(OcorrenciaNota $dados) {

        $sql = "insert into ocorrencia_nota (descricao,resolvido,id_nota_pagamento,data,autor)
                values ('" . $dados->descricao . "',0," . $dados->nota_pagamento . ",now()," . $dados->autor . ")";
        if($dados->nota_glosa > 0){
            $sql = "insert into ocorrencia_nota (descricao,resolvido,id_nota_glosa,data,autor)
                values ('" . $dados->descricao . "',0," . $dados->nota_glosa . ",now()," . $dados->autor . ")";
        }       
        if ($dados->id > 0) {
            $sql = "update ocorrencia_nota set descricao='" . $dados->descricao . "',data=now(),autor='" . $dados->autor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
            return $dados;
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
            return $dados;
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from ocorrencia_nota where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function resolver($id) {
        $sql = "update ocorrencia_nota set resolvido = 1 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function desresolver($id) {
        $sql = "update ocorrencia_nota set resolvido = 0 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

