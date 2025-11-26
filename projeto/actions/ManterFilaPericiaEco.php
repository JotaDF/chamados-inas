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
    function getDataAgendamento() {
        $sql = "SELECT data_solicitacao FROM fila_pericia_eco";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco();
            $dados = $registro['data_solicitacao'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getAgendamentoPorData($data) {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf FROM fila_pericia_eco WHERE data_solicitacao = '". $data ."'";
        $resultado = $this->db->Execute($sql);
        if($registro = $resultado->fetchRow()) {
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
        }
        return $dados;
    }
    function listaFilaPericiaSemAtendimento() {
        $sql = "SELECT fp.id, fp.id_guia, fp.autorizacao, fp.data_solicitacao, fp.justificativa, fp.situacao, fp.cpf, b.nome, b.telefone FROM fila_pericia_eco as fp, beneficiario as b WHERE b.cpf = fp.cpf AND fp.id NOT IN (SELECT id_fila FROM atendimento_pericia WHERE id_fila)";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            // if ($registro["dep"] > 0) {
            //     $dados->excluir = false;
            // }
            $dados->id                  = $registro["id"];
            $dados->id_guia             = $registro["id_guia"];
            $dados->autorizacao         = $registro["autorizacao"];
            $dados->data_solicitacao    = $registro["data_solicitacao"];
            $dados->justificativa       = $registro["justificativa"];
            $dados->situacao            = $registro["situacao"];
            $dados->descricao           = $registro["descricao"];
            $dados->cpf                 = $registro["cpf"];
            $dados->nome                = $registro["nome"];
            $dados->telefone            = $registro["telefone"];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }
    function getFilaPorId($id_fila) {
        $sql = "SELECT fp.id, fp.id_guia, fp.autorizacao, fp.data_solicitacao, fp.justificativa, fp.situacao, fp.descricao, fp.cpf, b.nome, b.telefone FROM fila_pericia_eco as fp, beneficiario as b WHERE b.cpf = fp.cpf AND fp.id ='". $id_fila ."'";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
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
            $dados->nome                = $registro["nome"];
            $dados->telefone            = $registro["telefone"];
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

