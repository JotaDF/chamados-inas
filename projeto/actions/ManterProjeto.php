<?php
require_once 'Model.php';
require_once 'dto/Projeto.php';
require_once 'dto/ProjetoUsuario.php';
class ManterProjeto extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listar()
    {
        $sql = "SELECT id, nome, descricao, tap, orcamento, status, id_objetivo, 
        ((SELECT COUNT(*) FROM projeto_usuario pu WHERE pu.id_projeto = p.id) + (SELECT COUNT(*) FROM arquivo a WHERE a.id_projeto = p.id) + (SELECT COUNT(*) FROM reporte r WHERE r.id_projeto = p.id) + (SELECT COUNT(*) FROM eap_item as e WHERE e.id_projeto = p.id) ) AS dep FROM projeto as p";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Projeto;
            $dados->excluir  = true;
            if($registro['dep'] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $dados->descricao = $registro['descricao'];
            $dados->tap = $registro['tap'];
            $dados->orcamento = $registro['orcamento'];
            $dados->status = $registro['status'];
            $dados->objetivo = $registro['id_objetivo'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getObjetivoPorId($id = 0)
    {
        $sql = "SELECT o.id, o.descricao, o.id_planejamento FROM objetivo as o WHERE o.id = " . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Objetivo;
            $dados->id = $registro['id'];
            $dados->descricao = $registro['descricao'];
            $dados->planejamento = $registro['id_planejamento'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getProjetoPorId($id = 0)
    {
        $sql = "SELECT id, nome, descricao, tap, orcamento, status, id_objetivo FROM projeto WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        $dados = new Projeto();
        if ($registro = $resultado->fetchRow()) {
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $dados->descricao = $registro['descricao'];
            $dados->tap = $registro['tap'];
            $dados->orcamento = $registro['orcamento'];
            $dados->status = $registro['status'];
            $dados->objetivo = $registro['id_objetivo'];
        }
        return $dados;
    }

    function getNomeProjetoPorId($id = 0) {
        $sql = "SELECT id, nome FROM projeto WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        $dados = new Projeto();
        if ($registro = $resultado->fetchRow()) {
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
        }
        return $dados;
    }

    function criaDirPorProjeto($id_projeto, $caminho_dir) {
        $dir = $caminho_dir . $id_projeto;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    function excluirDirProjeto($id_projeto, $caminho_dir) {
        $dir = $caminho_dir . $id_projeto; 
        if(is_dir($dir)) {
            rmdir($dir);
        }
    }

    function getUsuarioSemProjetoPorId($id) {
        $sql = "SELECT u.id, u.nome FROM usuario as u WHERE u.id NOT IN (SELECT pu.id_usuario FROM projeto_usuario as pu, projeto as p WHERE pu.id_projeto = p.id AND p.id = $id) ORDER BY u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getProjetoUsuarioPorId($id)
    {
        $sql = "SELECT u.id as id_usuario, u.nome, pp.nome as perfil, pp.id as id_perfil_projeto, p.id as id_projeto FROM usuario as u, perfil_projeto as pp, projeto as p, projeto_usuario as pu WHERE pu.id_usuario = u.id AND pu.id_perfil_projeto = pp.id AND pu.id_projeto = p.id AND p.id = $id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new ProjetoUsuario();
            $dados->id_projeto = $registro["id_projeto"];
            $dados->id_usuario = $registro["id_usuario"];
            $dados->id_perfil_projeto = $registro["id_perfil_projeto"];
            $dados->nome = $registro["nome"];
            $dados->perfil = $registro["perfil"];
            $array_dados[] = $dados;
            
        }
        return $array_dados;
    }

    function removeProjetoUsuario(ProjetoUsuario $dados) {
        $sql = "DELETE FROM projeto_usuario WHERE id_perfil_projeto = $dados->id_perfil_projeto AND id_usuario = $dados->id_usuario AND id_projeto = $dados->id_projeto";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function salvarProjetoUsuario(ProjetoUsuario $dados) {
        $sql = "INSERT INTO projeto_usuario (id_projeto, id_usuario, id_perfil_projeto) VALUES('". $dados->id_projeto . "', '". $dados->id_usuario . "', '". $dados->id_perfil_projeto . "')";   
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function salvar(Projeto $dados)
    {
        $sql = "INSERT INTO projeto(nome, descricao, tap, orcamento, id_objetivo, status) VALUES ('" . $dados->nome . "','" . $dados->descricao . "',
        '" . $dados->tap . "','" . $dados->orcamento . "','" . $dados->objetivo . "','" . $dados->status . "')";
        if ($dados->id > 0) {
            $sql = "UPDATE projeto SET nome='" . $dados->nome . "', descricao='" . $dados->descricao . "',tap='" . $dados->tap . "'
            ,orcamento='" . $dados->orcamento . "', id_objetivo='" . $dados->objetivo . "' WHERE id='" . $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id)
    {
        $sql = "DELETE FROM projeto WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}