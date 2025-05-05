<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Atendimento.php');
require_once('dto/Atendimento.php');
require_once('dto/Guiche.php');

class ManterAtendimento extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a $filtro order by a.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Atendimento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function listarRelatorio($filtro = "") {
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento, f.entrada, f.ultima_chamada, f.atendido, TIMESTAMPDIFF(MINUTE, f.ultima_chamada,  f.atendido) as tempo, TIMESTAMPDIFF(MINUTE, f.entrada,  f.ultima_chamada) as tempo_fila FROM atendimento as a, fila as f WHERE f.id=a.id_fila $filtro order by a.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Atendimento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
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
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getAtendimentoPorId($id) {
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Atendimento();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
        }
        return $dados;
    }
    function getAtendimentoPorFila($id_fila) {
        $sql = "select a.id,a.id_fila,a.id_guiche, a.id_usuario, a.detalhamento FROM atendimento as a WHERE a.id_fila=$id_fila";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Atendimento();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->fila            = $registro["id_fila"];
            $dados->guiche          = $registro["id_guiche"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->detalhamento    = $registro["detalhamento"];
        }
        return $dados;
    }
    function salvar(Atendimento $dados) {
        $sql = "insert into atendimento (id_fila,id_guiche,id_usuario,detalhamento) 
                values ('" . $dados->fila . "','" . $dados->guiche . "','" . $dados->usuario . "','" . $dados->detalhamento . "')";
        if ($dados->id > 0) {
            $sql = "update atendimento set id_fila='" . $dados->fila . "',id_guiche='" . $dados->guiche . "',id_usuario='" . $dados->usuario . "',detalhamento='" . $dados->detalhamento . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
            return $dados;
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
            return $dados;
        }
        return $resultado;
    }
    function salvarDetalhamento(Atendimento $dados) {
        $sql = "update atendimento set detalhamento='" . $dados->detalhamento . "' where id=$dados->id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from atendimento where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

