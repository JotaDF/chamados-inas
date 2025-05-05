<?php

require_once('Model.php'); // Inclui a classe base de conexão com o banco de dados
require_once('dto/ValorProcesso.php'); // Inclui o DTO que representa os dados de um valor de processo

class ManterValorProcesso extends Model {

    function __construct() { // Método construtor que chama o construtor da classe pai (Model)
        parent::__construct();
    }

    function listar($filtro = "") {
        // Consulta os valores de processos com possível filtro, ordenando por ID
        $sql = "select vp.id,vp.id_tipo_valor,vp.id_processo, vp.valor, vp.data_pagamento, vp.cadastro FROM valor_processo as vp $filtro order by vp.id";
        $resultado = $this->db->Execute($sql); // Executa a query
        $array_dados = array(); // Array para armazenar os resultados

        while ($registro = $resultado->fetchRow()) { // Percorre os registros retornados
            $dados = new ValorProcesso(); // Cria um novo objeto DTO
            $dados->excluir = true; // Flag para permitir exclusão (pode ser usada na view)

            // Atribui os valores vindos do banco de dados ao objeto DTO
            $dados->id              = $registro["id"];
            $dados->id_tipo_valor   = $registro["id_tipo_valor"];
            $dados->id_processo     = $registro["id_processo"];
            $dados->valor           = $registro["valor"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->cadastro        = $registro["cadastro"];
            
            $array_dados[] = $dados; // Adiciona o objeto no array
        }

        return $array_dados; // Retorna todos os objetos montados
    }

    function getValorProcessoPorId($id) {
        // Consulta um valor de processo específico pelo ID
        $sql = "select vp.id,vp.id_tipo_valor,vp.id_processo, vp.valor, vp.data_pagamento, vp.cadastro FROM valor_processo as vp WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a query
        $dados = new ValorProcesso(); // Cria o objeto DTO

        while ($registro = $resultado->fetchRow()) {
            // Atribui os dados do registro ao objeto
            $dados->id              = $registro["id"];
            $dados->id_tipo_valor   = $registro["id_tipo_valor"];
            $dados->id_processo     = $registro["id_processo"];
            $dados->valor           = $registro["valor"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->cadastro        = $registro["cadastro"];
        }

        return $dados; // Retorna o objeto preenchido
    }

    function salvar(ValorProcesso $dados) {
        // Monta a SQL de inserção se for novo (id = 0)
        $sql = "insert into valor_processo (id_tipo_valor,id_processo,valor,data_pagamento,cadastro) 
                values ('" . $dados->id_tipo_valor . "','" . $dados->id_processo . "','" . $dados->valor . "'," . $dados->data_pagamento . ",now())";

        if ($dados->id > 0) {
            // Se já existir, monta a SQL de atualização
            $sql = "update valor_processo set id_tipo_valor='" . $dados->id_tipo_valor . "',id_processo='" . $dados->id_processo . "',valor='" . $dados->valor . "',data_pagamento='" . $dados->data_pagamento . "',cadastro=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa update
            return $dados;
        } else {
            // Executa inserção
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado
            return $dados;
        }

        return $resultado; // (redundante aqui, pois os returns acima já saem antes)
    }

    function excluir($id) {
        // Exclui o valor de processo com o ID informado
        $sql = "delete from valor_processo where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da execução
    }

}
