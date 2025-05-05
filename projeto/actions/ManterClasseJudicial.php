<?php

// Inclui a classe base Model, que provavelmente contém a conexão com o banco de dados e métodos comuns.
require_once('Model.php');
// Inclui a definição da classe DTO (Data Transfer Object) ClasseJudicial.
require_once('dto/ClasseJudicial.php');

// Classe responsável por gerenciar as operações com a tabela `classe_judicial` no banco de dados.
class ManterClasseJudicial extends Model {

    // Construtor que chama o construtor da classe pai (Model), provavelmente inicializando a conexão com o banco.
    function __construct() {
        parent::__construct();
    }

    // Método para listar todas as classes judiciais, incluindo a contagem de dependências (processos vinculados a cada classe).
    function listar() {
        $sql = "select cj.id,cj.classe, (select count(*) from processo as p where p.id_classe_judicial=cj.id) as dep FROM classe_judicial as cj order by cj.classe";
        $resultado = $this->db->Execute($sql); // Executa a consulta.
        $array_dados = array(); // Inicializa array para armazenar os resultados.

        while ($registro = $resultado->fetchRow()) {
            $dados = new ClasseJudicial(); // Cria novo objeto da DTO.
            $dados->excluir = true; // Inicializa a flag `excluir` como true.

            // Se houver processos vinculados, não é permitido excluir.
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Define os atributos do objeto com base no resultado da consulta.
            $dados->id = $registro["id"];
            $dados->classe = $registro["classe"];
            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados.
        }

        return $array_dados; // Retorna a lista de objetos ClasseJudicial.
    }

    // Método que retorna uma classe judicial específica pelo ID.
    function getClasseJudicialPorId($id) {
        $sql = "select cj.id,cj.classe FROM classe_judicial as cj WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta.
        $dados = new ClasseJudicial(); // Inicializa o objeto DTO.

        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->classe = $registro["classe"];
        }

        return $dados; // Retorna o objeto ClasseJudicial com os dados encontrados.
    }

    // Método para inserir ou atualizar uma classe judicial no banco de dados.
    function salvar(ClasseJudicial $dados) {
        // Monta SQL de inserção por padrão.
        $sql = "insert into classe_judicial (classe) values ('" . $dados->classe . "')";

        // Se o ID já estiver definido (> 0), realiza update em vez de insert.
        if ($dados->id > 0) {
            $sql = "update classe_judicial set classe='" . $dados->classe . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa update.
        } else {
            $resultado = $this->db->Execute($sql); // Executa insert.
            $dados->id = $this->db->insert_Id(); // Atribui o ID gerado pelo banco de dados ao objeto.
        }

        return $resultado; // Retorna o resultado da operação.
    }

    // Método para excluir uma classe judicial pelo ID.
    function excluir($id) {
        $sql = "delete from classe_judicial where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão.
        return $resultado; // Retorna o resultado da operação.
    }

}
