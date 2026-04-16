<?php
require_once('Model.php');
require_once('dto/AtendimentoPericia.php');
require_once('dto/ConfigAgendaPericia.php');
require_once('dto/FilaPericiaEco.php');

class ManterAtendimentoPericia extends Model
{

    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar()
    {
        $sql = "SELECT id, id_medico_perito, cpf, guia, procedimento, data_agendada, hora_agendada, situacao, id_usuario, atualizado, resultado FROM atendimento_pericia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir = true;
            $dados->id = $registro['id'];
            $dados->id_medico_perito = $registro['id_medico_perito'];
            $dados->cpf = $registro['cpf'];
            $dados->guia = $registro['guia'];
            $dados->procedimento = $registro['procedimento'];
            $dados->data_agendada = $registro['data_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->situacao = $registro['situacao'];
            $dados->usuario = $registro['id_usuario'];
            $dados->atualizado = $registro['atualizado'];
            $dados->resultado = $registro['resultado'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function desmarcaAgendamento($id)
    {
        $sql = "UPDATE atendimento_pericia SET situacao = 'DESMARCADO' where id = " . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;

    }

    function getAtendimentoPorDataEHora($data_agendada, $hora_agendada)
    {
        $sql = "SELECT b.nome, b.cpf, b.telefone, ap.data_agendada, ap.hora_agendada, ap.atualizado, ap.situacao as situacao_atendimento, fpe.autorizacao, ap.situacao, ap.id_usuario, ap.id_fila, ap.id as id_atendimento_pericia, ap.resultado, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.data_solicitacao, mp.id as medico_perito FROM atendimento_pericia as ap, beneficiario as b, fila_pericia_eco as fpe, medico_perito as mp WHERE fpe.id = ap.id_fila AND fpe.cpf = b.cpf AND data_agendada = '" . $data_agendada . "' AND hora_agendada= '" . $hora_agendada . "' AND ap.situacao <> 'DESMARCADO' ";
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir = true;
            $dados->id = $registro['id_atendimento_pericia'];
            $dados->id_medico_perito = $registro['id_medico_perito'];
            $dados->fila = $registro['id_fila'];
            $dados->cpf = $registro['cpf'];
            $dados->guia = $registro['guia'];
            $dados->nome = $registro['nome'];
            $dados->cpf = $registro['cpf'];
            $dados->telefone = $registro['telefone'];
            $dados->autorizacao = $registro['autorizacao'];
            $dados->procedimento = $registro['procedimento'];
            $dados->data_solicitacao = $registro['data_solicitacao'];
            $dados->data_agendada = $registro['data_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->resultado = $registro['resultado'];
            $dados->situacao = $registro['situacao'];
            $dados->atualizado = $registro['atualizado'];
            $dados->situacao_atendimento = $registro['situacao_atendimento'];
            $dados->medico_perito = $registro['medico_perito'];
            $dados->usuario = $registro['id_usuario'];
            $dados->descricao = $registro['descricao'];
            $dados->justificativa = $registro['justificativa'];
        }
        return $dados;
    }
    function getAtendimentoPorBeneficiario($cpf)
    {
        $sql = "SELECT ap.id, ap.id_medico_perito, fpe.cpf, fpe.autorizacao, ap.procedimento, ap.data_agendada, ap.hora_agendada, ap.situacao, ap.id_usuario, ap.atualizado, ap.resultado FROM atendimento_pericia as ap, fila_pericia_eco as fpe, medico_perito as mp, beneficiario as b WHERE mp.id = ap.id_medico_perito AND ap.id_fila = fpe.id AND fpe.cpf = b.cpf AND fpe.cpf = '" . $cpf . "' ORDER BY ap.data_agendada";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir = true;
            $dados->id = $registro['id'];
            $dados->id_medico_perito = $registro['id_medico_perito'];
            $dados->cpf = $registro['cpf'];
            $dados->guia = $registro['autorizacao'];
            $dados->procedimento = $registro['procedimento'];
            $dados->data_agendada = $registro['data_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->situacao = $registro['situacao'];
            $dados->usuario = $registro['id_usuario'];
            $dados->atualizado = $registro['atualizado'];
            $dados->resultado = $registro['resultado'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function listaFilaPorCpf($cpf)
    {
        $sql = "SELECT fpe.id, fpe.id_guia, fpe.autorizacao, fpe.data_solicitacao, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.cpf FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '" . $cpf . "' AND fpe.id NOT IN ( SELECT ap.id_fila FROM atendimento_pericia AS ap)";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco();
            $dados->id = $registro['id'];
            $dados->id_guia = $registro['id_guia'];
            $dados->autorizacao = $registro['autorizacao'];
            $dados->data_solicitacao = $registro['data_solicitacao'];
            $dados->justificativa = $registro['justificativa'];
            $dados->situacao = $registro['situacao'];
            $dados->descricao = $registro['descricao'];
            $dados->cpf = $registro['cpf'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function listaAtendimentosRealizados()
    {
        $sql = "SELECT b.nome, b.cpf, b.telefone, ap.data_agendada, ap.hora_agendada, fpe.autorizacao, ap.situacao, ap.id_usuario, ap.id_fila, ap.id, ap.resultado, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.data_solicitacao, fpe.autorizacao FROM atendimento_pericia as ap, beneficiario as b, fila_pericia_eco as fpe WHERE fpe.id = ap.id_fila AND fpe.cpf = b.cpf and ap.resultado is not null AND ap.resultado <> 'NAO COMPARECEU' order by ap.data_agendada DESC, ap.hora_agendada DESC";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco();
            $dados->id = $registro['id'];
            $dados->id_fila = $registro['id_fila'];
            $dados->nome = $registro['nome'];
            $dados->telefone = $registro['telefone'];
            $dados->data_agendada = $registro['data_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->autorizacao = $registro['autorizacao'];
            $dados->resultado = $registro['resultado'];
            $dados->descricao = $registro['descricao'];
            $dados->cpf = $registro['cpf'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function listaAtendimentoRealizadoPorId($id)
    {
        $sql = "SELECT b.nome, b.cpf, b.telefone, ap.data_agendada, ap.hora_agendada, fpe.autorizacao, ap.situacao, ap.id_usuario, ap.id_fila, ap.id, ap.resultado, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.data_solicitacao, mp.nome as medico_perito FROM medico_perito as mp,atendimento_pericia as ap, beneficiario as b, fila_pericia_eco as fpe WHERE mp.id = ap.id_medico_perito AND fpe.id = ap.id_fila AND fpe.cpf = b.cpf AND ap.id ='" . $id . "'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco();
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $dados->telefone = $registro['telefone'];
            $dados->data_agendada = $registro['data_agendada'];
            $dados->hora_agendada = $registro['hora_agendada'];
            $dados->autorizacao = $registro['autorizacao'];
            $dados->data_solicitacao = $registro['data_solicitacao'];
            $dados->justificativa = $registro['justificativa'];
            $dados->medico_perito = $registro['medico_perito'];
            $dados->situacao = $registro['situacao'];
            $dados->resultado = $registro['resultado'];
            $dados->descricao = $registro['descricao'];
            $dados->cpf = $registro['cpf'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getTotalFilaBeneficiario($cpf)
    {
        $sql = "SELECT COUNT(*) AS total FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '" . $cpf . "' AND fpe.id NOT IN (SELECT id_fila FROM atendimento_pericia)";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }
    function getTotalAtendimentoPorBeneficiario($cpf)
    {
        $sql = "SELECT COUNT(*) AS total FROM fila_pericia_eco as fpe, atendimento_pericia as ap WHERE ap.id_fila = fpe.id AND fpe.cpf = '" . $cpf . "'";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }

    function salvar(AtendimentoPericia $dados)
    {
        $sql = "INSERT INTO atendimento_pericia (procedimento, data_agendada, hora_agendada, situacao, id_usuario, id_fila) 
        VALUES('" . $dados->procedimento . "','" . $dados->data_agendada . "','" . $dados->hora_agendada . "','" . $dados->situacao . "','" . $dados->usuario . "','" . $dados->fila . "' )";
        if ($dados->id > 0) {
            $sql = "UPDATE atendimento_pericia SET id_medico_perito='" . $dados->id_medico_perito . "',situacao='" . $dados->situacao . "',atualizado='" . $dados->atualizado . "', resultado='" . $dados->resultado . "' WHERE id='" . $dados->id . "'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }

        return $resultado;
    }

    function reagendar($id_atendimento, $data_agendada, $hora_agendada)
    {
        $sql = "UPDATE atendimento_pericia SET data_agendada ='" . $data_agendada . "', hora_agendada = '" . $hora_agendada . "' WHERE id = '" . $id_atendimento . "'";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($cpf)
    {
        $sql = "DELETE FROM atendimento_pericia WHERE cpf = '" . $cpf . "'";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }



}