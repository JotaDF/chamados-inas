<?php
require_once('Model.php');
require_once('dto/FeriadoAno.php');

class ManterFeriadoAno extends Model
{

    function __construct()
    { 
        parent::__construct();
    }


    function lista() {
        $sql = "SELECT id, data, descricao FROM feriado_ano";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados        = new FeriadoAno();
            $dados->id    = $registro['id'];
            $dados->data  = $registro['data'];
            $dados->descricao  = $registro['descricao'];
            $array_dados[]  = $dados;
        }
        return $array_dados;
    }

    function salvar(FeriadoAno $dados) {
        $sql = "INSERT INTO feriado_ano (data, descricao) VALUES('". $dados->data ."', '". $dados->descricao ."')";
        if($dados->id > 0) {
            $sql = "UPDATE feriado_ano SET data='". $dados->data ."', descricao='". $dados->descricao ."' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM feriado_ano WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}
