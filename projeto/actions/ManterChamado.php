<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');

require_once('dto/Chamado.php');
require_once('dto/Usuario.php');

class ManterChamado extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select id,descricao,data_abertura, data_atendido,data_atendimento,data_cancelado,status,id_categoria,id_usuario,id_atendente, (select count(*) from interacao as i where i.id_chamado=c.id) as dep FROM chamado as c " . $filtro . " ORDER BY id DESC";
        //echo 'SQL: ' . $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Chamado();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->data_abertura = isset($registro["data_abertura"]) ? $registro["data_abertura"] : 0;
            $dados->data_atendido = isset($registro["data_atendido"]) ? $registro["data_atendido"] : 0;;
            $dados->data_atendimento = isset($registro["data_atendimento"]) ? $registro["data_atendimento"] : 0;;
            $dados->data_cancelado = isset($registro["data_cancelado"]) ? $registro["data_cancelado"] : 0;;
            $dados->status = $registro["status"];
            $dados->categoria = $registro["id_categoria"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atendente = $registro["id_atendente"];
            $dados->tempo = $registro["tempo"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function listaRelatorio($filtro = "") {
        $sql = "select id,descricao,data_abertura, data_atendido,data_atendimento,data_cancelado,status,id_categoria,id_usuario,id_atendente, TIMESTAMPDIFF(MINUTE, data_abertura,  data_atendido) as tempo, (select count(*) from interacao as i where i.id_chamado=c.id) as dep FROM chamado as c " . $filtro . " ORDER BY id DESC";
        //echo 'SQL: ' . $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Chamado();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->data_abertura = isset($registro["data_abertura"]) ? $registro["data_abertura"] : 0;
            $dados->data_atendido = isset($registro["data_atendido"]) ? $registro["data_atendido"] : 0;;
            $dados->data_atendimento = isset($registro["data_atendimento"]) ? $registro["data_atendimento"] : 0;;
            $dados->data_cancelado = isset($registro["data_cancelado"]) ? $registro["data_cancelado"] : 0;;
            $dados->status = $registro["status"];
            $dados->categoria = $registro["id_categoria"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atendente = $registro["id_atendente"];
            $dados->tempo = $registro["tempo"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getChamadoPorId($id) {
        $sql = "select id,descricao,data_abertura, data_atendido,data_atendimento,data_cancelado,status,id_categoria,id_usuario,id_atendente FROM chamado as c WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Chamado();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->data_abertura = isset($registro["data_abertura"]) ? $registro["data_abertura"] : 0;
            $dados->data_atendido = isset($registro["data_atendido"]) ? $registro["data_atendido"] : 0;
            $dados->data_atendimento = isset($registro["data_atendimento"]) ? $registro["data_atendimento"] : 0;
            $dados->data_cancelado = isset($registro["data_cancelado"]) ? $registro["data_cancelado"] : 0;
            $dados->status = $registro["status"];
            $dados->categoria = $registro["id_categoria"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atendente = $registro["id_atendente"];
        }
        return $dados;
    }

    function salvar(Chamado $dados) {
        $sql = "insert into chamado (descricao,data_abertura,id_usuario,id_categoria) values ('" . $dados->descricao . "',now()," . $dados->usuario . ",1)";
        //echo $sql . "<BR/>";
        if ($dados->id > 0) {
            $sql = "update chamado set descricao='" . $dados->descricao . "',data_abertura=now(),id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }
    function atender(Chamado $dados) {
        if ($dados->id > 0) {
            $sql = "update chamado set id_categoria='" . $dados->categoria . "', id_atendente='" . $dados->atendente . "', status=1, data_atendimento=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }
    function concluir($id) {
        if ($id > 0) {
            $sql = "update chamado set status=2, data_atendido=now() where id=$id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }
    function cancelar($id) {
        if ($id > 0) {
            $sql = "update chamado set status=3, data_cancelado=now() where id=$id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }
    function reabrir($id) {
        if ($id > 0) {
            $sql = "update chamado set status=4, data_reaberto=now() where id=$id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }
    function excluir($id) {
        $sql = "delete from chamado where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}
