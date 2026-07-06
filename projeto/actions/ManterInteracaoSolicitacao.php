<?php
require_once('Model.php');
require_once('dto/InteracaoSolicitacao.php');

class ManterInteracaoSolicitacao extends Model
{
    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar()
    {
        $sql = "SELECT id, texto, data, anexos, id_solicitacao, id_usuario FROM interacao_solicitacao";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new InteracaoSolicitacao();
            $dados->id = $registro['id'];
            $dados->texto = $registro['texto'];
            $dados->data = $registro['data'];
            $dados->solicitacao = $registro['id_solicitacao'];
            $dados->usuario = $registro['id_usuario'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    function listarInteracoesPorSolicitacao(int $id_solicitacao)
    {
        $sql = "SELECT id, texto, data, anexos, id_solicitacao, id_usuario FROM interacao_solicitacao where id_solicitacao = $id_solicitacao order by id DESC";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new InteracaoSolicitacao();
            $dados->id = $registro['id'];
            $dados->texto = $registro['texto'];
            $dados->data = $registro['data'];
            $dados->solicitacao = $registro['id_solicitacao'];
            $dados->usuario = $registro['id_usuario'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    function getInteracaoPorId($id)
    {
        $sql = "select i.id, i.texto, i.data, i.id_chamado, i.id_usuario FROM interacao_solicitacao as i WHERE i.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Interacao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->texto = $registro["texto"];
            $dados->data = isset($registro["data"]) ? $registro["data"] : 0;
            $dados->chamado = $registro["id_chamado"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados;
    }

    function salvar(InteracaoSolicitacao $dados)
    {
        $sql = "INSERT INTO interacao_solicitacao (texto, data, anexos, id_solicitacao, id_usuario) 
            VALUES ('" . $dados->texto . "',now(),'" . $dados->anexos . "','" . $dados->solicitacao . "','" . $dados->usuario . "')";
        if (!$this->db->Execute($sql)) {
            return false;
        }

        return $this->db->Insert_ID();
    }

    function registrarInteracao(string $texto, int $id_solicitacao, int $atendente, int $anexos = 0)
    {
        $i = new InteracaoSolicitacao();
        $i->texto = $texto;
        $i->usuario = $atendente;
        $i->anexos = $anexos;
        $i->solicitacao = $id_solicitacao;
        return $this->salvar($i);
    }

    function excluir(int $id = 0)
    {
        $sql = "DELETE FROM interacao_solicitacao WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}
