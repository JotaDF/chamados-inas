<?php

require_once('Model.php');
require_once('dto/Assunto.php');

class ManterAssunto extends Model {

    function __construct() { // Método construtor
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar($filtro="") {
        // Consulta SQL para listar todos os assuntos, com um filtro opcional.
        // Também é retornado o número de processos relacionados a cada assunto (campo 'dep')
        $sql = "select a.id,a.assunto, (select count(*) from processo as p where p.id_assunto=a.id) as dep FROM assunto as a $filtro order by a.assunto";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os dados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            $dados = new Assunto(); // Cria um novo objeto Assunto
            $dados->excluir = true; // Define que o assunto pode ser excluído
            if ($registro["dep"] > 0) { // Se houver processos associados
                $dados->excluir = false; // Não pode excluir o assunto
            }
            // Preenche os dados do assunto com as informações do banco
            $dados->id          = $registro["id"];
            $dados->assunto     = $registro["assunto"];
            $array_dados[]      = $dados; // Adiciona o assunto ao array de resultados
        }
        return $array_dados; // Retorna o array de assuntos
    }

    function getAssuntoPorId($id) {
        // Consulta SQL para buscar um assunto específico pelo ID
        $sql = "select a.id,a.assunto FROM assunto as a WHERE id=$id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Assunto(); // Cria um novo objeto Assunto
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            // Preenche os dados do assunto com as informações do banco
            $dados->id          = $registro["id"];
            $dados->assunto     = $registro["assunto"];
        }
        return $dados; // Retorna o assunto encontrado
    }

    function salvar(Assunto $dados) {
        // Verifica se o assunto já possui um ID
        $sql = "insert into assunto (assunto) values ('" . $dados->assunto . "')";
        if ($dados->id > 0) { // Se o ID do assunto for maior que 0, é um update
            $sql = "update assunto set assunto='" . $dados->assunto . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
        } else { // Se o ID for 0, é um insert
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado pela inserção
        }
        return $dados; // Retorna o objeto Assunto com o ID atualizado
    }

    function excluir($id) {
        // Consulta SQL para deletar o assunto com o ID fornecido
        $sql = "delete from assunto where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }
}
