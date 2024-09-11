<?php 

require_once('actions/Model.php');
require_once('dto/NotaGlosa.php');

Class ManterGlosa extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }
    function listar() {
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercircio, ng.data_emissao, ng.data_validacao FROM nota_glosa as ng";
        $resultado = $this->db->Execute($sql); 
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            $dados->id =$registro["id"];
            $dados->numero =$registro["numero"];
            $dados->lote =$registro["lote"];
            $dados->valor =$registro["valor"];
            $dados->id_recurso_glosa =$registro["id_recurso_glosa"];
            $dados->exercicio =$registro["exercicio"];
            $dados->data_emissao =$registro["data_emissao"];
            $dados->data_validacao =$registro["data_validacao"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getNotasGlosa($id) {
        $sql = "select id, numero, lote, valor, exercicio, data_emissao, data_validacao from nota_glosa where id_recurso_glosa=".$id;
        $resultado = $this->db->Execute($sql);
        while ($registro = $resultado->fetchRow()) {
            $dados = new NotaGlosa();
            $dados->id =$registro["id"];
            $dados->numero =$registro["numero"];
            $dados->lote =$registro["lote"];
            $dados->valor =$registro["valor"];
            $dados->id_recurso_glosa =$registro["id_recurso_glosa"];
            $dados->exercicio =$registro["exercicio"];
            $dados->data_emissao =$registro["data_emissao"];
            $dados->data_validacao =$registro["data_validacao"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function salvar (NotaGlosa $dados) {
        $sql = "insert into nota_glosa (id, numero, lote, valor, id_recurso_glosa, exercicio, data_emissao, data_validacao) values ('" .$dados->numero ."' , '" .$dados->numero."' , '" . $dados->lote ."',
        '". $dados->id_recurso_glosa ."' , '" .$dados->exercicio ."' , '" . $dados->data_emissao . "' , '" . $dados->data_validacao ."')";
        if ($dados->id > 0) {
            $sql = "update nota_glosa set numero='" . $dados->numero . "' , lote= '" .$dados->lote. "' , valor= '" . $dados->valor ."', id_recurso_glosa= '" .$dados->id_recurso_glosa."' ,
            exercicio= '" . $dados->exercicio ."' , '". $dados->data_emissao . "' , '" . $dados->data_validacao ."'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }


    function excluir ($id) {
        $sql = "delete form nota_glosa where id =" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}

