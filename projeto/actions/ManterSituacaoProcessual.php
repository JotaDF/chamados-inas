<?php

// Requerendo os arquivos necessários
require_once('Model.php');
require_once('dto/SituacaoProcessual.php');

class ManterSituacaoProcessual extends Model {

    // Método construtor
    function __construct() {
        parent::__construct();  // Chama o construtor da classe pai
    }

    // Função para listar todas as situações processuais
    function listar() {
        // Query para listar as situações processuais e contar os processos relacionados
        $sql = "select sp.id, sp.situacao, (select count(*) from processo as p where p.id_situacao_processual=sp.id) as dep 
                FROM situacao_processual as sp order by sp.situacao";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados recuperados
        $array_dados = array();
        
        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new SituacaoProcessual();  // Cria um novo objeto SituacaoProcessual
            $dados->excluir = true;  // Inicializa a variável excluir como verdadeira
            
            // Se houver dependentes, não permite exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            
            // Preenche os dados do objeto
            $dados->id = $registro["id"];
            $dados->situacao = $registro["situacao"];
            
            // Adiciona o objeto à lista de dados
            $array_dados[] = $dados;
        }
        
        // Retorna o array de dados
        return $array_dados;
    }

    // Função para obter a situação processual pelo ID
    function getSituacaoProcessualPorId($id) {
        // Query para obter a situação processual por ID
        $sql = "select sp.id, sp.situacao FROM situacao_processual as sp WHERE id=$id";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        $dados = new SituacaoProcessual();  // Cria um novo objeto SituacaoProcessual
        
        // Preenche os dados do objeto
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->situacao = $registro["situacao"];
        }
        
        // Retorna os dados da situação processual
        return $dados;
    }

    // Função para salvar ou atualizar uma situação processual
    function salvar(SituacaoProcessual $dados) {
        // Query para inserir uma nova situação processual
        $sql = "insert into situacao_processual (situacao) values ('" . $dados->situacao . "')";
        
        // Se o ID for maior que 0, significa que é um update
        if ($dados->id > 0) {
            // Query para atualizar a situação processual existente
            $sql = "update situacao_processual set situacao='" . $dados->situacao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Executa a query para inserção
            $resultado = $this->db->Execute($sql);
            // Define o ID do novo registro
            $dados->id = $this->db->insert_Id();
        }
        
        // Retorna o resultado da operação
        return $resultado;
    }

    // Função para excluir uma situação processual
    function excluir($id) {
        // Query para excluir a situação processual
        $sql = "delete from situacao_processual where id=" . $id;
        
        // Executa a query para exclusão
        $resultado = $this->db->Execute($sql);
        
        // Retorna o resultado da operação
        return $resultado;
    }
}
