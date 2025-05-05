<?php

// Importa a classe base Model que fornece acesso ao banco de dados
require_once('Model.php');

// Importa a classe DTO Setor (representa um setor com seus atributos)
require_once('dto/Setor.php');

// Classe responsável por gerenciar as operações relacionadas à tabela 'setor'
class ManterSetor extends Model {

    // Construtor da classe que chama o construtor da classe pai
    function __construct() {
        parent::__construct();
    }

    // Método que retorna uma lista de todos os setores
    function listar() {
        // Consulta SQL que busca todos os setores e verifica se há usuários vinculados (dependências)
        $sql = "select s.id,s.sigla,s.descricao, (select count(*) from usuario as u where u.id_setor=s.id) as dep FROM setor as s order by s.sigla";

        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);

        // Inicializa um array para armazenar os objetos Setor
        $array_dados = array();

        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new Setor();

            // Inicialmente permite exclusão
            $dados->excluir = true;

            // Se houver usuários vinculados ao setor, desabilita a exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os valores do resultado ao objeto Setor
            $dados->id        = $registro["id"];
            $dados->sigla     = $registro["sigla"];
            $dados->descricao = $registro["descricao"];

            // Adiciona o objeto ao array de retorno
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    // Retorna um setor específico com base no ID fornecido
    function getSetorPorId($id) {
        $sql = "select s.id,s.sigla,s.descricao FROM setor as s WHERE id=$id";

        // Executa a consulta
        $resultado = $this->db->Execute($sql);
        $dados = new Setor();

        // Atribui os valores ao objeto Setor
        while ($registro = $resultado->fetchRow()) {
            $dados->id        = $registro["id"];
            $dados->sigla     = $registro["sigla"];
            $dados->descricao = $registro["descricao"];
        }

        return $dados;
    }

    // Salva um setor no banco de dados (inserção ou atualização)
    function salvar(Setor $dados) {
        // Redundância desnecessária (essas linhas não têm efeito prático):
        $dados->setor = $dados->setor;
        $dados->descricao = $dados->descricao;

        // Monta a SQL para inserção de novo setor
        $sql = "insert into setor (sigla,descricao) values ('" . $dados->sigla . "','" . $dados->descricao . "')";

        // Se o ID já estiver definido, realiza uma atualização (update)
        if ($dados->id > 0) {
            $sql = "update setor set sigla='" . $dados->sigla . "',descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Caso contrário, insere um novo setor
            $resultado = $this->db->Execute($sql);
            // Recupera o ID do novo registro inserido
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    // Exclui um setor com base no ID
    function excluir($id) {
        $sql = "delete from setor where id=" . $id;

        // Executa a exclusão no banco de dados
        $resultado = $this->db->Execute($sql);

        return $resultado;
    }

}
