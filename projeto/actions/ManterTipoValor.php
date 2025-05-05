<?php

require_once('Model.php');
require_once('dto/TipoValor.php');

class ManterTipoValor extends Model {

    function __construct() { // Método construtor da classe ManterTipoValor, chama o construtor da classe Model
        parent::__construct();
    }

    // Função para listar todos os tipos de valores
    function listar() {
        // Consulta SQL para selecionar os tipos de valores e a quantidade de registros dependentes
        $sql = "select tv.id,tv.tipo, (select count(*) from valor_processo as vp where vp.id_tipo_valor=tv.id) as dep FROM tipo_valor as tv order by tv.tipo_valor";
        //echo $sql;
        $resultado = $this->db->Execute($sql); // Executa a consulta SQL
        $array_dados = array(); // Array para armazenar os dados retornados

        // Percorre os resultados e preenche o array de dados
        while ($registro = $resultado->fetchRow()) {
            $dados = new TipoValor(); // Cria um objeto TipoValor
            $dados->excluir = true; // Inicializa o atributo excluir como true
            if ($registro["dep"] > 0) { // Se houver dependentes (registros associados)
                $dados->excluir = false; // Não é possível excluir o tipo de valor
            }
            // Atribui os valores dos campos ao objeto
            $dados->id          = $registro["id"];
            $dados->tipo        = $registro["tipo"];
            $array_dados[]      = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna o array de tipos de valores
    }

    // Função para buscar um tipo de valor pelo ID
    function getTipoValorPorId($id) {
        // Consulta SQL para selecionar o tipo de valor pelo ID
        $sql = "select tv.id,tv.tipo FROM tipo_valor as tv WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql); // Executa a consulta SQL
        $dados = new TipoValor(); // Cria um objeto TipoValor

        // Preenche o objeto com os dados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->tipo        = $registro["tipo"];
        }
        return $dados; // Retorna o objeto TipoValor
    }

    // Função para salvar ou atualizar um tipo de valor
    function salvar(TipoValor $dados) {
        // Consulta SQL para inserir um novo tipo de valor
        $sql = "insert into tipo_valor (tipo) values ('" . $dados->tipo . "')";
        if ($dados->id > 0) { // Se o tipo de valor já tiver um ID, faz a atualização
            $sql = "update tipo_valor set tipo_valor='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa a atualização
        } else {
            $resultado = $this->db->Execute($sql); // Executa a inserção
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado
        }
        return $resultado; // Retorna o resultado da operação
    }

    // Função para excluir um tipo de valor pelo ID
    function excluir($id) {
        // Consulta SQL para excluir o tipo de valor pelo ID
        $sql = "delete from tipo_valor where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }

}
