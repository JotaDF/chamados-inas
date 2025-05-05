<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Atendimento.php');
require_once('dto/Atendimento.php');
require_once('dto/Guiche.php');

class ManterAtendimento extends Model {

    function __construct() { // Método construtor
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar($filtro = "") {
        // Consulta SQL para listar os atendimentos com um filtro opcional
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a $filtro order by a.id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os dados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            $dados = new Atendimento(); // Cria um novo objeto Atendimento
            $dados->excluir = true; // Define que o atendimento pode ser excluído
            if ($registro["dep"] > 0) { // Se houver dependências, não pode excluir
                $dados->excluir = false; // Não pode excluir o atendimento
            }
            // Preenche os dados do atendimento com as informações do banco
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
            
            $array_dados[]      = $dados; // Adiciona o atendimento ao array de resultados
        }
        return $array_dados; // Retorna o array de atendimentos
    }

    function listarRelatorio($filtro = "") {
        // Consulta SQL para listar atendimentos com detalhes para relatórios
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento, f.entrada, f.ultima_chamada, f.atendido, 
                TIMESTAMPDIFF(MINUTE, f.ultima_chamada,  f.atendido) as tempo, 
                TIMESTAMPDIFF(MINUTE, f.entrada,  f.ultima_chamada) as tempo_fila 
                FROM atendimento as a, fila as f WHERE f.id=a.id_fila $filtro order by a.id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os dados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            $dados = new Atendimento(); // Cria um novo objeto Atendimento
            $dados->excluir = true; // Define que o atendimento pode ser excluído
            if ($registro["dep"] > 0) { // Se houver dependências, não pode excluir
                $dados->excluir = false; // Não pode excluir o atendimento
            }
            // Preenche os dados do atendimento com as informações do banco
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
            $dados->entrada         = $registro["entrada"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->atendido        = $registro["atendido"];
            $dados->tempo           = $registro["tempo"];
            $dados->tempo_fila      = $registro["tempo_fila"];
            
            $array_dados[]      = $dados; // Adiciona o atendimento ao array de resultados
        }
        return $array_dados; // Retorna o array de atendimentos com detalhes do relatório
    }

    function getAtendimentoPorId($id) {
        // Consulta SQL para buscar um atendimento específico pelo ID
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a WHERE id=$id";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Atendimento(); // Cria um novo objeto Atendimento
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            // Preenche os dados do atendimento com as informações do banco
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
        }
        return $dados; // Retorna o atendimento encontrado
    }

    function getAtendimentoPorFila($id_fila) {
        // Consulta SQL para buscar atendimentos por fila
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a WHERE a.id_fila=$id_fila";
        //echo $sql; // Descomente para depurar a consulta SQL.
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Atendimento(); // Cria um novo objeto Atendimento
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados da consulta
            // Preenche os dados do atendimento com as informações do banco
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
        }
        return $dados; // Retorna o atendimento encontrado
    }

    function salvar(Atendimento $dados) {
        // Consulta SQL para inserir um novo atendimento
        $sql = "insert into atendimento (id_fila,id_guiche,id_usuario,detalhamento) 
                values ('" . $dados->fila . "','" . $dados->guiche . "','" . $dados->usuario . "','" . $dados->detalhamento . "')";
        if ($dados->id > 0) { // Se o ID do atendimento for maior que 0, é um update
            $sql = "update atendimento set id_fila='" . $dados->fila . "',id_guiche='" . $dados->guiche . "',id_usuario='" . $dados->usuario . "',detalhamento='" . $dados->detalhamento . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
            return $dados; // Retorna os dados atualizados
        } else { // Se o ID for 0, é um insert
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado pela inserção
            return $dados; // Retorna os dados com o novo ID
        }
        return $resultado; // Retorna o resultado da operação
    }

    function salvarDetalhamento(Atendimento $dados) {
        // Consulta SQL para atualizar o detalhamento do atendimento
        $sql = "update atendimento set detalhamento='" . $dados->detalhamento . "' where id=$dados->id";
        $resultado = $this->db->Execute($sql); // Executa o update
        return $resultado; // Retorna o resultado da atualização
    }

    function excluir($id) {
        // Consulta SQL para excluir um atendimento pelo ID
        $sql = "delete from atendimento where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }
}
