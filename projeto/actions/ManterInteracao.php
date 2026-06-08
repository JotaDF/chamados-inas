<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');

require_once('dto/Interacao.php');

class ManterInteracao extends Model
{

    const PREFIXO_REABERTURA = "Chamado reaberto!";
    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar($id_chamado = 0)
    {
        $sql = "select i.id, i.texto, i.data, i.id_chamado, i.id_usuario FROM interacao as i WHERE i.id_chamado =$id_chamado order by i.id DESC";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Interacao();
            $dados->excluir = false;

            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->data = isset($registro["data"]) ? $registro["data"] : 0;
            $dados->chamado = $registro["id_chamado"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getInteracaoPorId($id)
    {
        $sql = "select i.id, i.texto, i.data, i.id_chamado, i.id_usuario FROM interacao as i WHERE i.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Interacao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->data = isset($registro["data"]) ? $registro["data"] : 0;
            $dados->chamado = $registro["id_chamado"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados;
    }

    function salvar(Interacao $dados)
    {
        $sql = "insert into interacao (texto, data, id_chamado, id_usuario) values ('" . $dados->texto . "',now(),'" . $dados->chamado . "','" . $dados->usuario . "')";
        if ($dados->id > 0) {
            $sql = "update acao set texto='" . $dados->texto . "',data=now(),id_chamado='" . $dados->chamado . "',id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function verificaChamadoFoiReaberto(string $texto)
    {
        return strpos($texto, self::PREFIXO_REABERTURA) !== false;
    }

    public function extrairMotivo(string $texto)
    {
        return trim(
            str_replace(self::PREFIXO_REABERTURA, '<br/>', $texto)
        );
    }

    function getMotivoReabertura(int $id_chamado)
    {
        $sql = "SELECT texto, data FROM interacao WHERE id_chamado = $id_chamado order by data desc limit 1";
        $resultado = $this->db->Execute($sql);
        $motivo = $resultado->fetchRow();
        $texto = "";
        if ($this->verificaChamadoFoiReaberto($motivo['texto'])) {
            return $texto = $this->extrairMotivo($motivo['texto']);
        }
        return null;
    }
    function excluir($id)
    {
        $sql = "delete from interacao where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}
