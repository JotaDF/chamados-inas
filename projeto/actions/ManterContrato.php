<?php

// Inclui o arquivo Model.php que provavelmente contém a classe base para acesso ao banco de dados
require_once('Model.php');

// Inclui a definição da classe DTO para Contrato
require_once('dto/Contrato.php');

// Define a classe ManterContrato que herda de Model
class ManterContrato extends Model {

    // Construtor da classe, chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Método para listar todos os contratos do banco de dados
    function listar() {
        // Consulta SQL para selecionar os contratos
        $sql = "select c.id,c.numero, c.ano, c.vigente, c.id_prestador FROM contrato as a order by c.numero";
        // Executa a consulta
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera sobre os resultados e popula um array de objetos Contrato
        while ($registro = $resultado->fetchRow()) {
            $dados = new Contrato();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->numero      = $registro["numero"];
            $dados->ano         = $registro["ano"];
            $dados->vigente     = $registro["vigente"];
            $dados->prestador   = $registro["id_prestador"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }

    // Recupera um contrato específico com base no ID
    function getContratoPorId($id) {
        $sql = "select c.id,c.numero, c.ano, c.vigente, c.id_prestador FROM contrato as a WHERE c.id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new Contrato();

        // Preenche o objeto Contrato com os dados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->numero      = $registro["numero"];
            $dados->ano         = $registro["ano"];
            $dados->vigente     = $registro["vigente"];
            $dados->prestador   = $registro["id_prestador"];
        }
        return $dados;
    }

    // Insere ou atualiza um contrato no banco de dados
    function salvar(Contrato $dados) {
        // Se for um novo contrato, realiza o INSERT
        $sql = "insert into contrato (numero,ano,vigente,id_prestador) 
                values ('" . $dados->numero . "','" . $dados->ano . "','" . $dados->vigente . "','" . $dados->prestador . "')";
        
        // Se já existir (id > 0), realiza o UPDATE
        if ($dados->id > 0) {
            $sql = "update contrato set numero='" . $dados->numero . "',ano='" . $dados->ano . "',vigente='" . $dados->vigente . "',id_prestador='" . $dados->prestador . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado após o insert
        }
        return $resultado;
    }

    // Exclui um contrato com base no ID
    function excluir($id) {
        $sql = "delete from contrato where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Método estático para deletar uma pasta e todos os seus arquivos/subpastas
    public static function delPasta($dir) {
        if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.','..')); // Remove os diretórios . e ..
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? delPasta("$dir/$file") : unlink("$dir/$file"); // Recursivamente remove arquivos e pastas
            }
            return rmdir($dir); // Remove o diretório principal
        }
        return false;
    }

    // Método estático para criar uma pasta, se ela não existir
    public static function addPasta($dir) {
        if(!is_dir($dir)){
            mkdir($dir, 0777, true); // Cria diretório com permissão total e estrutura aninhada
            return true;
        }
        return false;
    }
}
