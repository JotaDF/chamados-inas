<?php
require_once("Model.php");
require_once('dto/ConfigAgendaPericia.php');
class ManterConfigAgendaPericia extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getConfiguracaoAtiva()
    {
        $sql = "SELECT id, matutino_inicio, matutino_fim, matutino_intervalo, vespertino_inicio, vespertino_fim, vespertino_intervalo, ativo FROM config_agenda_pericia WHERE ativo= 1";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        if ($registro = $resultado->fetchRow()) {
            $dados = new ConfigAgendaPericia();
            $dados->matutino_inicio = $registro['matutino_inicio'];
            $dados->matutino_fim = $registro['matutino_fim'];
            $dados->matutino_intervalo = $registro['matutino_intervalo'];
            $dados->vespertino_inicio = $registro['vespertino_inicio'];
            $dados->vespertino_fim = $registro['vespertino_fim'];
            $dados->matutino_intervalo = $registro['matutino_intervalo'];
            $dados->vespertino_intervalo = $registro['vespertino_intervalo'];
            $dados->ativo = $registro['ativo'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function listaConfiguracoes()
    {
        $sql = "SELECT id, nome, matutino_inicio, matutino_fim, matutino_intervalo, vespertino_inicio, vespertino_fim, vespertino_intervalo, ativo, atualizado FROM config_agenda_pericia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new ConfigAgendaPericia();
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $dados->matutino_inicio = $registro['matutino_inicio'];
            $dados->matutino_fim = $registro['matutino_fim'];
            $dados->matutino_intervalo = $registro['matutino_intervalo'];
            $dados->vespertino_inicio = $registro['vespertino_inicio'];
            $dados->vespertino_fim = $registro['vespertino_fim'];
            $dados->matutino_intervalo = $registro['matutino_intervalo'];
            $dados->vespertino_intervalo = $registro['vespertino_intervalo'];
            $dados->ativo = $registro['ativo'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function registraConfiguracao(ConfigAgendaPericia $dados)
    {
        $sql = "INSERT INTO config_agenda_pericia(nome, matutino_inicio, matutino_fim, matutino_intervalo, vespertino_inicio, vespertino_fim, vespertino_intervalo, id_usuario, atualizado)      
       VALUES('" . $dados->nome . "','" . $dados->matutino_inicio . "','" . $dados->matutino_fim . "','" . $dados->matutino_intervalo . "','" . $dados->vespertino_inicio . "',
       '" . $dados->vespertino_fim . "','" . $dados->vespertino_intervalo . "','" . $dados->usuario . "', now())";
        return $this->db->Execute($sql);
    }
    function ativaConfiguracao($id)
    {
        $this->desativaConfiguracoesAtivas();
        $sql = "UPDATE config_agenda_pericia SET ativo = 1 WHERE id = " . $id;
        return $this->db->Execute($sql);
    }
    function desativaConfiguracoesAtivas()
    {
        $sql = "UPDATE config_agenda_pericia SET ativo = 0 WHERE ativo = 1";
        return $this->db->Execute($sql);
    }

    function excluirConfiguracao($id)
    {
        $sql = "DELETE FROM config_agenda_pericia WHERE id =" . $id;
        return $this->db->Execute($sql);
    }

    function atualizaConfiguracao(ConfigAgendaPericia $dados)
    {
        $sql = "UPDATE config_agenda_pericia SET nome = '" . $dados->nome . "', matutino_inicio='" . $dados->matutino_inicio . "', matutino_fim = '" . $dados->matutino_fim . "',  matutino_intervalo = " . $dados->matutino_intervalo . ", 
        vespertino_inicio = '" . $dados->vespertino_inicio . "', vespertino_fim = '" . $dados->vespertino_fim . "', vespertino_intervalo = " . $dados->vespertino_intervalo . ", id_usuario = " . $dados->usuario . ", atualizado = now() WHERE id = " . $dados->id;
        return $this->db->Execute($sql);
    }
}