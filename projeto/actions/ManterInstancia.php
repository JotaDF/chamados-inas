<?php

// Inclui os arquivos necessários para a classe funcionar
require_once('Model.php');
require_once('dto/Instancia.php');

// Classe responsável por manipular registros da tabela 'instancia'
class ManterInstancia extends Model {

    // Construtor da classe, que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Método para listar todas as instâncias e verificar se há processos associados
    function listar() {
        // SQL que retorna os dados da instância e um contador (dep) de processos ligados a cada uma
        $sql = "select i.id,i.instancia, (select count(*) from processo as p where p.id_instancia=i.id) as dep FROM instancia as i order by i.instancia";
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        // Array para armazenar os objetos de instância retornados
        $array_dados = array();
        // Itera sobre os registros retornados
        while ($registro = $resultado->fetchRow()) {
            // Cria uma nova instância do DTO
            $dados = new Instancia();
            $dados->excluir = true; // Inicialmente permite a exclusão
            // Se houver processos relacionados, desabilita a exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            // Atribui os valores do registro aos atributos do objeto
            $dados->id = $registro["id"];
            $dados->instancia = $registro["instancia"];
            // Adiciona o objeto ao array de retorno
            $array_dados[] = $dados;
        }
        // Retorna o array com os objetos Instancia preenchidos
        return $array_dados;
    }

    // Método para buscar uma instância específica pelo ID
    function getInstanciaPorId($id) {
        // SQL que retorna os dados da instância com o ID fornecido
        $sql = "select i.id,i.instancia FROM instancia as i WHERE id=$id";
        // Executa a consulta
        $resultado = $this->db->Execute($sql);
        // Cria o objeto DTO
        $dados = new Instancia();
        // Itera sobre os dados retornados e preenche o DTO
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->instancia = $registro["instancia"];
        }
        // Retorna o objeto com os dados preenchidos
        return $dados;
    }

    // Método para salvar ou atualizar uma instância
    function salvar(Instancia $dados) {
        // SQL para inserir uma nova instância
        $sql = "insert into instancia (instancia) values ('" . $dados->instancia . "')";
        // Se já existir ID, então é uma atualização
        if ($dados->id > 0) {
            $sql = "update instancia set instancia='" . $dados->instancia . "' where id=$dados->id";
            // Executa o update
            $resultado = $this->db->Execute($sql);
        } else {
            // Executa o insert
            $resultado = $this->db->Execute($sql);
            // Recupera o ID gerado pelo banco e atribui ao objeto
            $dados->id = $this->db->insert_Id();
        }
        // Retorna o resultado da operação
        return $resultado;
    }

    // Método para excluir uma instância
    function excluir($id) {
        // SQL para excluir a instância com o ID fornecido
        $sql = "delete from instancia where id=" . $id;
        // Executa o delete
        $resultado = $this->db->Execute($sql);
        // Retorna o resultado da exclusão
        return $resultado;
    }

}
