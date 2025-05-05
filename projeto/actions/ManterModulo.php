<?php

// Inclui a classe base com métodos de banco de dados
require_once('Model.php');

// Inclui o DTO da classe Modulo
require_once('dto/Modulo.php');

// Classe responsável pelas operações de CRUD no módulo
class ManterModulo extends Model {

    // Construtor da classe, chama o construtor da classe pai
    function __construct() {
        parent::__construct();
    }

    // Lista todos os módulos cadastrados e verifica se podem ser excluídos
    function listar() {
        // Consulta que retorna os dados dos módulos e uma contagem de acessos (dependência)
        $sql = "select m.id,m.nome,m.icone, m.link, (select count(*) from acesso as a where a.id_modulo=m.id) as dep FROM modulo as m order by m.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array que armazenará os objetos Modulo

        // Percorre os resultados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Modulo(); // Cria novo objeto DTO
            $dados->excluir = true; // Assume que pode ser excluído

            // Se o módulo tiver registros vinculados na tabela "acesso", não pode ser excluído
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os dados retornados ao objeto
            $dados->id     = $registro["id"];
            $dados->nome   = $registro["nome"];
            $dados->icone  = $registro["icone"];
            $dados->link   = $registro["link"];

            // Adiciona o objeto ao array
            $array_dados[] = $dados;
        }

        return $array_dados; // Retorna todos os módulos encontrados
    }

    // Retorna os dados de um módulo a partir do seu ID
    function getModuloPorId($id) {
        $sql = "select m.id,m.nome,m.icone FROM modulo as m WHERE id=$id"; // Consulta para buscar o módulo pelo ID
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Modulo(); // Cria um novo DTO

        // Percorre o resultado (espera-se um único registro)
        while ($registro = $resultado->fetchRow()) {
            $dados->id     = $registro["id"];
            $dados->nome   = $registro["nome"];
            $dados->icone  = $registro["icone"];
            $dados->link   = $registro["link"]; // OBS: coluna "link" não está na query, isso pode resultar em null
        }

        return $dados; // Retorna o objeto preenchido
    }

    // Salva (insere ou atualiza) os dados de um módulo
    function salvar(Modulo $dados) {
        // Comando de inserção caso o ID ainda não exista
        $sql = "insert into modulo (nome,icone,link) values ('" . $dados->nome . "','" . $dados->icone . "','" . $dados->link . "')";

        // Se o objeto já tiver ID, realiza o UPDATE
        if ($dados->id > 0) {
            $sql = "update modulo set nome='" . $dados->nome . "',icone='" . $dados->icone . "',link='" . $dados->link . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa o update
        } else {
            $resultado = $this->db->Execute($sql); // Executa a inserção
            $dados->id = $this->db->insert_Id(); // Recupera o ID gerado
        }

        return $resultado; // Retorna o resultado da operação
    }

    // Exclui um módulo pelo ID
    function excluir($id) {
        $sql = "delete from modulo where id=" . $id; // Comando de exclusão
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado da execução
    }

}
