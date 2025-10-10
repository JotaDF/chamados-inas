<?php 
require_once('Model.php');
require_once('dto/TipoTarefa.php');

class ManterTipoTarefa extends Model {

    public function __construct() {
        parent::__construct();
    }


    function listar() {
        $sql = "SELECT id, nome FROM tipo_tarefa";
        $resultado = $this->db->query($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados  = new TipoTarefa();
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $array_dados [] = $dados;
        }
        return $array_dados;
    }

    function salvar(TipoTarefa $dados) {
        $sql = "INSERT INTO tipo_tarefa (nome) VALUES( '".$dados->nome."')";
        if($dados->id > 0) {
            $sql = "UPDATE tipo_tarefa SET nome='". $dados->nome ."' WHERE id=$dados->id";
             $resultado = $this->db->Execute($sql);
        } else {
             $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM tipo_tarefa WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}