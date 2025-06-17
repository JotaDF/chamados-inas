<?php 
require_once 'Model.php';
require_once 'dto/Planejamento.php';

Class ManterPlanejamento extends Model {

      function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql         = "SELECT p.id, p.nome, p.ano_inicio, p.ano_fim, p.missao, p.visao FROM planejamento as p";
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new Planejamento;
            $dados->id              = $registro['id'];
            $dados->nome            = $registro['nome'];
            $dados->ano_inicio      = $registro['ano_inicio'];
            $dados->ano_fim         = $registro['ano_fim'];
            $dados->missao          = $registro['missao'];
            $dados->visao           = $registro['visao'];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }

    function salvar(Planejamento $dados) {
        $sql = "INSERT INTO planejamento(nome, ano_inicio, ano_fim, missao, visao) VALUES ('". $dados->nome ."','" . $dados->ano_inicio ."',
        '". $dados->ano_fim ."','". $dados->missao ."','". $dados->visao ."')";
        if ($dados->id > 0) {
            $sql = "UPDATE planejamento SET nome='". $dados->nome ."',ano_inicio='" . $dados->ano_inicio . "',ano_fim='". $dados->ano_fim ."',
            missao='". $dados->missao ."',visao='". $dados->visao ."' WHERE id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM planejamento WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}