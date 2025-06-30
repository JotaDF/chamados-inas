<?php
include 'actions/Model.php';
include 'dto/Projeto.php';
class ManterProjeto extends Model
{
    function __construct(){
        parent::__construct();
    }

    function listar(){
        $sql = "SELECT id, nome, descricao, tap, orcamento, status, id_objetivo FROM projeto";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados            = new Projeto;
            $dados->id        = $registro['id'];
            $dados->nome      = $registro['nome'];
            $dados->descricao = $registro['descricao'];
            $dados->tap       = $registro['tap'];
            $dados->orcamento = $registro['status'];
            $dados->objetivo  = $registro['orcamento'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
        function getObjetivo() {
        $sql       = "SELECT o.id, o.descricao, o.id_planejamento FROM objetivo as o";
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
    

    function salvar(Projeto $dados){
        $sql = "INSERT INTO projeto(nome, descricao, tap, orcamento, status, id_objetivo) VALUES ('" . $dados->nome . "','" . $dados->descricao . "',
        '" . $dados->tap . "','" . $dados->orcamento . "','" . $dados->status . "','" . $dados->objetivo . "')";
        if ($dados->id > 0) {
            $sql = "UPDATE projeto SET nome='" . $dados->nome . "', descricao='" . $dados->descricao . "',tap='" . $dados->tap . "'
            ,orcamento='" . $dados->orcamento . "',status='" . $dados->status . "',id_objetivo='" . $dados->objetivo . "' WHERE id='" . $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir ($id) {
        $sql = "DELETE FROM projeto WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado; 
    }
}