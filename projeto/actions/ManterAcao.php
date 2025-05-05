<?php

// Define o fuso horário padrão como São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Importa os arquivos necessários para funcionamento da classe
require_once('Model.php');
require_once('ManterEtapa.php');
require_once('ManterTarefa.php');
require_once('dto/Acao.php');

// Classe ManterAcao herda funcionalidades da classe Model
class ManterAcao extends Model {

    // Construtor da classe que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Lista todas as ações, podendo filtrar por ID de etapa
    function listar($id_etapa = 0) {
        // Monta a query SQL com ou sem filtro de etapa
        $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,
                (select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,
                    (select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE id_etapa=" . $id_etapa . " order by a.ordem";
        }

        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera pelos resultados e instancia objetos Acao com os dados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Acao();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            // Atribui os valores aos atributos da classe DTO
            $dados->id = $registro["id"];
            $dados->tipo = $registro["tipo"];
            $dados->acao = $registro["acao"];
            $dados->ordem = $registro["ordem"];
            $dados->data_check = $registro["data_check"];
            $dados->data_prevista = $registro["data_prevista"];
            $dados->etapa = $registro["id_etapa"];
            $dados->dias = $registro["qtd_dias"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Lista apenas ações do tipo 1
    function listarAcoes($id_etapa = 0) {
        $sql = "select ... FROM acao as a WHERE a.tipo=1 order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select ... WHERE a.tipo=1 AND a.id_etapa=" . $id_etapa . " order by a.ordem";
        }

        // Repetição do processo de listagem com filtro de tipo
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Acao();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->tipo = $registro["tipo"];
            $dados->acao = $registro["acao"];
            $dados->ordem = $registro["ordem"];
            $dados->data_check = $registro["data_check"];
            $dados->data_prevista = $registro["data_prevista"];
            $dados->etapa = $registro["id_etapa"];
            $dados->dias = $registro["qtd_dias"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Lista apenas ações do tipo 2 (notas)
    function listarNotas($id_etapa = 0) {
        $sql = "select ... WHERE a.tipo=2 order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select ... WHERE a.tipo=2 AND a.id_etapa=" . $id_etapa . " order by a.ordem";
        }

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Acao();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->tipo = $registro["tipo"];
            $dados->acao = $registro["acao"];
            $dados->ordem = $registro["ordem"];
            $dados->data_check = $registro["data_check"];
            $dados->data_prevista = $registro["data_prevista"];
            $dados->etapa = $registro["id_etapa"];
            $dados->dias = $registro["qtd_dias"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna uma ação específica pelo ID
    function getAcaoPorId($id) {
        $sql = "select ... WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new Acao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->tipo = $registro["tipo"];
            $dados->acao = $registro["acao"];
            $dados->ordem = $registro["ordem"];
            $dados->data_check = $registro["data_check"];
            $dados->data_prevista = $registro["data_prevista"];
            $dados->etapa = $registro["id_etapa"];
            $dados->dias = $registro["qtd_dias"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados;
    }

    // Insere ou atualiza uma ação no banco de dados
    function salvar(Acao $dados, $id_tarefa = 0) {
        // Preenche valores vazios
        if($dados->data_prevista == ''){ $dados->data_prevista = 0; }
        if($dados->dias == ''){ $dados->dias = 0; }

        $sql = "insert into acao (...) values (...)";
        if ($dados->id > 0) {
            $sql = "update acao set ... where id=$dados->id";
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    // Troca ordem de uma ação com a anterior (sobe)
    function sobeOrdem($id, $tipo, $id_etapa, $ordem_atual) {
        $sql_desc = "update acao set ordem=(ordem+1) where ordem=" . ($ordem_atual - 1) . " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $sql_sobe = "update acao set ordem=" . ($ordem_atual - 1) . " where  tipo=" . $tipo . " AND id=$id";
        $resultado = $this->db->Execute($sql_desc);
        $resultado = $this->db->Execute($sql_sobe);
        return $resultado;
    }

    // Troca ordem de uma ação com a posterior (desce)
    function desceOrdem($id, $tipo, $id_etapa, $ordem_atual) {
        $sql_sobe = "update acao set ordem=(ordem-1) where ordem=" . ($ordem_atual + 1) . " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $sql_desc = "update acao set ordem=" . ($ordem_atual + 1) . " where  tipo=" . $tipo . " AND id=$id";
        $resultado = $this->db->Execute($sql_sobe);
        $resultado = $this->db->Execute($sql_desc);
        return $resultado;
    }

    // Marca uma ação como checada
    function checkAcao($id, $id_usuario, $prevista) {
        if($prevista == ''){ $prevista = 0; }
        $date = new DateTime();
        $data_check = $date->getTimestamp();
        $sql = "update acao set data_check='" . $data_check . "',data_prevista='" . $prevista . "',id_usuario='" . $id_usuario . "' where id=$id";
        $resultado = $this->db->Execute($sql);
        return true;
    }

    // Remove a checagem de uma ação
    function removeCheckAcao($id, $id_usuario, $prevista) {
        $sql = "update acao set data_check=0 ,data_prevista='" . $prevista . "' ,id_usuario='" . $id_usuario . "' where id=$id";
        $resultado = $this->db->Execute($sql);
        return true;
    }

    // Exclui uma ação e reorganiza a ordem das demais
    function excluir($id, $tipo, $id_etapa, $ordem) {
        $sql_sobe = "update acao set ordem=(ordem-1) where ordem > " . $ordem. " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $resultado_sobe = $this->db->Execute($sql_sobe);
        $sql = "delete from acao where id=" . $id; 
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Subtrai dias úteis de uma data
    function subitrair_dias_uteis($str_data, $int_qtd_dias_subitrair) {
        $str_data = substr($str_data, 0, 10);
        if (preg_match("@/@", $str_data) == 1) {
            $str_data = implode("-", array_reverse(explode("/", $str_data)));
        }
        $array_data = explode('-', $str_data);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;
        while ($int_qtd_dias_uteis < $int_qtd_dias_subitrair) {
            $count_days++;
            if (( $dias_da_semana = gmdate('w', strtotime('-' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6') {
                $int_qtd_dias_uteis++;
            }
        }
        return strtotime('-' . $count_days . ' day', strtotime($str_data));
    }

    // Soma dias úteis a uma data
    function somar_dias_uteis($str_data, $int_qtd_dias_somar = 7) {
        $str_data = substr($str_data, 0, 10);
        if (preg_match("@/@", $str_data) == 1) {
            $str_data = implode("-", array_reverse(explode("/", $str_data)));
        }
        $array_data = explode('-', $str_data);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;
        while ($int_qtd_dias_uteis < $int_qtd_dias_somar) {
            $count_days++;
            if (( $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6') {
                $int_qtd_dias_uteis++;
            }
        }
        return strtotime('+' . $count_days . ' day', strtotime($str_data));
    }

}
