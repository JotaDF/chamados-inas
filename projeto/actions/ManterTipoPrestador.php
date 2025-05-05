<?php

require_once('Model.php');
require_once('dto/TipoPrestador.php');

class ManterTipoPrestador extends Model {

    function __construct() { // Método construtor da classe ManterTipoPrestador, chama o construtor da classe Model
        parent::__construct();
    }

    // Função para listar todos os tipos de prestadores
    function listar() {
        // Consulta SQL para selecionar os tipos de prestadores e a quantidade de prestadores associados
        $sql = "select tp.id,tp.tipo, (select count(*) from prestador as p where p.id_tipo_prestador=tp.id) as dep FROM tipo_prestador as tp order by tp.tipo";
        //echo $sql;
        $resultado = $this->db->Execute($sql); // Executa a consulta SQL
        $array_dados = array(); // Array para armazenar os dados retornados

        // Percorre os resultados e preenche o array de dados
        while ($registro = $resultado->fetchRow()) {
            $dados = new TipoPrestador(); // Cria um objeto TipoPrestador
            $dados->excluir = true; // Inicializa o atributo excluir como true
            if ($registro["dep"] > 0) { // Se houver dependentes (prestadores associados)
                $dados->excluir = false; // Não é possível excluir o tipo de prestador
            }
            // Atribui os valores dos campos ao objeto
            $dados->id          = $registro["id"];
            $dados->tipo        = $registro["tipo"];
            $array_dados[]      = $dados; // Adiciona o objeto ao array
        }
        return $array_dados; // Retorna o array de tipos de prestadores
    }

    // Função para buscar um tipo de prestador pelo ID
    function getTipoPrestadorPorId($id) {
        // Consulta SQL para selecionar o tipo de prestador pelo ID
        $sql = "select tp.id,tp.tipo FROM tipo_prestador as tp WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql); // Executa a consulta SQL
        $dados = new TipoPrestador(); // Cria um objeto TipoPrestador

        // Preenche o objeto com os dados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->tipo        = $registro["tipo"];
        }
        return $dados; // Retorna o objeto TipoPrestador
    }

    // Função para salvar ou atualizar um tipo de prestador
    function salvar(TipoPrestador $dados) {
        // Consulta SQL para inserir um novo tipo de prestador
        $sql = "insert into tipo_prestador (tipo) values ('" . $dados->tipo . "')";
        if ($dados->id > 0) { // Se o tipo de prestador já tiver um ID, faz a atualização
            $sql = "update tipo_prestador set tipo_prestador='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa a atualização
        } else {
            $resultado = $this->db->Execute($sql); // Executa a inserção
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado
        }
        return $resultado; // Retorna o resultado da operação
    }

    // Função para excluir um tipo de prestador pelo ID
    function excluir($id) {
        // Consulta SQL para excluir o tipo de prestador pelo ID
        $sql = "delete from tipo_prestador where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }

}
