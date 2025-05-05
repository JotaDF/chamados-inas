<?php

require_once('Model.php'); // Importa a classe base Model que provavelmente gerencia a conexão com o banco.
require_once('dto/Perfil.php'); // Importa a classe Perfil que representa os dados de um perfil.

// Classe responsável por gerenciar perfis no banco de dados
class ManterPerfil extends Model {

    // Construtor da classe: chama o construtor da classe pai (Model) para configurar a conexão com o banco.
    function __construct() {
        parent::__construct();
    }

    // Lista todos os perfis cadastrados no banco de dados
    function listar() {
        // Consulta SQL que traz id, nome, descrição e a contagem de usuários vinculados a cada perfil
        $sql = "select p.id,p.perfil,p.descricao, 
                (select count(*) from usuario as u where u.id_perfil=p.id) as dep 
                FROM perfil as p 
                order by p.id";

        $resultado = $this->db->Execute($sql); // Executa a consulta
        $array_dados = array(); // Array que armazenará os perfis

        while ($registro = $resultado->fetchRow()) { // Percorre os resultados
            $dados = new Perfil(); // Cria um novo objeto Perfil
            $dados->excluir = true;

            // Se o perfil estiver vinculado a algum usuário, ele não pode ser excluído
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os dados ao objeto
            $dados->id = $registro["id"];
            $dados->perfil = $registro["perfil"];
            $dados->descricao = $registro["descricao"];

            // Adiciona ao array de retorno
            $array_dados[] = $dados;
        }

        return $array_dados; // Retorna todos os perfis
    }

    // Busca um perfil específico pelo ID
    function getPerfilPorId($id) {
        $sql = "select p.id,p.perfil,p.descricao FROM perfil as p WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta
        $dados = new Perfil(); // Instancia um objeto Perfil

        while ($registro = $resultado->fetchRow()) {
            // Atribui os dados encontrados ao objeto
            $dados->id = $registro["id"];
            $dados->perfil = $registro["perfil"];
            $dados->descricao = $registro["descricao"];
        }

        return $dados; // Retorna o perfil encontrado
    }

    // Salva ou atualiza um perfil no banco de dados
    function salvar(Perfil $dados) {
        // Monta a query de inserção por padrão
        $sql = "insert into perfil (perfil,descricao) values ('" . $dados->perfil . "','" . $dados->descricao . "')";

        if ($dados->id > 0) {
            // Se já tiver ID, realiza uma atualização (UPDATE)
            $sql = "update perfil set perfil='" . $dados->perfil . "',descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Caso contrário, insere um novo registro (INSERT)
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Pega o ID do novo registro
        }

        return $resultado; // Retorna o resultado da operação
    }

    // Exclui um perfil do banco de dados
    function excluir($id) {
        $sql = "delete from perfil where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão
        return $resultado; // Retorna o resultado
    }

}
