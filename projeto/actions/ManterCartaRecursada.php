<?php 
require_once('Model.php');
require_once('dto/CartaRecursada.php');
require_once('dto/NotaGlosa.php');
require('dto/CartaRecurso.php');

Class ManterCartaRecursada extends Model {

    public function __construct() {
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar() {
        // Consulta SQL para listar as cartas recursadas
        $sql = "select crg.id, crg.carta_recursada, crg.valor_original, crg.id_fiscal_prestador, 
                (select count(*) from nota_glosa as ng where ng.id_recurso_glosa=crg.id ) as dep 
                from carta_recursada_glosa as crg";
        $resultado = $this->db->Execute($sql); // Executa a consulta SQL
        $array_dados = array(); // Array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $dados = new CartaRecursada; // Cria um novo objeto CartaRecursada
            $dados->excluir = true; // Define a propriedade 'excluir' como true por padrão
            if ($registro['dep'] > 0) {
                $dados->excluir = false; // Se houver dependência, não pode excluir
            }
            // Preenche os dados da carta recursada
            $dados->id = $registro['id'];
            $dados->carta_recursada = $registro['carta_recursada'];
            $dados->valor_original = $registro['valor_original'];
            $dados->id_fiscal_prestador = $registro['id_fiscal_prestador'];
            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados
        }
        return $array_dados; // Retorna o array de resultados
    }

    function getCartaPorPrestador($id_prestador) {
        // Consulta SQL para listar as cartas recursadas por prestador
        $sql = "SELECT cr.id, cr.carta_recursada, cr.valor_original, cr.id_fiscal_prestador,
                (SELECT COUNT(*) FROM nota_glosa AS ng WHERE ng.id_recurso_glosa = cr.id) AS dep
                FROM carta_recursada_glosa AS cr, fiscal_prestador AS fp
                WHERE cr.id_fiscal_prestador = fp.id AND fp.id_prestador = ".$id_prestador." ORDER BY cr.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $dados = new CartaRecursada(); // Cria um novo objeto CartaRecursada
            $dados->excluir = true; // Define a propriedade 'excluir' como true por padrão
            if ($registro['dep'] > 0) {
                $dados->excluir = false; // Se houver dependência, não pode excluir
            }
            // Preenche os dados da carta recursada
            $dados->id = $registro['id'];
            $dados->carta_recursada = $registro['carta_recursada'];
            $dados->valor_original = $registro['valor_original'];
            $dados->id_fiscal_prestador = $registro['id_fiscal_prestador'];
            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados
        }
        return $array_dados; // Retorna o array de resultados
    }

    function getCartaPorId($id) {
        // Consulta SQL para obter uma carta recursada específica por ID
        $sql = "select cr.id, cr.carta_recursada, cr.valor_original, cr.id_fiscal_prestador from carta_recursada_glosa as cr where id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $dados = new CartaRecursada(); // Cria um novo objeto CartaRecursada
            // Preenche os dados da carta recursada
            $dados->id = $registro['id'];
            $dados->carta_recursada = $registro['carta_recursada'];
            $dados->valor_original = $registro['valor_original'];
            $dados->id_fiscal_prestador = $registro['id_fiscal_prestador'];
        }
        return $dados; // Retorna o objeto com os dados preenchidos
    }

    function getNotasGlosaPorCarta($id) {
        // Consulta SQL para listar as notas de glosa associadas a uma carta recursada
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercicio, ng.data_emissao,
                ng.data_validacao, ng.data_executado, ng.data_atesto, ng.data_pagamento, ng.doc_sei, ng.status, 
                (select count(*) from carta_recurso as cr where cr.id_nota_glosa=ng.id ) as dep
                from nota_glosa as ng where id_recurso_glosa = ".$id;
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $dados = new NotaGlosa(); // Cria um novo objeto NotaGlosa
            $dados->excluir = true;  // Define a propriedade 'excluir' como true por padrão
            if ($registro['dep'] > 0) {
                $dados->excluir = false; // Se houver dependência, não pode excluir
            }
            // Preenche os dados da nota de glosa
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->lote = $registro["lote"];
            $dados->valor = $registro["valor"];
            $dados->id_recurso_glosa = $registro["id_recurso_glosa"];
            $dados->exercicio = $registro["exercicio"];
            $dados->doc_sei = $registro["doc_sei"];
            $dados->data_emissao = $registro["data_emissao"];
            $dados->data_validacao = $registro["data_validacao"];
            $dados->data_executado = $registro["data_executado"];
            $dados->data_atesto = $registro["data_atesto"];
            $dados->data_pagamento = $registro["data_pagamento"];
            $dados->status = $registro["status"];

            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados
        }
        return $array_dados; // Retorna o array de resultados
    }

    function getCartasRecursoPorNota($id) {
        // Consulta SQL para listar as cartas de recurso associadas a uma nota de glosa
        $sql = "SELECT cr.id, cr.carta_informativo, cr.exercicio, cr.valor_deferido, cr.id_nota_glosa  
                FROM carta_recurso AS cr 
                WHERE cr.id_nota_glosa = ".$id." ORDER BY cr.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $dados = new CartaRecurso(); // Cria um novo objeto CartaRecurso
            $dados->excluir = true; // Define a propriedade 'excluir' como true por padrão
            // Preenche os dados da carta de recurso
            $dados->id = $registro["id"];
            $dados->carta_informativo = $registro["carta_informativo"];
            $dados->exercicio = $registro["exercicio"];
            $dados->valor_deferido = $registro["valor_deferido"];
            $dados->id_nota_glosa = $registro["id_nota_glosa"];

            $array_dados[] = $dados; // Adiciona o objeto ao array de resultados
        }
        return $array_dados; // Retorna o array de resultados
    }

    function salvar(CartaRecursada $dados) {
        // Consulta SQL para inserir uma nova carta recursada
        $sql = "insert into carta_recursada_glosa (carta_recursada, valor_original, id_fiscal_prestador) 
                values('".$dados->carta_recursada."', '".$dados->valor_original."', '".$dados->id_fiscal_prestador."')";
        if ($dados->id > 0) { // Se o ID for maior que 0, é um update
            $sql = "update carta_recursada_glosa set carta_recursada='".$dados->carta_recursada."' , '".$dados->valor_original."' , '".$dados->id_fiscal_prestador."' where id =" . $dados->id;
            $resultado = $this->db->Execute($sql); // Executa o update
        } else { // Se o ID for 0, é um insert
            $resultado = $this->db->Execute($sql); // Executa o insert
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado pela inserção
        }
        return $dados; // Retorna os dados com o ID
    }

    function excluir($id) {
        // Consulta SQL para excluir uma carta recursada
        $sql = "delete from carta_recursada_glosa where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da exclusão
    }

    function verificaInformativo($id_prestador, $informativo) {
        // Consulta SQL para verificar se uma carta recursada já existe para um prestador
        $sql = "select cr.id,cr.carta_recursada,cr.valor_original, cr.id_fiscal_prestador 
                FROM carta_recursada_glosa as cr, fiscal_prestador as fp 
                WHERE fp.id=cr.id_fiscal_prestador 
                AND fp.id_prestador=".$id_prestador." 
                AND cr.carta_recursada = '" . $informativo . "'";
        //echo $sql; // Descomente para depurar a consulta
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $resp = 0; // Inicializa a variável de resposta
        while ($registro = $resultado->fetchRow()) { // Loop pelos resultados
            $resp = 1; // Se houver resultado, define a resposta como 1
        }
        return $resp; // Retorna a resposta
    }
}
