<?php

// Inclui a classe base Model, que provavelmente gerencia a conexão com o banco de dados
require_once('Model.php');

// Inclui o DTO (Data Transfer Object) da entidade Pergunta
require_once('dto/Pergunta.php');

// Classe responsável por gerenciar a persistência e recuperação de dados da entidade Pergunta
class ManterPergunta extends Model {

    // Construtor da classe, chama o construtor da classe pai para inicializar a conexão com o banco
    function __construct() {
        parent::__construct();
    }

    // Método para listar perguntas com um filtro opcional
    function listar($filtro = "") {
        // Monta a consulta SQL, incluindo contagem de notas associadas a cada pergunta (para controle de exclusão)
        $sql = "select p.id,p.descricao, status, (select count(*) from nota as n where n.id_pergunta=p.id) as dep FROM pergunta as p $filtro order by p.id";
        
        // Executa a consulta
        $resultado = $this->db->Execute($sql);

        // Inicializa o array que armazenará os objetos de perguntas retornados
        $array_dados = array();

        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pergunta(); // Cria novo objeto Pergunta

            $dados->excluir = true; // Por padrão, permite exclusão

            // Se a pergunta estiver vinculada a alguma nota, desativa a opção de exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os valores retornados do banco ao objeto
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->status      = $registro["status"];

            // Adiciona o objeto ao array de retorno
            $array_dados[]      = $dados;
        }

        // Retorna o array com todas as perguntas encontradas
        return $array_dados;
    }

    // Retorna os dados de uma pergunta específica a partir do ID
    function getPerguntaPorId($id) {
        $sql = "select p.id,p.descricao, status FROM pergunta as p WHERE id=$id";
        
        $resultado = $this->db->Execute($sql);
        $dados = new Pergunta(); // Cria novo objeto Pergunta

        // Se houver resultado, preenche o objeto com os dados
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->status      = $registro["status"];
        }

        // Retorna o objeto preenchido
        return $dados;
    }

    // Método que insere ou atualiza uma pergunta
    function salvar(Pergunta $dados) {
        // Se for um novo registro (id == 0), cria um INSERT
        $sql = "insert into pergunta (descricao) values ('" . $dados->descricao . "')";
        
        // Caso contrário, atualiza a pergunta existente
        if ($dados->id > 0) {
            $sql = "update pergunta set descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o UPDATE
        } else {
            $resultado = $this->db->Execute($sql); // Executa o INSERT
            $dados->id = $this->db->insert_Id();   // Recupera o ID gerado pelo banco
        }

        // Retorna o resultado da operação
        return $resultado;
    }

    // Publica uma pergunta (status = 1)
    function publicar($id) {
        $sql = "update pergunta set status=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Despublica uma pergunta (status = 0)
    function despublicar($id) {
        $sql = "update pergunta set status=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Exclui uma pergunta pelo ID
    function excluir($id) {
        $sql = "delete from pergunta where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}
