<?php
require_once("Model.php");
require_once("dto/ProjetoUsuario.php");

class ManterProjetoUsuario extends Model {
    public function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT u.nome, pp.nome as perfil, p.id FROM usuario as u, perfil_projeto as pp, projeto as p, projeto_usuario as pu WHERE p.id = pu.id_projeto ";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new ProjetoUsuario();
            $dados->id_projeto = $registro["id_projeto"];
            $dados->id_usuario = $registro["id_usuario"];
            $dados->id_perfil_projeto = $registro["id_perfil_projeto"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getProjetoUsuarioPorId($id) {
        $sql = "SELECT u.id, u.nome, pp.nome as perfil, p.id FROM usuario as u, perfil_projeto as pp, projeto as p, projeto_usuario as pu WHERE pu.id_usuario = u.id AND pu.id_perfil_projeto = pp.id AND pu.id_projeto = p.id AND p.id = $id";
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
        if ($registro) {
            $dados = new ProjetoUsuario();
            $dados->id_projeto = $registro["id_projeto"];
            $dados->id_usuario = $registro["id_usuario"];
            $dados->id_perfil_projeto = $registro["id_perfil_projeto"];
            $dados->nome = $registro["nome"];
            $dados->perfil = $registro["perfil"];
            return $dados;
        }
        return null;
    }

    function salvar(ProjetoUsuario $dados) {
        $sql = "INSERT INTO projeto_usuario (id_projeto, id_usuario, id_perfil_projeto) VALUES('". $dados->id_projeto . "', '". $dados->id_usuario . "', '". $dados->id_perfil_projeto . "')";   
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }


    function excluir($id) {
        $sql = "DELETE FROM projeto_usuario WHERE id = $id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}