<?php

// Importa a classe base Model que contém funcionalidades de conexão e execução no banco de dados
require_once('Model.php');
// Importa o DTO que representa os dados de uma ocorrência de nota
require_once('dto/OcorrenciaNota.php');

// Classe responsável por gerenciar operações relacionadas à tabela 'ocorrencia_nota'
class ManterOcorrenciaNota extends Model {

    // Construtor da classe que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Função que lista todas as ocorrências de nota com base em um filtro opcional
    function listar($filtro = "") {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o $filtro order by o.id";
        // Executa a query no banco de dados
        $resultado = $this->db->Execute($sql);
        $array_dados = array(); // Array para armazenar os resultados

        // Itera sobre os registros retornados
        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota(); // Cria novo objeto DTO
            // Preenche os dados do objeto com os valores do registro
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            // Adiciona o objeto no array de retorno
            $array_dados[] = $dados;
        }
        return $array_dados; // Retorna lista de objetos
    }
    
    // Função que busca uma ocorrência pelo ID
    function getOcorrenciaNotaPorId($id) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new OcorrenciaNota(); // Objeto para armazenar resultado

        // Preenche os dados do objeto se houver resultado
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
        }
        return $dados; // Retorna o objeto preenchido
    }

    // Lista todas as ocorrências vinculadas a uma nota de glosa
    function getOcorrenciasPorIdNotaGlosa($id_nota_glosa) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id_nota_glosa=".$id_nota_glosa." order by o.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota();
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Lista todas as ocorrências vinculadas a uma nota de pagamento
    function getOcorrenciasPorIdNotaPagamento($id_nota_pagamento) {
        $sql = "select o.id, o.descricao,	o.resolvido, o.id_nota_glosa, o.id_nota_pagamento, o.data, o.autor FROM ocorrencia_nota as o WHERE o.id_nota_pagamento=".$id_nota_pagamento." order by o.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new OcorrenciaNota();
            $dados->id              = $registro["id"];
            $dados->descricao       = $registro["descricao"];
            $dados->resolvido       = $registro["resolvido"];
            $dados->nota_glosa      = $registro["id_nota_glosa"];
            $dados->nota_pagamento  = $registro["id_nota_pagamento"];
            $dados->data            = $registro["data"];
            $dados->autor           = $registro["autor"];
            
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Salva ou atualiza uma ocorrência
    function salvar(OcorrenciaNota $dados) {
        // Verifica se está vinculada a nota de pagamento
        $sql = "insert into ocorrencia_nota (descricao,resolvido,id_nota_pagamento,data,autor)
                values ('" . $dados->descricao . "',0," . $dados->nota_pagamento . ",now()," . $dados->autor . ")";

        // Se for nota de glosa, sobrescreve o SQL anterior com insert correspondente
        if($dados->nota_glosa > 0){
            $sql = "insert into ocorrencia_nota (descricao,resolvido,id_nota_glosa,data,autor)
                values ('" . $dados->descricao . "',0," . $dados->nota_glosa . ",now()," . $dados->autor . ")";
        }

        // Se for uma atualização (já tem ID), executa um update
        if ($dados->id > 0) {
            $sql = "update ocorrencia_nota set descricao='" . $dados->descricao . "',data=now(),autor='" . $dados->autor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
            return $dados;
        } else {
            // Caso contrário, executa o insert
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Pega o ID inserido
            return $dados;
        }
        return $resultado; // (este return nunca será executado, pois há return acima)
    }

    // Exclui uma ocorrência com base no ID
    function excluir($id) {
        $sql = "delete from ocorrencia_nota where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Marca uma ocorrência como resolvida (resolvido = 1)
    function resolver($id) {
        $sql = "update ocorrencia_nota set resolvido = 1 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Marca uma ocorrência como não resolvida (resolvido = 0)
    function desresolver($id) {
        $sql = "update ocorrencia_nota set resolvido = 0 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}
