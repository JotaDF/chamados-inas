<?php

// Inclui o arquivo que contém a classe base Model
require_once('Model.php');

// Inclui o arquivo que contém a classe DTO (Data Transfer Object) Recepcao
require_once('dto/Recepcao.php');

// Define a classe ManterRecepcao que estende a classe Model
class ManterRecepcao extends Model {

    // Construtor da classe que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Função que lista todos os registros da tabela 'recepcao'
    function listar() {
        // Consulta SQL que seleciona todos os campos relevantes da tabela 'recepcao', ordenando pelo campo 'cadastro'
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro FROM recepcao as r order by r.cadastro";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);

        // Array para armazenar os objetos Recepcao
        $array_dados = array();

        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new Recepcao();
            $dados->excluir         = true;                         // Sinaliza que o dado pode ser excluído
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->cadastro        = $registro["cadastro"];

            // Adiciona o objeto ao array
            $array_dados[]          = $dados;
        }

        // Retorna o array de objetos Recepcao
        return $array_dados;
    }

    // Função que lista os registros para fins de relatório, com possibilidade de filtro
    function listarRelatorio($filtro = "") {
        // Consulta SQL com junção entre as tabelas 'recepcao' e 'usuario'
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro, u.nome FROM recepcao as r, usuario as u WHERE u.id=r.id_usuario $filtro order by r.cadastro";
        
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera sobre os resultados da consulta
        while ($registro = $resultado->fetchRow()) {
            $dados = new Recepcao();
            $dados->excluir         = true;
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["nome"];           // Aqui é usado o nome do usuário (vindo da tabela 'usuario')
            $dados->cadastro        = $registro["cadastro"];
            $array_dados[]          = $dados;
        }

        return $array_dados;
    }

    // Retorna um objeto Recepcao com base no ID fornecido
    function getRecepcaoPorId($id) {
        // Consulta SQL que busca um registro pelo ID
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro FROM recepcao as r WHERE id=$id";
        
        $resultado = $this->db->Execute($sql);
        $dados = new Recepcao();

        // Preenche o objeto Recepcao com os dados do banco
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->cadastro        = $registro["cadastro"];
        }

        return $dados;
    }

    // Salva (insere ou atualiza) um registro na tabela 'recepcao'
    function salvar(Recepcao $dados) {
        // SQL padrão para inserção de novo registro
        $sql = "insert into recepcao (visitante, empresa, horario, setor, recebido_por, assunto, id_usuario, cadastro)
                values ('" .$dados->visitante . "','" .$dados->empresa . "','" .$dados->horario . "','" .$dados->setor . "','" .$dados->recebido_por . "','" .$dados->assunto . "','" .$dados->usuario . "',now())";

        // Se o objeto tiver um ID maior que 0, significa que já existe e deve ser atualizado
        if ($dados->id > 0) {
            $sql = "update recepcao set visitante='" . $dados->visitante . "', empresa='" . $dados->empresa . "',
            horario='" . $dados->horario . "', setor='" . $dados->setor . "', recebido_por='" . $dados->recebido_por . "',
            assunto='" . $dados->assunto . "', id_usuario='" . $dados->usuario . "', cadastro=now() where id=$dados->id";

            // Executa a atualização
            $resultado = $this->db->Execute($sql);
        } else {
            // Executa a inserção
            $resultado = $this->db->Execute($sql);

            // Obtém o ID gerado automaticamente após o insert
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    // Exclui um registro da tabela 'recepcao' com base no ID
    function excluir($id) {
        $sql = "delete from recepcao where id=" . $id;

        // Executa o comando de exclusão
        $resultado = $this->db->Execute($sql);

        return $resultado;
    }

}
