<?php

// Requer os arquivos necessários para o funcionamento da classe
require_once('Model.php');
// require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Guiche.php'); // Comentado, caso seja necessário em outra parte do código
require_once('dto/Guiche.php');

// Classe que gerencia a manipulação dos guichês
class ManterGuiche extends Model {

    // Método construtor da classe
    function __construct() { 
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    // Método para listar todos os guichês e o número de atendimentos relacionados a cada guichê
    function listar() {
        // SQL para selecionar os guichês e o número de atendimentos relacionados (dep)
        $sql = "select g.id,g.numero,g.id_usuario, (select count(*) from atendimento as a where a.id_guiche=g.id) as dep FROM guiche as g order by g.numero";
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        // Inicializa um array para armazenar os dados
        $array_dados = array();
        // Itera sobre os registros retornados pela consulta
        while ($registro = $resultado->fetchRow()) {
            // Cria um objeto da classe Guiche
            $dados = new Guiche();
            $dados->excluir = true; // Define a flag de exclusão como verdadeira inicialmente
            // Se houver atendimentos, não permite a exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            // Atribui os valores das colunas do banco aos atributos do objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->usuario = $registro["id_usuario"];
            // Adiciona o objeto ao array de dados
            $array_dados[] = $dados;
        }
        // Retorna o array de dados
        return $array_dados;
    }

    // Método para buscar um guichê por seu id
    function getGuichePorId($id) {
        // SQL para selecionar um guichê com base no id
        $sql = "select g.id,g.numero,g.id_usuario FROM guiche as g WHERE id=$id";
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        // Cria um objeto da classe Guiche
        $dados = new Guiche();
        // Itera sobre o registro retornado
        while ($registro = $resultado->fetchRow()) {
            // Atribui os valores das colunas do banco aos atributos do objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->usuario = $registro["id_usuario"];
        }
        // Retorna o objeto com os dados do guichê
        return $dados;
    }

    // Método para buscar um guichê pelo id do usuário
    function getGuichePorUsuario($id_usuario) {
        // SQL para selecionar um guichê com base no id do usuário
        $sql = "select g.id,g.numero,g.id_usuario FROM guiche as g WHERE id_usuario=$id_usuario";
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        // Cria um objeto da classe Guiche
        $dados = new Guiche();
        // Itera sobre o registro retornado
        while ($registro = $resultado->fetchRow()) {
            // Atribui os valores das colunas do banco aos atributos do objeto
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->usuario = $registro["id_usuario"];
        }
        // Retorna o objeto com os dados do guichê
        return $dados;
    }

    // Método para salvar ou atualizar um guichê
    function salvar(Guiche $dados) {
        // SQL para inserir um novo guichê
        $sql = "insert into guiche (numero,id_usuario) values ('" . $dados->numero . "','" . $dados->usuario . "')";
        
        // Se o id já estiver preenchido, realiza a atualização do guichê
        if ($dados->id > 0) {
            $sql = "update guiche set numero='" . $dados->numero . "',id_usuario='" . $dados->usuario . "' where id=$dados->id";
            // Executa a consulta de atualização no banco
            $resultado = $this->db->Execute($sql);
        } else {
            // Executa a consulta de inserção no banco
            $resultado = $this->db->Execute($sql);
            // Recupera o id gerado para o novo guichê
            $dados->id = $this->db->insert_Id();
        }
        // Retorna o resultado da operação
        return $resultado;
    }

    // Método para excluir um guichê
    function excluir($id) {
        // SQL para excluir um guichê com base no id
        $sql = "delete from guiche where id=" . $id;
        // Executa a consulta de exclusão no banco
        $resultado = $this->db->Execute($sql);
        // Retorna o resultado da operação
        return $resultado;
    }

}
