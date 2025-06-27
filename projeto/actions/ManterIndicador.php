<?php 
require_once 'Model.php';
require_once 'dto/Indicador.php';

Class ManterIndicador extends Model {

    function __construct(){
        parent::__construct();
    }

    function listar() {
        $sql         = "SELECT i.id, i.nome, i.unidade, i.id_objetivo FROM indicador as i";
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados             = new Indicador;
            $dados->id         = $registro['id'];
            $dados->nome       = $registro['nome'];
            $dados->unidade    = $registro['unidade'];
            $dados->objetivo   = $registro['objetivo'];
            $array_dados[]     = $dados;
        }
        return $array_dados;
    }

    function getIndicadorPorObjetivo($id = 0) {
        $sql = "SELECT i.id, i.nome, i.unidade, i.id_objetivo FROM indicador as i WHERE i.id_objetivo =" . $id;
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados             = new Indicador;
            $dados->id         = $registro['id'];
            $dados->nome       = $registro['nome'];
            $dados->unidade    = $registro['unidade'];
            $dados->objetivo   = $registro['objetivo'];
            $array_dados[]     = $dados;
        }
        return $array_dados;
    }

    function getIndicadorPorId($id = 0) {
        $sql = "SELECT id, nome, unidade, id_objetivo FROM indicador WHERE id=" . $id;
        $resultado   = $this->db->Execute($sql);
        while($registro = $resultado->fetchRow()) {
            $dados             = new Indicador;
            $dados->id         = $registro['id'];
            $dados->nome       = $registro['nome'];
            $dados->unidade    = $registro['unidade'];
            $dados->objetivo   = $registro['objetivo'];
    }
    return $dados;
}

    function salvar(Indicador $dados) {
        $sql = "INSERT INTO indicador(nome, unidade, id_objetivo) VALUES ('". $dados->nome ."','". $dados->unidade ."','". $dados->objetivo ."')";
        if ($dados->id > 0) {
            $sql = "UPDATE indicador SET nome='". $dados->nome ."', unidade='". $dados->unidade ."',id_objetivo='". $dados->objetivo ."' WHERE id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM indicador WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}