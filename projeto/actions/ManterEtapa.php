<?php

// Inclusão dos arquivos necessários para o funcionamento do código.
require_once('Model.php');
require_once('dto/Etapa.php');

class ManterEtapa extends Model {

    // Método construtor da classe, que chama o construtor da classe pai.
    function __construct() {
        parent::__construct();
    }

    // Função para listar as etapas, com a opção de filtro por tarefa.
    function listar($id_tarefa = 0) {

        // Consulta SQL para listar todas as etapas.
        $sql = "select e.id,e.nome,e.ordem,e.data_base,e.id_tarefa,e.mostrar,
                (SELECT SUM(aa.qtd_dias) FROM acao as aa WHERE aa.id_etapa=e.id ) as total_dias,
                (select count(*) from acao as a where a.id_etapa=e.id) as dep 
                FROM etapa as e order by e.ordem";

        // Se o ID da tarefa for maior que 0, filtra as etapas pela tarefa.
        if ($id_tarefa > 0) {
            $sql = "select e.id,e.nome,e.ordem,e.data_base,e.id_tarefa,e.mostrar,
                    (SELECT SUM(aa.qtd_dias) FROM acao as aa WHERE aa.id_etapa=e.id ) as total_dias,
                    (select count(*) from acao as a where a.id_etapa=e.id) as dep 
                    FROM etapa as e WHERE id_tarefa=" . $id_tarefa . " order by e.ordem";
        }

        // Executa a consulta e armazena o resultado.
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Loop para processar cada registro retornado e armazená-lo no array.
        while ($registro = $resultado->fetchRow()) {
            $dados = new Etapa();
            $dados->excluir = true; // Define que a etapa pode ser excluída por padrão.
            
            // Se houver dependentes (ações), a etapa não pode ser excluída.
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os valores do banco de dados aos atributos da classe Etapa.
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->ordem = $registro["ordem"];
            $dados->data_base = $registro["data_base"];
            $dados->tarefa = $registro["id_tarefa"];
            $dados->mostrar = $registro["mostrar"];
            $dados->total_dias = $registro["total_dias"];

            // Adiciona o objeto de dados ao array de resultados.
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Função para retornar uma etapa específica pelo seu ID.
    function getEtapaPorId($id) {
        // Consulta SQL para obter os detalhes de uma etapa específica.
        $sql = "select e.id,e.nome,e.ordem,e.data_base,e.id_tarefa,e.mostrar,
                (SELECT SUM(aa.qtd_dias) FROM acao as aa, etapa as ee WHERE aa.id_etapa=e.id ) as total_dias 
                FROM etapa as e WHERE id=$id";

        // Executa a consulta.
        $resultado = $this->db->Execute($sql);
        $dados = new Etapa();

        // Processa o registro retornado.
        while ($registro = $resultado->fetchRow()) {
            // Atribui os valores à etapa.
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->ordem = $registro["ordem"];
            $dados->data_base = $registro["data_base"];
            $dados->tarefa = $registro["id_tarefa"];
            $dados->mostrar = $registro["mostrar"];
            $dados->total_dias = $registro["total_dias"];
        }
        return $dados;
    }

    // Função para salvar uma etapa (inserir ou atualizar).
    function salvar(Etapa $dados) {
        // Se a data base não for informada, define como 0.
        if ($dados->data_base == '') {
            $dados->data_base = 0;
        }

        // SQL para inserir uma nova etapa.
        $sql = "insert into etapa (nome, ordem, data_base, id_tarefa) values ('" . $dados->nome . "','" . $dados->ordem . "','" . $dados->data_base . "','" . $dados->tarefa . "')";
        
        // Se a etapa já possui ID, realiza um update.
        if ($dados->id > 0) {
            $sql = "update etapa set nome='" . $dados->nome . "',ordem='" . $dados->ordem . "',data_base='" . $dados->data_base . "',id_tarefa='" . $dados->tarefa . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Se for uma nova etapa, insere no banco de dados.
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    // Função para excluir uma etapa.
    function excluir($id) {
        // SQL para excluir a etapa.
        $sql = "delete from etapa where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Função para alterar o campo "mostrar" de uma etapa (mostrar ou não).
    function mudaMostrar($id, $mostrar = 1) {
        $sql = "update etapa set mostrar=" . $mostrar  . " where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Função para subir a ordem de uma etapa dentro de uma tarefa.
    function sobeOrdem($id, $id_tarefa, $ordem_atual) {
        // Atualiza as etapas para mover a ordem.
        $sql_desc = "update etapa set ordem=(ordem+1) where ordem=" . ($ordem_atual - 1) . " AND id_tarefa=" . $id_tarefa;
        $sql_sobe = "update etapa set ordem=" . ($ordem_atual - 1) . " where id=$id";

        // Executa as atualizações.
        $resultado = $this->db->Execute($sql_desc);
        $resultado = $this->db->Execute($sql_sobe);
        return $resultado;
    }

    // Função para descer a ordem de uma etapa dentro de uma tarefa.
    function desceOrdem($id, $id_tarefa, $ordem_atual) {
        // Atualiza as etapas para mover a ordem.
        $sql_sobe = "update etapa set ordem=(ordem-1) where ordem=" . ($ordem_atual + 1) . " AND id_tarefa=" . $id_tarefa;
        $sql_desc = "update etapa set ordem=" . ($ordem_atual + 1) . " where id=$id";

        // Executa as atualizações.
        $resultado = $this->db->Execute($sql_sobe);
        $resultado = $this->db->Execute($sql_desc);
        return $resultado;
    }

}

