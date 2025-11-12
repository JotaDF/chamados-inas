<?php
require_once('Model.php');
require_once('dto/MedicoPerito.php');
class ManterMedicoPerito extends Model {
    
    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT id, nome FROM medico_perito";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new MedicoPerito();
            $dados->id   = $registro['id'];
            $dados->nome = $registro['nome'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function salvar(MedicoPerito $dados) {
        $sql = "INSERT INTO medico_perito (id, nome) values('" . $dados->id ."', '". $dados->nome ."')";
        if($dados->id > 0) {
            $sql = "update medico_perito set nome='" . $dados->nome ."' WHERE id='". $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    function excluir($id) {
       $sql = "DELETE FROM medico_perito WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}