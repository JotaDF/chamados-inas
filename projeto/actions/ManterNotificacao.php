<?php

// Define o fuso horário padrão para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Inclui o arquivo do modelo base (provavelmente para conexão com banco de dados)
require_once('Model.php');

// Inclui a definição da classe DTO (Data Transfer Object) de Notificação
require_once('dto/Notificacao.php');

// Define a classe ManterNotificacao que estende a classe Model (herança)
class ManterNotificacao extends Model {

    // Método construtor que chama o construtor da classe pai (Model)
    function __construct() {
        parent::__construct();
    }

    // Função que lista todas as notificações, podendo filtrar por notificações lidas ou não
    function listar($lida = 2) {

        // Consulta padrão: retorna todas as notificações
        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n order by n.data";

        // Se o parâmetro $lida for 0 ou 1, filtra pelas notificações lidas ou não lidas
        if ($lida < 2) {
            $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE lida=" . $lida . " order by n.data";
        }

        // Executa a consulta no banco de dados
        $resultado = $this->db->Execute($sql);

        // Cria um array para armazenar os objetos de Notificacao
        $array_dados = array();

        // Itera sobre os registros retornados e instancia objetos Notificacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new Notificacao();
            $dados->excluir = true; // Marca como possível de ser excluída

            // Atribui os valores do banco às propriedades do objeto
            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];

            // Adiciona o objeto ao array de retorno
            $array_dados[] = $dados;
        }

        // Retorna o array de notificações
        return $array_dados;
    }
    
    // Lista notificações filtradas por usuário e por status de leitura
    function listarPorUsuario($id_usuario, $lida = 2) {

        // Consulta padrão: lista notificações não lidas para o usuário
        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id_usuario= ".$id_usuario." AND lida=0 order by n.data";

        // Se o parâmetro $lida for 0 ou 1, aplica o filtro correspondente
        if ($lida < 2) {
            $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id_usuario= ".$id_usuario." AND lida=" . $lida . " order by n.data";
        }

        // Executa a consulta
        $resultado = $this->db->Execute($sql);

        // Array para armazenar os dados
        $array_dados = array();

        // Itera sobre os resultados e cria objetos Notificacao
        while ($registro = $resultado->fetchRow()) {
            $dados = new Notificacao();
            $dados->excluir = true;

            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];

            $array_dados[] = $dados;
        }

        // Retorna as notificações do usuário
        return $array_dados;
    }

    // Retorna uma notificação específica com base no ID
    function getNotificacaoPorId($id) {
        $sql = "select n.id,n.texto,n.link,n.tipo,n.data,n.lida,n.id_usuario FROM notificacao as n WHERE id=$id";
        $resultado = $this->db->Execute($sql);
        $dados = new Notificacao();

        // Preenche o objeto com os dados retornados
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->link = $registro["link"];
            $dados->data = $registro["data"];
            $dados->lida = $registro["lida"];
            $dados->tipo = $registro["tipo"];
            $dados->usuario = $registro["id_usuario"];
        }

        return $dados;
    }

    // Retorna o total de notificações de um usuário específico
    function getTotalNotificacaoUsuario($id) {
        $sql = "select count(*) total FROM notificacao as n WHERE n.id_usuario=$id";
        $resultado = $this->db->Execute($sql);
        $total = 0;

        // Se houver resultado, armazena o valor da contagem
        if ($registro = $resultado->fetchRow()) {
            $total = $registro["total"];
        }

        return $total;
    }
    // Retorna o total de notificações de um usuário específico
    function getTotalNotificacaoNaoLidasUsuario($id) {
        $sql = "select count(*) total FROM notificacao as n WHERE n.lida = 0 AND n.id_usuario=$id";
        $resultado = $this->db->Execute($sql);
        $total = 0;

        // Se houver resultado, armazena o valor da contagem
        if ($registro = $resultado->fetchRow()) {
            $total = $registro["total"];
        }

        return $total;
    }

    // Salva uma nova notificação no banco de dados
    function salvar(Notificacao $dados) {

        // Monta a query de inserção com os dados do objeto e define lida como 0 (não lida)
        $sql = "insert into notificacao (texto, link, tipo,id_usuario, lida, data) values ('" . $dados->texto . "','" . $dados->link . "','" . $dados->tipo . "','" . $dados->usuario . "',0,now())";

        // Executa a query
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    // Marca uma notificação como lida, baseado no ID
    function ler($id) {
        $sql = "update notificacao set lida=1 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}
