<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Fila.php');
require_once('dto/FilaPericiaEco.php');

class ManterFilaPericiaEco extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf 
                FROM fila_pericia_eco";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id                  = $registro["id"];
            $dados->id_guia             = $registro["id_guia"];
            $dados->autorizacao         = $registro["autorizacao"];
            $dados->data_solicitacao    = $registro["data_solicitacao"];
            $dados->justificativa       = $registro["justificativa"];
            $dados->situacao            = $registro["situacao"];
            $dados->descricao           = $registro["descricao"];
            $dados->cpf                 = $registro["cpf"];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }
    function getFilaPorIdGuia($id_guia) {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf 
                FROM fila_pericia_eco 
                WHERE id_guia = " . $id_guia;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new FilaPericiaEco();
        if ($registro = $resultado->fetchRow()) {
            $dados->excluir = true;
            $dados->id                  = $registro["id"];
            $dados->id_guia             = $registro["id_guia"];
            $dados->autorizacao         = $registro["autorizacao"];
            $dados->data_solicitacao    = $registro["data_solicitacao"];
            $dados->justificativa       = $registro["justificativa"];
            $dados->situacao            = $registro["situacao"];
            $dados->descricao           = $registro["descricao"];
            $dados->cpf                 = $registro["cpf"];
        }
        return $dados;
    }
    function existeGuia($id_guia) {
        $sql = "SELECT id, id_guia FROM fila_pericia_eco WHERE id_guia = " . $id_guia;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            return true;
        }
        return false;
    }
    function salvar(FilaPericiaEco $dados) {
        $sql = "INSERT INTO fila_pericia_eco (id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf) 
                VALUES (" . $dados->id_guia . ", '" . $dados->autorizacao . "', '" . $dados->data_solicitacao . "', '" . $dados->justificativa . "', '" . $dados->situacao . "', '" . $dados->descricao . "', '" . $dados->cpf . "')";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function excluir($id) {
        $sql = "delete from fila_pericia_eco where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

