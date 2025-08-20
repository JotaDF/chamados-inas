<?php 
require_once 'Model.php';
require_once 'dto/PerfilProjeto.php';

class ManterPerfilProjeto extends Model {

    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT pp.id, pp.nome, (SELECT COUNT(*) FROM projeto_usuario) as dep FROM perfil_projeto AS pp";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new PerfilProjeto();
            $dados->excluir = true;
            if($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id      = $registro["id"];
            $dados->nome    = $registro["nome"];
            $array_dados[]  = $dados;
        }
        return $array_dados;
    }

    function salvar(PerfilProjeto $dados) {
        $sql = "INSERT INTO perfil_projeto (nome) VALUES ('" . $dados->nome . "')";
        if($dados->id > 0) {
            $sql = "UPDATE perfil_projeto SET nome='" . $dados->nome . "' WHERE id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM perfil_projeto WHERE id=" . $id;
        return $this->db->Execute($sql);
    }
}