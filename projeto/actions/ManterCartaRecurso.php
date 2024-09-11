<?php 

require_once ('actions/Model.php');
require_once ('dto/CartaRecurso.php');

Class ManterCartaRecurso extends Model {

    function __construct() {
        parent::__construct();
    }


    function listar () {
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.valor_deferido, cr.id_nota_glosa, cr.data_atesto, cr.data_pagamento from carta_recurso as cr";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new CartaRecurso();
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->valor_deferido =$registro['valor_deferido'];
            $dados->id_nota_glosa =$registro['id_nota_glosa'];
            $dados->data_atesto =$registro['data_atesto'];
            $dados->data_pagamento =$registro['data_pagamento'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getRecursoPorNotaGlosa ($id) {
        $sql = "SELECT cr.id, cr.informativo, cr.valor_deferido, cr.exercicio, cr.id_nota_glosa, cr.data_atesto, cr.data_pagamento, nd.id from  carta_recurso as cr inner join nota_glosa as ng where cr.id_nota_glosa = ng.id"; 
        $resultado = $this->db->Execute($sql);
        $dados = new CartaRecurso();
        while($registro = $resultado->fetchRow()) {
            $dados->id = $registro['id'];
            $dados->carta_informativo = $registro['carta_informativo'];
            $dados->exercicio = $registro['exercicio'];
            $dados->valor_deferido =$registro['valor_deferido'];
            $dados->id_nota_glosa =$registro['id_nota_glosa'];
            $dados->data_atesto =$registro['data_atesto'];
            $dados->data_pagamento =$registro['data_pagamento'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    } 
        }   

