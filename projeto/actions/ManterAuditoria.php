<?php

require_once('Model.php');
require_once('dto/Auditoria.php');

class ManterAuditoria extends Model {

    function __construct() { // Método construtor
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar($filtro = "") {
        // Consulta SQL para listar as auditorias com um filtro opcional
        $sql = "select a.id,a.acao,a.objeto, a.informacao, a.data_acao, a.autor FROM auditoria as a $filtro order by a.id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os dados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            $dados = new Auditoria(); // Cria um novo objeto Auditoria
            // Preenche os dados da auditoria com as informações do banco
            $dados->id          = $registro["id"];
            $dados->acao        = $registro["acao"];
            $dados->objeto      = $registro["objeto"];
            $dados->informacao  = $registro["informacao"];
            $dados->data_acao   = $registro["data_acao"];
            $dados->autor       = $registro["autor"];
            
            $array_dados[]      = $dados; // Adiciona a auditoria ao array de resultados
        }
        return $array_dados; // Retorna o array de auditorias
    }
    
    function getAuditoriaPorId($id) {
        // Consulta SQL para buscar uma auditoria específica pelo ID
        $sql = "select a.id,a.acao,a.objeto, a.informacao, a.data_acao, a.autor FROM auditoria as a WHERE id=$id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Auditoria(); // Cria um novo objeto Auditoria
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            // Preenche os dados da auditoria com as informações do banco
            $dados->id          = $registro["id"];
            $dados->acao        = $registro["acao"];
            $dados->objeto      = $registro["objeto"];
            $dados->informacao  = $registro["informacao"];
            $dados->data_acao   = $registro["data_acao"];
            $dados->autor       = $registro["autor"];
        }
        return $dados; // Retorna a auditoria encontrada
    }

    function salvar(Auditoria $dados) {
        // Consulta SQL para inserir uma nova auditoria
        $sql = "insert into auditoria (acao,objeto,informacao,data_acao,autor) 
                values ('" . $dados->acao . "','" . $dados->objeto . "','" . $dados->informacao . "',now(),'" . $dados->autor . "')";
        if ($dados->id > 0) { // Se o ID da auditoria for maior que 0, é um update
            $sql = "update auditoria set acao='" . $dados->acao . "',objeto='" . $dados->objeto . "',informacao='" . $dados->informacao . "',data_acao=now(),autor='" . $dados->autor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
            return $dados; // Retorna os dados atualizados
        } else { // Se o ID for 0, é um insert
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado pela inserção
            return $dados; // Retorna os dados com o novo ID
        }
        return $resultado; // Retorna o resultado da operação
    }

    function excluir($id) {
        // Consulta SQL para excluir uma auditoria pelo ID
        $sql = "delete from auditoria where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }
}
