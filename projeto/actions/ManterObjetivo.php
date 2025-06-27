<?php 
require_once 'Model.php';
require_once 'dto/Objetivo.php';

Class ManterObjetivo extends Model {

    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql         = "SELECT o.id, o.descricao, o.id_planejamento FROM objetivo as o";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                  = new Objetivo;
            $dados->id              = $registro['id'];
            $dados->descricao       = $registro['descricao'];
            $dados->planejamento    = $registro['id_planejamento'];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }

    function getObjetivoPorIdPlanejamento($id = 0) {
        $sql = "SELECT o.id, o.descricao, o.id_planejamento, (SELECT COUNT(*) FROM indicador as i WHERE i.id_objetivo = o.id) as dep FROM objetivo as o WHERE id_planejamento =" . $id;
        $resultado  = $this->db->Execute($sql);
        $array_dados = array();
        while($registro  = $resultado->fetchRow()) {
            $dados =   new Objetivo;
            $dados->excluir      = true;
            if($registro['dep'] > 0) {
                $dados->excluir  = false;
            }
            $dados->id           = $registro['id'];
            $dados->descricao    = $registro['descricao'];
            $array_dados[]       = $dados;
        }
        return $array_dados;
    }

    function getObjetivoPorId($id = 0) {
        $sql = "SELECT id, descricao, id_planejamento FROM objetivo WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        while ($registro = $resultado->fetchRow()) {
            $dados               = new Objetivo;
            $dados->id           = $registro['id'];
            $dados->descricao    = $registro['descricao'];
            $dados->planejamento = $registro['id_planejamento'];
        }
        return $dados;
    }

    function salvar(Objetivo $dados) {
        $sql = "INSERT INTO objetivo(descricao, id_planejamento) VALUES ('". $dados->descricao ."','". $dados->planejamento . "')";
        if ($dados->id > 0) {
            $sql = "UPDATE objetivo SET descricao='". $dados->descricao ."', id_planejamento='". $dados->planejamento . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM objetivo WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}