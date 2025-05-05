<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Equipe.php');
require_once('dto/Equipe.php');
require_once('dto/Usuario.php');

class ManterEquipe extends Model {

    function __construct() { // Método construtor
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    // Lista todas as equipes com o filtro opcional
    function listar($filtro = '') {
        $sql = "select e.id,e.equipe,e.descricao, criador, (select count(*) from equipe_usuario as eu where eu.id_equipe=e.id) as dep FROM equipe as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Array que armazenará os dados das equipes
        while ($registro = $resultado->fetchRow()) { // Para cada linha retornada
            $dados = new Equipe(); // Cria um novo objeto da classe Equipe
            $dados->excluir = true; // Define que a equipe pode ser excluída inicialmente
            if ($registro["dep"] > 0) { // Se a equipe tiver dependentes, não pode ser excluída
                $dados->excluir = false;
            }
            $dados->id = $registro["id"]; // Preenche os dados da equipe
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
            $dados->criador = $registro["criador"];
            $array_dados[] = $dados; // Adiciona a equipe ao array de resultados
        }
        return $array_dados; // Retorna o array com todas as equipes
    }

    // Retorna uma equipe com base no seu ID
    function getEquipePorId($id) {
        $sql = "select e.id,e.equipe,e.descricao,e.criador FROM equipe as e WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $dados = new Equipe(); // Cria um novo objeto da classe Equipe
        while ($registro = $resultado->fetchRow()) { // Para cada linha retornada
            $dados->id = $registro["id"]; // Preenche os dados da equipe
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
            $dados->criador = $registro["criador"];
        }
        return $dados; // Retorna o objeto da equipe encontrada
    }

    // Salva os dados de uma equipe (se o ID for 0, realiza um insert; se já existir, faz um update)
    function salvar(Equipe $dados) {
        $sql = "insert into equipe (equipe,descricao,criador) values ('" . $dados->equipe . "','" . $dados->descricao . "','" . $dados->criador . "')";
        if ($dados->id > 0) { // Se o ID for maior que 0, realiza um update
            $sql = "update equipe set equipe='" . $dados->equipe . "',descricao='" . $dados->descricao . "',criador='" . $dados->criador . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else { // Caso contrário, realiza um insert
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Recupera o ID do último insert
        }
        return $resultado; // Retorna o resultado da operação
    }

    // Exclui uma equipe com base no seu ID
    function excluir($id) {
        $sql = "delete from equipe where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão no banco de dados
        return $resultado; // Retorna o resultado da operação
    }

    // Retorna os participantes de uma equipe com base no ID da equipe
    function getParticimantesPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_equipe,u.id_setor,u.id_perfil FROM usuario as u, equipe_usuario as eu WHERE u.id=eu.id_usuario AND eu.id_equipe=".$id." order by u.nome";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Array para armazenar os participantes
        while ($registro = $resultado->fetchRow()) { // Para cada linha retornada
            $dados = new Usuario(); // Cria um novo objeto da classe Usuario
            $dados->excluir = true; // Define que o usuário pode ser excluído inicialmente
            $dados->id = $registro["id"]; // Preenche os dados do usuário
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]); // Converte a data de nascimento
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->equipe = $registro["id_equipe"];
            $dados->setor = $registro["id_setor"];
            $dados->perfil = $registro["id_perfil"];
            $array_dados[] = $dados; // Adiciona o usuário ao array de participantes
        }
        return $array_dados; // Retorna os participantes
    }

    // Retorna os usuários que não são participantes de uma equipe com base no ID da equipe
    function getNaoParticimantesPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_equipe,u.id_setor,u.id_perfil FROM usuario as u WHERE u.id NOT IN(SELECT id_usuario FROM equipe_usuario as eu WHERE eu.id_equipe=".$id.") order by u.nome";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Array para armazenar os usuários
        while ($registro = $resultado->fetchRow()) { // Para cada linha retornada
            $dados = new Usuario(); // Cria um novo objeto da classe Usuario
            $dados->excluir = true; // Define que o usuário pode ser excluído inicialmente
            $dados->id = $registro["id"]; // Preenche os dados do usuário
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]); // Converte a data de nascimento
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->equipe = $registro["id_equipe"];
            $dados->setor = $registro["id_setor"];
            $dados->perfil = $registro["id_perfil"];
            $array_dados[] = $dados; // Adiciona o usuário ao array de não participantes
        }
        return $array_dados; // Retorna os não participantes
    }

    // Adiciona um usuário a uma equipe
    function add($id_equipe, $id_usuario) {
        $sql = "insert into equipe_usuario (id_equipe,id_usuario) values ('" . $id_equipe . "','" . $id_usuario . "')";
        $resultado = $this->db->Execute($sql); // Executa a operação de adicionar
        return $resultado; // Retorna o resultado da operação
    }

    // Remove um usuário de uma equipe
    function del($id_equipe, $id_usuario) {
        $sql = "delete from equipe_usuario where id_equipe=" . $id_equipe . " AND id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql); // Executa a operação de remoção
        return $resultado; // Retorna o resultado da operação
    }
}
