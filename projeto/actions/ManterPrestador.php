<?php

// Importa a classe base de modelagem e os DTOs (Data Transfer Object)
require_once('Model.php');
require_once('dto/Prestador.php');
require_once('dto/Usuario.php');
require_once('dto/Contrato.php');

// Classe responsável por gerenciar operações relacionadas ao prestador
class ManterPrestador extends Model {

    // Construtor da classe, invoca o construtor da classe pai para iniciar conexão com o banco
    function __construct() {
        parent::__construct();
    }

    // Lista todos os prestadores do banco de dados
    function listar() {
        // Consulta que retorna dados dos prestadores, incluindo um count de dependências com fiscais
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.processo_sei,p.id_tipo_prestador, (select count(*) from fiscal_prestador as fp where fp.id_prestador=p.id) as dep FROM prestador as p order by p.razao_social";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Percorre os registros retornados e instancia objetos Prestador
        while ($registro = $resultado->fetchRow()) {
            $dados = new Prestador();
            $dados->excluir = true;

            // Caso haja dependência (fiscais associados), não permite exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Preenche os atributos do objeto Prestador
            $dados->id = $registro["id"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->nome_fantasia = $registro["nome_fantasia"];
            $dados->credenciado = $registro["credenciado"];
            $dados->telefone = $registro["telefone"];
            $dados->ativo = $registro["ativo"];
            $dados->processo_sei = $registro["processo_sei"];
            $dados->tipo_prestador = $registro["id_tipo_prestador"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna um prestador específico pelo ID
    function getPrestadorPorId($id) {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.processo_sei,p.id_tipo_prestador FROM prestador as p WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new Prestador();

        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->nome_fantasia = $registro["nome_fantasia"];
            $dados->credenciado = $registro["credenciado"];
            $dados->telefone = $registro["telefone"];
            $dados->ativo = $registro["ativo"];
            $dados->processo_sei = $registro["processo_sei"];
            $dados->tipo_prestador = $registro["id_tipo_prestador"];
        }
        return $dados;
    }

    // Insere ou atualiza um prestador no banco
    function salvar(Prestador $dados) {
        // Caso o ID seja maior que 0, é um update
        if ($dados->id > 0) {
            $sql = "update prestador set cnpj='" . $dados->cnpj . "', razao_social='" . $dados->razao_social . "',
                    nome_fantasia='" . $dados->nome_fantasia . "', credenciado='" . $dados->credenciado . "',
                    telefone='" . $dados->telefone . "', ativo='" . $dados->ativo . "', processo_sei='" . $dados->processo_sei . "', id_tipo_prestador='" . $dados->tipo_prestador . "'
                    where id=$dados->id";
        } else {
            // Caso contrário, é um novo registro
            $sql = "insert into prestador (cnpj,razao_social,nome_fantasia,credenciado,telefone,ativo,processo_sei,id_tipo_prestador)
                values ('" . $dados->cnpj . "','" . $dados->razao_social . "','" . $dados->nome_fantasia . "',
                '" . $dados->credenciado . "','" . $dados->telefone . "',1,'" . $dados->processo_sei . "','" . $dados->tipo_prestador . "')";
        }

        $resultado = $this->db->Execute($sql);

        // Se foi inserido, obtém o ID gerado
        if (!$dados->id) {
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    // Exclui um prestador pelo ID
    function excluir($id) {
        $sql = "delete from prestador where id=" . $id;
        return $this->db->Execute($sql);
    }

    // Retorna os contratos associados a um prestador
    function getContratosPorId($id_prestador) {
        $sql = "select c.id, c.numero, c.ano, c.vigente, c.id_prestador FROM contrato as c WHERE c.id_prestador=".$id_prestador." order by c.numero";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Contrato();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->ano = $registro["ano"];
            $dados->vigente = $registro["vigente"];
            $dados->prestador = $registro["id_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna os fiscais associados a um prestador
    function getExecutoresPorId($id_prestador) {
        $sql = "select u.id,u.nome, u.matricula, fp.editor, fp.ativo, fp.id as id_fiscal_prestador, (select count(*) from pagamento as p where p.id_fiscal_prestador=fp.id) as dep FROM usuario as u, fiscal_prestador as fp WHERE u.id=fp.id_usuario AND fp.id_prestador=".$id_prestador." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();

            // Verifica se existem pagamentos associados, para impedir exclusão
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            $dados->excluir = true; // esse `true` sobrescreve o anterior — pode ser erro
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->editor = $registro["editor"];
            $dados->ativo = $registro["ativo"];
            $dados->id_fiscal_prestador = $registro["id_fiscal_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna um fiscal específico de um prestador
    function getExecutorPorId($id, $id_usuario) {
        $sql = "select u.id,u.nome, u.matricula, fp.editor, fp.ativo, fp.id as id_fiscal_prestador FROM usuario as u, fiscal_prestador as fp WHERE u.id=fp.id_usuario AND fp.id_prestador=".$id ." AND u.id=". $id_usuario ." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $dados = new Usuario();

        while ($registro = $resultado->fetchRow()) {
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->editor = $registro["editor"];
            $dados->ativo = $registro["ativo"];
            $dados->id_fiscal_prestador = $registro["id_fiscal_prestador"];
        }
        return $dados;
    }

    // Lista usuários que não são fiscais do prestador
    function getNaoExecutoresPorId($id) {
        $sql = "select u.id,u.nome FROM usuario as u WHERE u.id NOT IN(SELECT id_usuario FROM fiscal_prestador as fp WHERE fp.id_prestador=".$id.") order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Associa um fiscal a um prestador
    function add($id_prestador, $id_usuario, $editor = 0) {
        $sql = "insert into fiscal_prestador (id_prestador,id_usuario, editor) values ('" . $id_prestador . "','" . $id_usuario . "'," . $editor . ")";
        return $this->db->Execute($sql);
    }

    // Remove a associação de fiscal
    function del($id_prestador, $id_usuario) {
        $sql = "delete from fiscal_prestador where id_prestador=" . $id_prestador . " AND id_usuario=" . $id_usuario;
        return $this->db->Execute($sql);
    }

    // Ativa o fiscal (flag ativo)
    function ativarExecutor($id_prestador, $id_usuario) {
        $sql = "update fiscal_prestador set ativo = 1 where id_prestador=" . $id_prestador . " AND id_usuario=" . $id_usuario;
        return $this->db->Execute($sql);
    }

    // Desativa o fiscal (flag ativo)
    function desativarExecutor($id_prestador, $id_usuario) {
        $sql = "update fiscal_prestador set ativo = 0 where id_prestador=" . $id_prestador . " AND id_usuario=" . $id_usuario;
        return $this->db->Execute($sql);
    }

    // Lista prestadores de um fiscal específico
    function listarPorExecutor($id_executor) {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.processo_sei,p.id_tipo_prestador, fp.editor FROM prestador as p, fiscal_prestador fp WHERE p.id=fp.id_prestador AND fp.ativo=1 AND fp.id_usuario= ".$id_executor." order by p.razao_social";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Prestador();
            $dados->excluir = true;

            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            $dados->id = $registro["id"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->nome_fantasia = $registro["nome_fantasia"];
            $dados->credenciado = $registro["credenciado"];
            $dados->telefone = $registro["telefone"];
            $dados->ativo = $registro["ativo"];
            $dados->processo_sei = $registro["processo_sei"];
            $dados->tipo_prestador = $registro["id_tipo_prestador"];
            $dados->editor = $registro["editor"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna contratos vinculados a prestadores; se $id for passado, filtra por esse prestador
    function getContratosPrestadores($id = 0) {
        $sql = "SELECT p.id, p.cnpj, p.razao_social, c.id as id_contrato, c.numero, c.ano, c.vigente FROM prestador as p, contrato as c WHERE c.id_prestador = p.id";
        if($id > 0){
            $sql = "SELECT p.id, p.cnpj, p.razao_social, c.id as id_contrato, c.numero, c.ano, c.vigente FROM prestador as p, contrato as c WHERE c.id_prestador = p.id AND p.id=".$id;
        }

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados->excluir = true;

            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            $dados->id = $registro["id"];
            $dados->cnpj = $registro["cnpj"];
            $dados->razao_social = $registro["razao_social"];
            $dados->id_contrato = $registro["id_contrato"];
            $dados->numero = $registro["numero"];
            $dados->ano = $registro["ano"];
            $dados->vigente = $registro["vigente"];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

}
