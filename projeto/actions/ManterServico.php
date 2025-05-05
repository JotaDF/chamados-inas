<?php

// Inclui a classe base Model que fornece acesso ao banco de dados
require_once('Model.php');

// Inclui a definição da classe DTO Servico
require_once('dto/Servico.php');

// Classe responsável por gerenciar operações com a tabela 'servico'
class ManterServico extends Model {

    // Construtor da classe, que chama o construtor da classe pai
    function __construct() {
        parent::__construct();
    }

    // Lista todos os serviços cadastrados
    function listar() {
        // SQL que retorna os serviços e a quantidade de dependências na tabela 'fila' (quantas filas usam esse serviço)
        $sql = "select s.id,s.nome, (select count(*) from fila as f where f.id_servico=s.id) as dep FROM servico as s order by s.nome";
        
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);

        // Array que armazenará os objetos Servico criados
        $array_dados = array();

        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new Servico();
            
            // Inicialmente permite exclusão
            $dados->excluir = true;

            // Se houver dependências (registros na tabela fila), não permite exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os valores ao objeto
            $dados->id     = $registro["id"];
            $dados->nome   = $registro["nome"];

            // Adiciona o objeto ao array de retorno
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    // Retorna um serviço específico com base no ID informado
    function getServicoPorId($id) {
        $sql = "select s.id,s.nome FROM servico as s WHERE id=$id";
        
        $resultado = $this->db->Execute($sql);
        $dados = new Servico();

        // Atribui os dados do serviço encontrado ao objeto
        while ($registro = $resultado->fetchRow()) {
            $dados->id    = $registro["id"];
            $dados->nome  = $registro["nome"];
        }

        return $dados;
    }

    // Salva um serviço no banco de dados (insere novo ou atualiza existente)
    function salvar(Servico $dados) {
        // SQL para inserir novo serviço
        $sql = "insert into servico (nome) values ('" . $dados->nome . "')";

        // Se o ID for maior que zero, significa que o serviço já existe: faz um update
        if ($dados->id > 0) {
            $sql = "update servico set nome='" . $dados->nome . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Caso contrário, insere novo registro
            $resultado = $this->db->Execute($sql);
            // Recupera o ID gerado automaticamente após inserção
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    // Exclui um serviço com base no ID
    function excluir($id) {
        $sql = "delete from servico where id=" . $id;

        // Executa o comando de exclusão no banco de dados
        $resultado = $this->db->Execute($sql);

        return $resultado;
    }

}
