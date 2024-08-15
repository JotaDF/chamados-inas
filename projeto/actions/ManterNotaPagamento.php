<?php

require_once('Model.php');
require_once('dto/NotaPagamento.php');

class ManterNotaPagamento extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np order by np.id";
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
    function getNotaPagamentoPorId($id) {
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.data_emissao, np.data_validacao, np.data_executado, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new NotaPagamento();
        while ($registro = $resultado->fetchRow()) {
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
        }
        return $dados;
    }
    function verificaNotaPorPrestador($id_prestador, $numero) {
        $sql = "select np.id, np.numero FROM nota_pagamento as np, pagamento as p, fiscal_prestador as fp 
                WHERE np.id_pagamento = p.id AND p.id_fiscal_prestador AND fp.id_prestador=".$id_prestador." AND np.numero='".$numero."'" ;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $resp = 0;
        while ($registro = $resultado->fetchRow()) {
            $resp = 1;
        }
        return $resp;
    }
    function salvar(NotaPagamento $dados) {
        $sql = "insert into nota_pagamento (numero, valor, exercicio, data_emissao, data_validacao, id_pagamento, status) 
        values ('" . $dados->numero . "','" . $dados->valor . "','" . $dados->exercicio . "', '" . $dados->data_emissao . "', '" . $dados->data_validacao . "','" . $dados->pagamento . "','Em análise')";
        if ($dados->id > 0) {
            $sql = "update nota_pagamento set numero='" . $dados->numero . "', valor='" . $dados->valor . "', exercicio='" . $dados->exercicio
             . "', data_emissao='" . $dados->data_emissao . "', data_validacao='" . $dados->data_validacao . "', id_pagamento='" . $dados->pagamento . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from nota_pagamento where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function executar($id) {
        $sql = "update nota_pagamento set data_executado='now()', status='Executado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestar($id) {
        $sql = "update nota_pagamento set data_atesto='now()', status='Atestado' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function atestarLote($lista) {
        $sql = "update nota_pagamento set data_atesto='now()', status='Atestado' where id IN (" . $lista . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function pagar($id) {
        $sql = "update nota_pagamento set data_pagamento='now()', status='Pago' where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }


}

