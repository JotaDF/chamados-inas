<?php

require_once('Model.php');
require_once('dto/Processo.php');

class ManterProcesso extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo $filtro ORDER BY autuacao";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Processo();
            $dados->excluir = true;
            $dados->id                       = $registro["id"];
            $dados->numero                   = $registro["numero"];
            $dados->sei                      = $registro["sei"];
            $dados->autuacao                 = $registro["autuacao"];
            $dados->cpf                      = $registro["cpf"];
            $dados->beneficiario             = $registro["beneficiario"];
            $dados->guia                     = $registro["guia"];
            $dados->senha                    = $registro["senha"];
            $dados->valor_causa              = $registro["valor_causa"];
            $dados->observacao               = $registro["observacao"];
            $dados->assunto                  = $registro["id_assunto"];
            $dados->classe_judicial          = $registro["id_classe_judicial"];
            $dados->processo_principal       = $registro["processo_principal"];
            $dados->situacao_processual      = $registro["id_situacao_processual"];
            $dados->liminar                  = $registro["id_liminar"];
            $dados->instancia                = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario                  = $registro["id_usuario"];
            $dados->atualizacao              = $registro["atualizacao"];
            $dados->autor_inas               = $registro["autor_inas"];

            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getProcessoPorId($id) {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
                       data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Processo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id                       = $registro["id"];
            $dados->numero                   = $registro["numero"];
            $dados->sei                      = $registro["sei"];
            $dados->autuacao                 = $registro["autuacao"];
            $dados->cpf                      = $registro["cpf"];
            $dados->beneficiario             = $registro["beneficiario"];
            $dados->guia                     = $registro["guia"];
            $dados->senha                    = $registro["senha"];
            $dados->valor_causa              = $registro["valor_causa"];
            $dados->observacao               = $registro["observacao"];
            $dados->assunto                  = $registro["id_assunto"];
            $dados->classe_judicial          = $registro["id_classe_judicial"];
            $dados->processo_principal       = $registro["processo_principal"];
            $dados->situacao_processual      = $registro["id_situacao_processual"];
            $dados->liminar                  = $registro["id_liminar"];
            $dados->instancia                = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario                  = $registro["id_usuario"];
            $dados->atualizacao              = $registro["atualizacao"];
            $dados->autor_inas               = $registro["autor_inas"];
        }
        return $dados;
    }
    function getProcessoPorNumero($numero) {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
                       data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas FROM processo WHERE numero=$numero";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Processo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id                       = $registro["id"];
            $dados->numero                   = $registro["numero"];
            $dados->sei                      = $registro["sei"];
            $dados->autuacao                 = $registro["autuacao"];
            $dados->cpf                      = $registro["cpf"];
            $dados->beneficiario             = $registro["beneficiario"];
            $dados->guia                     = $registro["guia"];
            $dados->senha                    = $registro["senha"];
            $dados->valor_causa              = $registro["valor_causa"];
            $dados->observacao               = $registro["observacao"];
            $dados->assunto                  = $registro["id_assunto"];
            $dados->classe_judicial          = $registro["id_classe_judicial"];
            $dados->processo_principal       = $registro["processo_principal"];
            $dados->situacao_processual      = $registro["id_situacao_processual"];
            $dados->liminar                  = $registro["id_liminar"];
            $dados->instancia                = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario                  = $registro["id_usuario"];
            $dados->atualizacao              = $registro["atualizacao"];
            $dados->autor_inas               = $registro["autor_inas"];
        }
        return $dados;
    }
    function salvar(Processo $dados) {
        if($dados->classe_judicial==""){
            $dados->classe_judicial = "null";
        }
        if($dados->liminar==""){
            $dados->liminar = "null";
            $dados->data_cumprimento_liminar = 0;
        }
        if($dados->data_cumprimento_liminar==""){
            $dados->data_cumprimento_liminar = 0;
        }
        if($dados->autor_inas==""){
            $dados->autor_inas = 0;
        }
        $sql = "insert into processo (numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_classe_judicial, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas) 
        values ('" . $dados->numero . "','" . $dados->sei . "','" . $dados->autuacao . "','" . $dados->cpf . "','" . $dados->beneficiario . "',
        '" . $dados->guia . "','" . $dados->senha . "','" . $dados->valor_causa . "','" . $dados->observacao . "','" . $dados->assunto . "',
        " . $dados->classe_judicial . ",'" . $dados->situacao_processual . "'," . $dados->liminar . ",'" . $dados->data_cumprimento_liminar . "','" . $dados->instancia . "','" . $dados->usuario . "',now(),'" . $dados->processo_principal . "'," . $dados->autor_inas . ")";
        if ($dados->id > 0) {
            $sql = "update processo set numero='" . $dados->numero . "', sei='" . $dados->sei . "', autuacao='" . $dados->autuacao . "',
            cpf='" . $dados->cpf . "', beneficiario='" . $dados->beneficiario . "', guia='" . $dados->guia . "', senha='" . $dados->senha . "', 
            valor_causa='" . $dados->valor_causa . "', observacao='" . $dados->observacao . "', id_assunto='" . $dados->assunto . "', id_classe_judicial=" . $dados->classe_judicial . ", id_situacao_processual='" . $dados->situacao_processual . "', 
            id_liminar=" . $dados->liminar . ", data_cumprimento_liminar='" . $dados->data_cumprimento_liminar . "', id_usuario='" . $dados->usuario . "', atualizacao=now(), processo_principal='" . $dados->processo_principal . "', autor_inas=" . $dados->autor_inas . " where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from processo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

