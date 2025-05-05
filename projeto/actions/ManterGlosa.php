<?php 

// Requer os arquivos de model e a classe NotaGlosa
require_once('actions/Model.php');
require_once('dto/NotaGlosa.php');

// Classe que gerencia a manipulação de notas de glosa
Class ManterGlosa extends Model {

    // Método construtor da classe
    function __construct() { 
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    // Método para listar todas as notas de glosa
    function listar() {
        // SQL para selecionar todas as colunas da tabela 'nota_glosa'
        $sql = "SELECT ng.id, ng.numero, ng.lote, ng.valor, ng.id_recurso_glosa, ng.exercircio, ng.data_emissao, ng.data_validacao FROM nota_glosa as ng";
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql); 
        // Inicializa um array para armazenar os dados
        $array_dados = array();
        // Itera sobre os registros retornados pela consulta
        while($registro = $resultado->fetchRow()) {
            // Cria um objeto da classe NotaGlosa
            $dados = new NotaGlosa();
            $dados->excluir = true; // Define a flag de exclusão como verdadeira inicialmente
            // Atribui os valores das colunas do banco aos atributos do objeto
            $dados->id =$registro["id"];
            $dados->numero =$registro["numero"];
            $dados->lote =$registro["lote"];
            $dados->valor =$registro["valor"];
            $dados->id_recurso_glosa =$registro["id_recurso_glosa"];
            $dados->exercicio =$registro["exercicio"];
            $dados->data_emissao =$registro["data_emissao"];
            $dados->data_validacao =$registro["data_validacao"];

            // Adiciona o objeto ao array de dados
            $array_dados[] = $dados;
        }
        // Retorna o array de dados
        return $array_dados;
    }

    // Método para buscar as notas de glosa relacionadas a um recurso de glosa
    function getNotasGlosa($id) {
        // SQL para selecionar as notas de glosa com base no id do recurso de glosa
        $sql = "select id, numero, lote, valor, exercicio, data_emissao, data_validacao from nota_glosa where id_recurso_glosa=".$id;
        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);
        // Inicializa um array para armazenar os dados
        $array_dados = array();
        // Itera sobre os registros retornados pela consulta
        while ($registro = $resultado->fetchRow()) {
            // Cria um objeto da classe NotaGlosa
            $dados = new NotaGlosa();
            // Atribui os valores das colunas do banco aos atributos do objeto
            $dados->id =$registro["id"];
            $dados->numero =$registro["numero"];
            $dados->lote =$registro["lote"];
            $dados->valor =$registro["valor"];
            $dados->id_recurso_glosa =$registro["id_recurso_glosa"];
            $dados->exercicio =$registro["exercicio"];
            $dados->data_emissao =$registro["data_emissao"];
            $dados->data_validacao =$registro["data_validacao"];

            // Adiciona o objeto ao array de dados
            $array_dados[] = $dados;
        }
        // Retorna o array de dados
        return $array_dados;
    }

    // Método para salvar ou atualizar uma nota de glosa
    function salvar (NotaGlosa $dados) {
        // SQL para inserir uma nova nota de glosa
        $sql = "insert into nota_glosa (id, numero, lote, valor, id_recurso_glosa, exercicio, data_emissao, data_validacao) values ('" .$dados->numero ."' , '" .$dados->numero."' , '" . $dados->lote ."',
        '". $dados->id_recurso_glosa ."' , '" .$dados->exercicio ."' , '" . $dados->data_emissao . "' , '" . $dados->data_validacao ."')";
        
        // Se o id já estiver preenchido, atualiza a nota de glosa
        if ($dados->id > 0) {
            $sql = "update nota_glosa set numero='" . $dados->numero . "' , lote= '" .$dados->lote. "' , valor= '" . $dados->valor ."', id_recurso_glosa= '" .$dados->id_recurso_glosa."' ,
            exercicio= '" . $dados->exercicio ."' , '". $dados->data_emissao . "' , '" . $dados->data_validacao ."'";
            // Executa a consulta de atualização no banco
            $resultado = $this->db->Execute($sql);
        } else {
            // Executa a consulta de inserção no banco
            $resultado = $this->db->Execute($sql);
            // Recupera o id gerado para a nova nota de glosa
            $dados->id = $this->db->insert_Id();
        }
        // Retorna o resultado da operação
        return $resultado;
    }

    // Método para excluir uma nota de glosa
    function excluir ($id) {
        // SQL para excluir uma nota de glosa
        $sql = "delete from nota_glosa where id =" . $id;
        // Executa a consulta de exclusão no banco
        $resultado = $this->db->Execute($sql);
        // Retorna o resultado da operação
        return $resultado;
    }
}
