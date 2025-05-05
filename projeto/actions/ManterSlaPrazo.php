<?php 
// Requerendo os arquivos necessários
require_once('Model.php');
require_once('dto/SlaPrazo.php');

Class ManterSlaPrazo extends Model {

    // Método construtor
    function __construct() {
        parent::__construct();  // Chama o construtor da classe pai
    }

    // Função para listar todos os SLAs de prazo
    function listaSlaPrazo() {
        // Query para selecionar os dados de SLA e prazo
        $sql = "SELECT id, tipo_guia, fila, prazo_dias, prazo_segundos FROM sla_prazo";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os dados recuperados
        $array_dados = [];
        
        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new SlaPrazo();  // Cria um novo objeto SlaPrazo
            // Preenche os dados do objeto
            $dados->id = $registro["id"];
            $dados->tipo_guia = $registro["tipo_guia"];
            $dados->fila = $registro["fila"];
            $dados->prazo_dias = $registro["prazo_dias"];
            $dados->prazo_segundos = $registro["prazo_segundos"];
            // Adiciona o objeto à lista de dados
            $array_dados[] = $dados;
        }
        
        // Retorna o array de dados
        return $array_dados;
    }

    // Função para salvar um novo SLA de prazo
    function salvar($dados) {
        // Query para inserir os dados do SLA de prazo
        $sql = "INSERT INTO sla_prazo (tipo_guia, fila, prazo_dias, prazo_segundos) 
                VALUES('".$dados->tipo_guia."', '".$dados->fila."', ".$dados->prazo_dias.", ".$dados->prazo_segundos.")"; 
        
        // Executa a consulta SQL para inserção
        $resultado = $this->db->Execute($sql);  
        
        // Retorna o resultado da operação
        return $resultado;
    }

    // Função para excluir um SLA de prazo pelo ID
    function excluir($id) {
        // Query para excluir o SLA de prazo pelo ID
        $sql = "DELETE FROM sla_prazo WHERE id=" . $id;
        
        // Executa a consulta SQL para exclusão
        $resultado = $this->db->Execute($sql);
        
        // Retorna o resultado da operação
        return $resultado;
    }

    // Função de update ainda não implementada
    function update($id) {
        // Método de atualização ainda não implementado
    }

    // Função para listar as filas distintas de SLA
    function listarFila() {
        // Query para selecionar as filas distintas
        $sql = "SELECT DISTINCT fila FROM sla_prazo";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar as filas
        $filas = [];
        
        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $filas[] = $registro["fila"];
        }
        
        // Retorna as filas ou 0 se não houver filas
        return !empty($filas) ? $filas : 0;
    }

    // Função para listar os tipos de guia distintos
    function listarTipoGuia() {
        // Query para selecionar os tipos de guia distintos
        $sql = "SELECT DISTINCT tipo_guia FROM sla_prazo";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        
        // Array para armazenar os tipos de guia
        $tipo_guias = [];
        
        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $tipo_guias[] = $registro['tipo_guia'];
        }
        
        // Retorna os tipos de guia ou 0 se não houver tipos
        return !empty($tipo_guias) ? $tipo_guias : 0;
    }
    
}
