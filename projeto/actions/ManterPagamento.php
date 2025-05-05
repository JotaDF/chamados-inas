<?php

// Importa a classe base de modelo e os DTOs necessários
require_once('Model.php');
require_once('dto/Pagamento.php');
require_once('dto/NotaPagamento.php');

// Classe que gerencia operações relacionadas ao pagamento
class ManterPagamento extends Model {

    // Construtor que invoca o construtor da classe pai (Model), inicializando conexão com o banco
    function __construct() {
        parent::__construct();
    }

    // Lista todos os pagamentos cadastrados no banco
    function listar() {
        // Consulta SQL com subquery para contar quantas notas estão associadas a cada pagamento
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador, (select count(*) from nota_pagamento as np where np.id_pagamento=p.id) as dep FROM pagamento as p order by p.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera sobre os registros retornados e popula objetos do tipo Pagamento
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pagamento();

            // Define se é possível excluir o pagamento (caso ele não tenha notas vinculadas)
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui valores do banco ao objeto Pagamento
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];

            // Adiciona o objeto ao array final
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna pagamentos filtrados por prestador específico
    function getPagamentosPorPrestador($id_prestador) {
        // Consulta que busca pagamentos ligados a um determinado prestador
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador, (select count(*) from nota_pagamento as np where np.id_pagamento=p.id) as dep FROM pagamento as p, fiscal_prestador as fp where p.id_fiscal_prestador = fp.id AND fp.id_prestador = ".$id_prestador."  order by p.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera e cria objetos Pagamento com os dados
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pagamento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Retorna um pagamento específico pelo ID
    function getPagamentoPorId($id) {
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador FROM pagamento as p WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new Pagamento();

        // Preenche os atributos do objeto Pagamento com os dados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados->id               = $registro["id"];
            $dados->informativo      = $registro["informativo"];
            $dados->competencia      = $registro["competencia"];
            $dados->fiscal_prestador = $registro["id_fiscal_prestador"];
        }
        return $dados;
    }

    // Verifica se já existe um pagamento com o mesmo informativo para o prestador
    function verificaInformativo($id_prestador, $informativo) {
        $sql = "select p.id,p.informativo,p.competencia, p.id_fiscal_prestador FROM pagamento as p, fiscal_prestador as fp WHERE fp.id=p.id_fiscal_prestador AND fp.id_prestador=".$id_prestador." AND p.informativo = '" . $informativo . "'";
        $resultado = $this->db->Execute($sql);
        $resp = 0;

        // Se houver algum resultado, define o retorno como 1 (verdadeiro)
        while ($registro = $resultado->fetchRow()) {
            $resp = 1;
        }
        return $resp;
    }

    // Retorna todas as notas vinculadas a um pagamento
    function getNotasPorPagamento($id) {
        $sql = "select np.id, np.numero, np.valor, np.exercicio, np.status, np.doc_sei, np.data_emissao, np.data_validacao, np.data_atesto, np.data_pagamento, np.id_pagamento FROM nota_pagamento as np where np.id_pagamento = ".$id." order by np.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Itera sobre os registros de notas e cria objetos NotaPagamento
        while ($registro = $resultado->fetchRow()) {
            $dados = new NotaPagamento();

            // A lógica de "excluir" aqui é redundante, pois a variável "dep" não existe neste contexto
            $dados->excluir = true;
            if (isset($registro["dep"]) && $registro["dep"] > 0) {
                $dados->excluir = false;
            }

            // Atribui os valores do banco ao objeto NotaPagamento
            $dados->id              = $registro["id"];
            $dados->numero          = $registro["numero"];
            $dados->valor           = $registro["valor"];
            $dados->exercicio       = $registro["exercicio"];
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->data_emissao    = $registro["data_emissao"];
            $dados->data_validacao  = $registro["data_validacao"];
            $dados->data_atesto     = $registro["data_atesto"];
            $dados->data_pagamento  = $registro["data_pagamento"];
            $dados->id_pagamento    = $registro["id_pagamento"];
            $dados->status          = $registro["status"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    // Salva um novo pagamento ou atualiza um existente
    function salvar(Pagamento $dados) {
        // Se o pagamento já existe (id > 0), executa um UPDATE
        if ($dados->id > 0) {
            $sql = "update pagamento set informativo='" . $dados->informativo . "', competencia='" . $dados->competencia . "', id_fiscal_prestador='" . $dados->fiscal_prestador . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            // Caso contrário, executa um INSERT e captura o novo ID gerado
            $sql = "insert into pagamento (informativo,competencia,id_fiscal_prestador) values ('" . $dados->informativo . "','" . $dados->competencia . "','" . $dados->fiscal_prestador . "')";
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // pega o ID do novo registro
        }
        return $resultado;
    }

    // Exclui um pagamento com base no ID
    function excluir($id) {
        $sql = "delete from pagamento where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}
