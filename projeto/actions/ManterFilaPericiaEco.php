<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Fila.php');
require_once('dto/FilaPericiaEco.php');

class ManterFilaPericiaEco extends Model
{

    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar()
    {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf 
                FROM fila_pericia_eco";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->id_guia = $registro["id_guia"];
            $dados->autorizacao = $registro["autorizacao"];
            $dados->data_solicitacao = $registro["data_solicitacao"];
            $dados->justificativa = $registro["justificativa"];
            $dados->situacao = $registro["situacao"];
            $dados->descricao = $registro["descricao"];
            $dados->cpf = $registro["cpf"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getFilaPorIdGuia($id_guia)
    {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf 
                FROM fila_pericia_eco 
                WHERE id_guia = " . $id_guia;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new FilaPericiaEco();
        if ($registro = $resultado->fetchRow()) {
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->id_guia = $registro["id_guia"];
            $dados->autorizacao = $registro["autorizacao"];
            $dados->data_solicitacao = $registro["data_solicitacao"];
            $dados->justificativa = $registro["justificativa"];
            $dados->situacao = $registro["situacao"];
            $dados->descricao = $registro["descricao"];
            $dados->cpf = $registro["cpf"];
        }
        return $dados;
    }
    function getDataAgendamento()
    {
        $sql = "SELECT data_solicitacao FROM fila_pericia_eco";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco();
            $dados = $registro['data_solicitacao'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getAgendamentoPorData($data)
    {
        $sql = "SELECT id, id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf FROM fila_pericia_eco WHERE data_solicitacao = '" . $data . "'";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->id_guia = $registro["id_guia"];
            $dados->autorizacao = $registro["autorizacao"];
            $dados->data_solicitacao = $registro["data_solicitacao"];
            $dados->justificativa = $registro["justificativa"];
            $dados->situacao = $registro["situacao"];
            $dados->descricao = $registro["descricao"];
            $dados->cpf = $registro["cpf"];
        }
        return $dados;
    }
    function listaFilaPericiaSemAtendimento()
    {
        $sql = "SELECT fp.id, fp.id_guia, fp.autorizacao, fp.data_solicitacao, fp.justificativa, fp.descricao, fp.situacao, fp.cpf, b.nome, b.telefone FROM fila_pericia_eco as fp, beneficiario as b WHERE b.cpf = fp.cpf AND fp.id NOT IN (SELECT id_fila FROM atendimento_pericia WHERE id_fila)";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->id_guia = $registro["id_guia"];
            $dados->autorizacao = $registro["autorizacao"];
            $dados->data_solicitacao = $registro["data_solicitacao"];
            $dados->justificativa = $registro["justificativa"];
            $dados->situacao = $registro["situacao"];
            $dados->descricao = $registro["descricao"];
            $dados->cpf = $registro["cpf"];
            $dados->nome = $registro["nome"];
            $dados->telefone = $registro["telefone"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getFilaPorId($id_fila)
    {
        $sql = "SELECT fp.id, fp.id_guia, fp.autorizacao, fp.data_solicitacao, fp.justificativa, fp.situacao, fp.descricao, fp.cpf, b.nome, b.telefone FROM fila_pericia_eco as fp, beneficiario as b WHERE b.cpf = fp.cpf AND fp.id ='" . $id_fila . "'";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco;
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id = $registro["id"];
            $dados->id_guia = $registro["id_guia"];
            $dados->autorizacao = $registro["autorizacao"];
            $dados->data_solicitacao = $registro["data_solicitacao"];
            $dados->justificativa = $registro["justificativa"];
            $dados->situacao = $registro["situacao"];
            $dados->descricao = $registro["descricao"];
            $dados->cpf = $registro["cpf"];
            $dados->nome = $registro["nome"];
            $dados->telefone = $registro["telefone"];
        }
        return $dados;
    }
    function existeGuia($id_guia)
    {
        $sql = "SELECT id, id_guia FROM fila_pericia_eco WHERE id_guia = " . $id_guia;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            return true;
        }
        return false;
    }

    function salvar(FilaPericiaEco $dados)
    {
        $sql = "INSERT INTO fila_pericia_eco (id_guia, autorizacao, data_solicitacao, justificativa, situacao, descricao, cpf) 
                VALUES (" . $dados->id_guia . ", '" . $dados->autorizacao . "', '" . $dados->data_solicitacao . "', '" . $dados->justificativa . "', '" . $dados->situacao . "', '" . $dados->descricao . "', '" . $dados->cpf . "')";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function excluir($id)
    {
        $sql = "delete from fila_pericia_eco where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function listaHorarioAgendadosPorData($data)
    {
        $sql = "SELECT hora_agendada FROM atendimento_pericia WHERE data_agendada = '" . $data . "'";
        $resultado = $this->db->Execute($sql);
        $agendados = [];
        $agendados[$data] = [];
        while ($registro = $resultado->fetchRow()) {
            $agendados[$data][] = $registro['hora_agendada'];
        }
        return $agendados;
    }

    function listaHorariosDisponiveisPorData($agenda, $horarios_agendados, $data_atual)
    {
        foreach ($agenda as $data => $horariosPossiveis) {
            $agendadosParaData = [];

            if (!empty($horarios_agendados[$data])) {
                foreach ($horarios_agendados[$data] as $hora) {
                    $hora = trim($hora);
                    $agendadosParaData[] = substr($hora, 0, 5);
                }
            }
            $livres = array_values(array_diff($horariosPossiveis, $agendadosParaData));
            sort($livres);

            $horarios_disponiveis[$data] = $livres;
        }
        $disponiveis_para_data_atual = $horarios_disponiveis[$data_atual] ?? [];
        return $disponiveis_para_data_atual;

    }
    function getPeriodo(DateTime $inicio)
    {
        $inicio = new DateTime("-1 day");
        $fim = new DateTime("+30 days");
        $diario = new DateInterval("P1D");
        $periodo = new DatePeriod($inicio, $diario, $fim);
        $periodoDatas = $this->removeDiaEspecial($periodo);
        return $periodoDatas;
    }
    function removeDiaEspecial($periodoDatas)
    {
        $datasValidas = [];

        foreach ($periodoDatas as $data) {
            if ($data->format("N") <= 5) {
                $datasValidas[] = $data;
            }
        }

        return $datasValidas;
    }

    function getHorariosMatutino()
    {
        $inicio = new DateTime("08:30");
        $fim = new DateTime("11:45");
        $intervalo = new DateInterval("PT15M");
        $periodoHoras = new DatePeriod($inicio, $intervalo, $fim);
        return iterator_to_array($periodoHoras);
    }
    function getHorariosVespertino()
    {
        $inicio = new DateTime("14:00");
        $fim = new DateTime("16:45");
        $intervalo = new DateInterval("PT15M");
        $periodoHoras = new DatePeriod($inicio, $intervalo, $fim);
        return iterator_to_array($periodoHoras);
    }
    function getHorarios() {
        return array_merge($this->getHorariosMatutino(), $this->getHorariosVespertino());
    }

    function criaAgenda($periodoDatas, $periodoHoras)
    {
        $agenda = [];
        foreach ($periodoDatas as $data) {
            if ($data->format("N") <= 5) {
                $horarios = [];
                foreach ($periodoHoras as $hora) {
                    $horarios[] = $hora->format("H:i");
                }
                $agenda[$data->format("Y-m-d")] = $horarios;
            }
        }

        return $agenda;
    }
}

