<?php 
require_once('Model.php');
require_once('dto/NotaGlosa.php');
require_once('dto/CartaRecurso.php');


Class ManterNotaGlosa extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }   

    function listar() {
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao, ng.data_validacao from nota_glosa as ng order by id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new NotaGlosa();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id              = $registro["id"];
            $dados->numero              = $registro["numero"];
            $dados->lote              = $registro["lote"];
            $dados->valor              = $registro["valor"];
            $dados->id_recurso_glosa   = $registro["id_recurso_glosa"];
            $dados->exercicio              = $registro["exercicio"];
            $dados->data_emissao              = $registro["data_emissao"];
            $dados->data_validacao              = $registro["data_validacao"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getCartaPorGlosa($id) {
        $sql = "SELECT 
    cr.id, 
    cr.carta_informativo, 
    cr.exercicio, 
    cr.valor_deferido, 
    cr.id_nota_glosa, 
    cr.data_atesto,
    ng.id
FROM 
    carta_recurso AS cr
INNER JOIN 
    nota_glosa AS ng
ON 
    cr.id_nota_glosa = ng.id -- Condição de junção correta
WHERE 
    cr.id_nota_glosa = $id
";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchrow()) {
            $dados = new CartaRecurso();
            $dados->id                     = $registro["id"];
            $dados->carta_informativo                 = $registro["carta_informativo"];
            $dados->exercicio                   = $registro["exercicio"];
            $dados->valor_deferido                  = $registro["valor_deferido"];
            $dados->id_nota_glosa       = $registro["id_nota_glosa"];
            $dados->exercicio              = $registro["exercicio"];
            $dados->data_atesto           = $registro["data_atesto"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

}
