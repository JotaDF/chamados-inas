<?php

// Define o fuso horário padrão para o sistema
date_default_timezone_set('America/Sao_Paulo');

// Inclui o arquivo base Model que contém as operações com o banco de dados
require_once('Model.php');

// Inclui o DTO da classe Interacao
require_once('dto/Interacao.php');

// Classe responsável por gerenciar as interações de chamados no sistema
class ManterInteracao extends Model {

    // Construtor da classe que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Lista todas as interações de um determinado chamado (ordenadas da mais recente para a mais antiga)
    function listar($id_chamado = 0) {
        // Consulta as interações do chamado com base no ID passado
        $sql = "select i.id, i.texto, i.data, i.id_chamado, i.id_usuario FROM interacao as i WHERE i.id_chamado =$id_chamado order by i.id DESC";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array que armazenará os objetos Interacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new Interacao(); // Cria uma nova instância do DTO
            $dados->excluir = false; // Por padrão, interações não são excluíveis

            // Atribui os dados retornados do banco ao objeto
            $dados->id      = $registro["id"];
            $dados->texto   = $registro["texto"];
            // Formata a data caso esteja definida
            $dados->data    = isset($registro["data"]) ? date('Y-m-d', $registro["data"]) : 0;
            $dados->chamado = $registro["id_chamado"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[]  = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna o array com os objetos
    }

    // Retorna uma única interação pelo ID
    function getInteracaoPorId($id) {
        $sql = "select i.id, i.texto, i.data, i.id_chamado, i.id_usuario FROM interacao as i WHERE i.id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Interacao(); // Cria um novo DTO
        while ($registro = $resultado->fetchRow()) {
            // Atribui os dados do registro ao objeto
            $dados->id      = $registro["id"];
            $dados->texto   = $registro["texto"];
            $dados->data    = isset($registro["data"]) ? date('Y-m-d', $registro["data"]) : 0;
            $dados->chamado = $registro["id_chamado"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados; // Retorna o objeto preenchido
    }

    // Salva uma nova interação ou atualiza uma existente
    function salvar(Interacao $dados) {
        // SQL padrão para inserção (com NOW para data atual)
        $sql = "insert into interacao (texto, data, id_chamado, id_usuario) values ('" . $dados->texto . "',now(),'" .$dados->chamado . "','" .$dados->usuario . "')";
        
        // Se o ID for maior que zero, realiza uma atualização
        if ($dados->id > 0) {
            // OBS: aqui está atualizando a tabela 'acao' em vez de 'interacao', o que pode ser um erro
            $sql = "update acao set texto='" . $dados->texto . "',data=now(),id_chamado='" . $dados->chamado . "',id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
        } else {
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado e atribui ao objeto
        }

        return $resultado; // Retorna o resultado da operação
    }

    // Exclui uma interação com base no ID
    function excluir($id) {
        $sql = "delete from interacao where id=" . $id; // SQL de exclusão
        $resultado = $this->db->Execute($sql); // Executa o delete
        return $resultado; // Retorna o resultado
    }

}
