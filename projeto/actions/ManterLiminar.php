<?php

// Inclui o arquivo base que contém a conexão e métodos do banco de dados
require_once('Model.php');

// Inclui o DTO da classe Liminar
require_once('dto/Liminar.php');

// Classe responsável por realizar operações relacionadas às liminares
class ManterLiminar extends Model {

    // Construtor da classe, invoca o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Lista todas as liminares cadastradas, com verificação se podem ser excluídas (não referenciadas em processos)
    function listar() {
        // Consulta dados da liminar e verifica dependência com a tabela processo
        $sql = "select l.id,l.tipo, (select count(*) from processo as f where f.id_liminar=l.id) as dep FROM liminar as l order by l.tipo";
        $resultado = $this->db->Execute($sql); // Executa a query
        $array_dados = array(); // Array que armazenará os objetos Liminar

        // Percorre todos os registros retornados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Liminar(); // Cria um novo DTO
            $dados->excluir = true; // Por padrão, liminar pode ser excluída
            if ($registro["dep"] > 0) {
                $dados->excluir = false; // Se houver dependência, não pode ser excluída
            }

            // Atribui os valores retornados do banco ao objeto
            $dados->id     = $registro["id"];
            $dados->tipo   = $registro["tipo"];
            $array_dados[] = $dados; // Adiciona o objeto ao array
        }

        return $array_dados; // Retorna o array com os objetos preenchidos
    }

    // Retorna os dados de uma liminar específica a partir do ID
    function getLiminarPorId($id) {
        $sql = "select l.id,l.tipo FROM liminar as l WHERE id=$id"; // SQL para buscar liminar pelo ID
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Liminar(); // Cria uma nova instância do DTO

        // Percorre o resultado da consulta (normalmente apenas um registro)
        while ($registro = $resultado->fetchRow()) {
            $dados->id   = $registro["id"];
            $dados->tipo = $registro["tipo"];
        }

        return $dados; // Retorna o objeto preenchido
    }

    // Salva uma nova liminar ou atualiza uma já existente
    function salvar(Liminar $dados) {
        // Prepara SQL para inserção
        $sql = "insert into liminar (tipo) values ('" . $dados->tipo . "')";

        // Se a liminar já possui ID, realiza um UPDATE
        if ($dados->id > 0) {
            $sql = "update liminar set tipo='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa a atualização
        } else {
            $resultado = $this->db->Execute($sql); // Executa a inserção
            $dados->id = $this->db->insert_Id(); // Obtém o ID gerado e atribui ao objeto
        }

        return $resultado; // Retorna o resultado da operação
    }

    // Exclui uma liminar a partir do ID
    function excluir($id) {
        $sql = "delete from liminar where id=" . $id; // SQL de exclusão
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da execução
    }

}
