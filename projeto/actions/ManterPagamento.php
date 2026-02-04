<?php

require_once('Model.php');
require_once('dto/Pagamento.php');
require_once('dto/NotaPagamento.php');

class ManterPagamento extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador (select count(*) from nota_pagamento as np where np.id_pagamento=p.id) as dep FROM pagamento as p order by p.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pagamento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getPagamentosPorPrestador($id_prestador) {
        $sql = "select p.id,p.informativo,p.competencia,SUBSTRING_INDEX(p.competencia, '/', 1) as mes, SUBSTRING_INDEX(SUBSTRING_INDEX(p.competencia, '/', 2), '/', -1) as ano, p.id_fiscal_prestador, (select count(*) from nota_pagamento as np where np.id_pagamento=p.id) as dep FROM pagamento as p, fiscal_prestador as fp where p.id_fiscal_prestador = fp.id AND fp.id_prestador = " . $id_prestador . " order by ano desc,mes desc;";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pagamento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getPagamentoPorId($id) {
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador FROM pagamento as p WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Pagamento();
        while ($registro = $resultado->fetchRow()) {
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];
        }
        return $dados;
    }
    function verificaInformativo($id_prestador, $informativo) {
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador FROM pagamento as p, fiscal_prestador as fp WHERE fp.id=p.id_fiscal_prestador AND fp.id_prestador=".$id_prestador." AND p.informativo = '" . $informativo . "'";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $resp = 0;
        while ($registro = $resultado->fetchRow()) {
            $resp = 1;
        }
        return $resp;
    }
    function getNotasPorPagamento($id) {
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.doc_sei, np.data_emissao, np.data_validacao, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np where np.id_pagamento = ".$id." order by np.id";
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
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->data_emissao    = $registro["data_emissao"];
            $dados->data_validacao  = $registro["data_validacao"];
            $dados->data_atesto     = $registro["data_atesto"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->id_pagamento    = $registro["id_pagamento"];
            $dados->status = $registro["status"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getAnosCompetencia() {
        $sql = "SELECT DISTINCT RIGHT(TRIM(competencia), 4) AS ano FROM pagamento WHERE competencia REGEXP '[0-9]{4}$' ORDER BY ano DESC";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $array_dados[]  = $registro['ano'];
        }
        return $array_dados;
    }

    function getCompetenciasPorAno($ano = '2025') {
        $sql = "SELECT DISTINCT REPLACE(competencia, ' ', '') AS competencia FROM pagamento WHERE competencia LIKE '%$ano'  ORDER BY competencia ASC";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $array_dados[] = $registro['competencia'];
        }
        return $array_dados;
    }

        function getCompetenciasNaoAdministrativasPorAno($ano = '2025') {
        $sql = "SELECT DISTINCT REPLACE(pg.competencia, ' ', '') AS competencia FROM tipo_prestador as tp, prestador as p, fiscal_prestador as fp, pagamento as pg 
        WHERE tp.id = p.id_tipo_prestador AND p.id = fp.id_prestador AND fp.id = pg.id_fiscal_prestador AND pg.competencia LIKE '%$ano' AND tp.id <> '12'  ORDER BY competencia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $array_dados[] = $registro['competencia'];
        }
        return $array_dados;
    }
    function salvar(Pagamento $dados) {
        $sql = "insert into pagamento (informativo,competencia,id_fiscal_prestador) values ('" . $dados->informativo . "','" . $dados->competencia . "','" . $dados->fiscal_prestador . "')";
        if ($dados->id > 0) {
            $sql = "update pagamento set informativo='" . $dados->informativo . "', competencia='" . $dados->competencia . "', id_fiscal_prestador='" . $dados->fiscal_prestador . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from pagamento where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

