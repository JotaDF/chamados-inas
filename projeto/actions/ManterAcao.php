<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');
require_once('ManterEtapa.php');
require_once('ManterTarefa.php');

require_once('dto/Acao.php');

class ManterAcao extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($id_etapa = 0) {

        $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE id_etapa=" . $id_etapa . " order by a.ordem";
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
    function listarAcoes($id_etapa = 0) {

        $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE a.tipo=1 order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE a.tipo=1 AND a.id_etapa=" . $id_etapa . " order by a.ordem";
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
    function listarNotas($id_etapa = 0) {

        $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE a.tipo=2 order by a.ordem";
        if ($id_etapa > 0) {
            $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE a.tipo=2 AND a.id_etapa=" . $id_etapa . " order by a.ordem";
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

    function getAcaoPorId($id) {
        $sql = "select a.id,a.tipo,a.acao,a.ordem,qtd_dias,a.data_check,a.data_prevista,a.id_etapa,a.id_usuario FROM acao as a WHERE id=$id";
        //echo $sql;
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

    function salvar(Acao $dados, $id_tarefa = 0) {
        if($dados->data_prevista == ''){
            $dados->data_prevista = 0;
        }
        if($dados->dias == ''){
            $dados->dias = 0;
        }

        $sql = "insert into acao (tipo, acao, ordem, qtd_dias, data_prevista, id_etapa) values (" . $dados->tipo . ",'" . $dados->acao . "','" . $dados->ordem . "','" . $dados->dias . "','" . $dados->data_prevista . "','" . $dados->etapa . "')";
        //echo $sql . "<BR/>";
        if ($dados->id > 0) {
            $sql = "update acao set tipo=" . $dados->tipo . ",acao='" . $dados->acao . "',ordem='" . $dados->ordem . "',qtd_dias='" . $dados->dias . "',data_prevista='" . $dados->data_prevista . "',id_etapa='" . $dados->etapa . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function sobeOrdem($id, $tipo, $id_etapa, $ordem_atual) {
        $sql_desc = "update acao set ordem=(ordem+1) where ordem=" . ($ordem_atual - 1) . " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $sql_sobe = "update acao set ordem=" . ($ordem_atual - 1) . " where  tipo=" . $tipo . " AND id=$id";
        
        $resultado = $this->db->Execute($sql_desc);
        $resultado = $this->db->Execute($sql_sobe);
        //echo $sql . "<BR/>";
        return $resultado;
    }
    function desceOrdem($id, $tipo, $id_etapa, $ordem_atual) {
        $sql_sobe = "update acao set ordem=(ordem-1) where ordem=" . ($ordem_atual + 1) . " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $sql_desc = "update acao set ordem=" . ($ordem_atual + 1) . " where  tipo=" . $tipo . " AND id=$id";

        $resultado = $this->db->Execute($sql_sobe);
        $resultado = $this->db->Execute($sql_desc);
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function checkAcao($id, $id_usuario, $prevista) {
        if($prevista == ''){
            $prevista = 0;
        }
        $date = new DateTime();
        $data_check = $date->getTimestamp();
        $sql = "update acao set data_check='" . $data_check . "',data_prevista='" . $prevista . "',id_usuario='" . $id_usuario . "' where id=$id";
        $resultado = $this->db->Execute($sql);
        return true;
    }

    function removeCheckAcao($id, $id_usuario, $prevista) {
        $date = new DateTime();
        $sql = "update acao set data_check=0 ,data_prevista='" . $prevista . "' ,id_usuario='" . $id_usuario . "' where id=$id";
        $resultado = $this->db->Execute($sql);
        return true;
    }

    function excluir($id, $tipo, $id_etapa, $ordem) {
        $sql_sobe = "update acao set ordem=(ordem-1) where ordem > " . $ordem. " AND tipo=" . $tipo . " AND id_etapa=" . $id_etapa;
        $resultado_sobe = $this->db->Execute($sql_sobe); // sobe a ordem das acoes que estão após a excluida
        $sql = "delete from acao where id=" . $id; 
        $resultado = $this->db->Execute($sql); // exclui a acao
        return $resultado;
    }

    function subitrair_dias_uteis($str_data, $int_qtd_dias_subitrair) {
        // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
        // Transforma para DATE - aaaa-mm-dd
        $str_data = substr($str_data, 0, 10);
        // Se a data estiver no formato brasileiro: dd/mm/aaaa
        // Converte-a para o padrão americano: aaaa-mm-dd
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

    function somar_dias_uteis($str_data, $int_qtd_dias_somar = 7) {

        // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
        // Transforma para DATE - aaaa-mm-dd
        $str_data = substr($str_data, 0, 10);
        // Se a data estiver no formato brasileiro: dd/mm/aaaa
        // Converte-a para o padrão americano: aaaa-mm-dd
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
