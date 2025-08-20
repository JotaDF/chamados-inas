<?php 
require_once 'Model.php';
require_once 'dto/Indicador.php';

Class ManterIndicador extends Model {

    function __construct(){
        parent::__construct();
    }

    function listar() {
        $sql         = "SELECT i.id, i.nome, i.unidade, i.indicador_desempenho, i.metodologia, i.periodicidade, i.tendencia, i.fonte, i.linha_base, i.id_objetivo FROM indicador as i";
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados                       = new Indicador;
            $dados->id                   = $registro['id'];
            $dados->nome                 = $registro['nome'];
            $dados->unidade              = $registro['unidade'];
            $dados->indicador_desempenho = $registro['indicador_desempenho'];
            $dados->metodologia          = $registro['metodologia'];
            $dados->periodicidade        = $registro['periodicidade'];
            $dados->tendencia            = $registro['tendencia'];   
            $dados->fonte                = $registro['fonte'];
            $dados->linha_base           = $registro['linha_base'];
            $dados->objetivo             = $registro['objetivo'];
            $array_dados[]               = $dados;
        }
        return $array_dados;
    }

    function getIndicadorPorObjetivo($id = 0) {
        $sql = "SELECT i.id, i.nome, i.unidade,i.unidade, i.indicador_desempenho, i.metodologia, i.periodicidade, i.tendencia, i.fonte, i.linha_base,  i.id_objetivo, (SELECT COUNT(*) FROM meta as m where m.id_indicador = i.id) as dep FROM indicador as i WHERE i.id_objetivo =" . $id;
        $resultado   = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados             = new Indicador;
            $dados->excluir    = true;
            if($registro['dep'] > 0) {
                $dados->excluir = false;
            }
            $dados->id                    = $registro['id'];
            $dados->nome                  = $registro['nome'];
            $dados->unidade               = $registro['unidade'];
            $dados->indicador_desempenho  = $registro['indicador_desempenho'];
            $dados->metodologia           = $registro['metodologia'];
            $dados->periodicidade         = $registro['periodicidade'];
            $dados->tendencia             = $registro['tendencia'];   
            $dados->fonte                 = $registro['fonte'];
            $dados->linha_base            = $registro['linha_base'];
            $dados->objetivo              = $registro['objetivo'];
            $array_dados[]                 = $dados;
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
        $sql = "INSERT INTO indicador(nome, unidade, id_objetivo, indicador, periodicidade, tendencia, fonte, linha_base, metodologia) VALUES 
        ('". $dados->nome ."','". $dados->unidade ."','". $dados->objetivo ."', '".  $dados->indicador_desempenho ."' , '". $dados->periodicidade ."', '". $dados->tendencia ."', '". $dados->fonte ."', '". $dados->linha_base ."', 
        '". $dados->metodologia ."'')";
        if ($dados->id > 0) {
            $sql = "UPDATE indicador SET nome='". $dados->nome ."', unidade='". $dados->unidade ."',id_objetivo='". $dados->objetivo ."', indicador_desempenho='".  $dados->indicador_desempenho ."', 
            periodicidade='". $dados->periodicidade ."', tendencia='". $dados->tendencia ."', fonte='". $dados->fonte ."', linha_base='". $dados->linha_base ."', metodologia='". $dados->metodologia ."' WHERE id=" . $dados->id;
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