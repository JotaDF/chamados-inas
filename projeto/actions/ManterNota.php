<?php

// Inclui a classe base com métodos de conexão e execução de SQL
require_once('Model.php');

// Inclui a definição da classe Nota (DTO)
require_once('dto/Nota.php');

// Classe responsável por gerenciar as operações de CRUD da tabela "nota"
class ManterNota extends Model {

    // Construtor da classe, chama o construtor da classe base
    function __construct() {
        parent::__construct();
    }

    // Lista todas as notas aplicando um filtro opcional
    function listar($filtro) {
        // Consulta com filtro dinâmico e ordenação por ID
        $sql = "select n.id,n.nota,n.hora_registro, n.id_pergunta FROM nota as n $filtro order by n.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os resultados

        // Percorre os registros retornados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Nota(); // Cria um novo objeto Nota
            $dados->id            = $registro["id"];
            $dados->nota          = $registro["nota"];
            $dados->hora_registro = $registro["hora_registro"];
            $array_dados[] = $dados; // Adiciona ao array
        }

        return $array_dados; // Retorna todas as notas encontradas
    }

    // Retorna a quantidade de registros de nota para o filtro passado
    function listarRelatorio($filtro) {
        // Consulta que retorna apenas a contagem de registros
        $sql = "select count(*) as total FROM nota as n " . $filtro;
        $resultado = $this->db->Execute($sql); // Executa a consulta

        // Se houver resultado, retorna o valor do campo "total"
        if ($registro = $resultado->fetchRow()) {
            return $registro["total"];
        }

        return 0; // Retorna 0 se não houver registros
    }

    // Retorna os dados de uma nota específica pelo ID
    function getNotaPorId($id) {
        $sql = "select n.id,n.nota,n.hora_registro, n.id_pergunta FROM nota as n WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Nota(); // Cria um novo objeto Nota

        // Percorre os registros retornados (espera-se um único)
        while ($registro = $resultado->fetchRow()) {
            $dados->id            = $registro["id"];
            $dados->nota          = $registro["nota"];
            $dados->hora_registro = $registro["hora_registro"];
        }

        return $dados; // Retorna o objeto preenchido
    }

    // Salva (insere ou atualiza) os dados de uma nota
    function salvar(Nota $dados) {
        // Comando SQL para inserção
        $sql = "insert into nota (id_pergunta,nota,hora_registro) values ('" . $dados->pergunta . "','" . $dados->nota . "',now())";

        // Se o ID já existir, executa um UPDATE ao invés do INSERT
        if ($dados->id > 0) {
            $sql = "update nota set id_pergunta='" . $dados->pergunta . "', nota='" . $dados->nota . "',hora_registro=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
        } else {
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Captura o ID gerado automaticamente
        }

        return $resultado; // Retorna o resultado da execução
    }

    // Exclui uma nota pelo ID
    function excluir($id) {
        $sql = "delete from nota where id=" . $id; // Comando SQL de exclusão
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da execução
    }

}
