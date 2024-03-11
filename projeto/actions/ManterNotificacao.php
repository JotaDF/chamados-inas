<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');
require_once('ManterEtapn.php');
require_once('ManterTarefn.php');

require_once('dto/Notificacao.php');

class ManterNotificacao extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($lida = 2) {

        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n order by n.data";
        if ($lida < 2) {
            $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE lida=" . $lida . " order by n.data";
        }

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Notificacao();
            $dados->excluir = true;

            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    
    function listarPorUsuario($id_usuario, $lida = 2) {

        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id_usuario= ".$id_usuario." order by n.data";
        if ($lida < 2) {
            $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id_usuario= ".$id_usuario." AND lida=" . $lida . " order by n.data";
        }

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Notificacao();
            $dados->excluir = true;

            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getNotificacaoPorId($id) {
        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Notificacao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados;
    }
    function getTotalNotificacaoUsuario($id) {
        $sql = "select count(*) total FROM notificacao as n WHERE n.id_usuario=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $total = 0;
        if ($registro = $resultado->fetchRow()) {
            $total = $registro["total"];
        }
        return $total;
    }
    function salvar(Notificacao $dados) {

        $sql = "insert into notificacao (texto, link, tipo,id_usuario, lida, data) values ('" . $dados->texto . "','" . $dados->link . "','" . $dados->tipo . "','" . $dados->usuario . "',0,now())";
        //echo $sql . "<BR/>";
        if ($dados->id > 0) {
            $sql = "update notificacao set texto='" . $dados->texto . "',link='" . $dados->link . "',tipo='" . $dados->tipo . "',id_usuario='" . $dados->usuario . "',lida='" . $dados->lida . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function ler($id) {
        $sql= "update notificacao set lida=1 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        //echo $sql . "<BR/>";
        return $resultado;
    }

}
