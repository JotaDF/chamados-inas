<?php
require_once('Model.php');
require_once('dto/AtendimentoPericia.php');
require_once('dto/FilaPericiaEco.php');

class ManterAtendimentoPericia extends Model {
    
    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT id, id_medico_perito, cpf, guia, procedimento, data_agendada, hora_agendada, situacao, id_usuario, atualizado, resultado FROM atendimento_pericia";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir     = true;
            $dados->id                  = $registro['id'];
            $dados->id_medico_perito    = $registro['id_medico_perito'];
            $dados->cpf                 = $registro['cpf'];
            $dados->guia                = $registro['guia'];
            $dados->procedimento        = $registro['procedimento'];
            $dados->data_agendada       = $registro['data_agendada'];
            $dados->hora_agendada       = $registro['hora_agendada'];
            $dados->situacao            = $registro['situacao'];
            $dados->usuario             = $registro['id_usuario'];
            $dados->atualizado          = $registro['atualizado'];
            $dados->resultado           = $registro['resultado'];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }

    function getAtendimentoPorDataEHora($data_agendada, $hora_agendada) {
        $sql = "SELECT b.nome, b.cpf, b.telefone, ap.data_agendada, ap.hora_agendada, fpe.autorizacao, ap.situacao, ap.id_usuario, ap.id_fila, ap.id, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.data_solicitacao FROM atendimento_pericia as ap, beneficiario as b, fila_pericia_eco as fpe WHERE fpe.id = ap.id_fila AND fpe.cpf = b.cpf AND data_agendada = '".$data_agendada."' AND hora_agendada= '".$hora_agendada."'";
        $resultado = $this->db->Execute($sql);
        if($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir     = true;
            $dados->id                  = $registro['id'];
            $dados->id_medico_perito    = $registro['id_medico_perito'];
            $dados->cpf                 = $registro['cpf'];
            $dados->guia                = $registro['guia'];
            $dados->nome                = $registro['nome'];
            $dados->cpf                 = $registro['cpf'];
            $dados->telefone            = $registro['telefone'];
            $dados->autorizacao         = $registro['autorizacao'];
            $dados->procedimento        = $registro['procedimento'];
            $dados->data_solicitacao       = $registro['data_solicitacao'];
            $dados->data_agendada       = $registro['data_agendada'];
            $dados->hora_agendada       = $registro['hora_agendada'];
            $dados->situacao            = $registro['situacao'];
            $dados->usuario             = $registro['id_usuario'];
            $dados->descricao           = $registro['descricao'];
            $dados->justificativa       = $registro['justificativa'];
        }
        return $dados;
    }
    function getAtendimentoPorBeneficiario($cpf) {
        $sql = "SELECT ap.id, ap.id_medico_perito, fpe.cpf, fpe.autorizacao, ap.procedimento, ap.data_agendada, ap.hora_agendada, ap.situacao, ap.id_usuario, ap.atualizado, ap.resultado FROM atendimento_pericia as ap, fila_pericia_eco as fpe WHERE fpe.cpf = '".$cpf."' ORDER BY ap.situacao";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new AtendimentoPericia();
            $dados->excluir     = true;
            $dados->id                  = $registro['id'];
            $dados->id_medico_perito    = $registro['id_medico_perito'];
            $dados->cpf                 = $registro['cpf'];
            $dados->guia                = $registro['autorizacao'];
            $dados->procedimento        = $registro['procedimento'];
            $dados->data_agendada       = $registro['data_agendada'];
            $dados->hora_agendada       = $registro['hora_agendada'];
            $dados->situacao            = $registro['situacao'];
            $dados->usuario             = $registro['id_usuario'];
            $dados->atualizado          = $registro['atualizado'];
            $dados->resultado           = $registro['resultado'];
            $array_dados[]              = $dados;
        }
        return $array_dados;
    }

        function listaFilaPorCpf($cpf) {
        $sql = "SELECT fpe.id, fpe.id_guia, fpe.autorizacao, fpe.data_solicitacao, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.cpf FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '". $cpf ."' AND fpe.id NOT IN ( SELECT ap.id_fila FROM atendimento_pericia AS ap)";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new FilaPericiaEco(); 
            $dados->id = $registro['id'];
            $dados->id_guia  = $registro['id_guia'];
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
    function getTotalFilaBeneficiario($cpf) {
        $sql = "SELECT COUNT(*) AS total FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '".$cpf."' AND fpe.id NOT IN (SELECT id_fila FROM atendimento_pericia)";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }
    function getTotalAtendimentoPorBeneficiario($cpf) {
        $sql = "SELECT COUNT(*) AS total FROM fila_pericia_eco as fpe, atendimento_pericia as ap WHERE ap.id_fila = fpe.id AND fpe.cpf = '".$cpf."'";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }

    function salvar(AtendimentoPericia $dados) {
        $sql = "INSERT INTO atendimento_pericia (procedimento, data_agendada, hora_agendada, situacao, id_usuario, id_fila) 
        VALUES('". $dados->procedimento ."','". $dados->data_agendada ."','". $dados->hora_agendada ."','". $dados->situacao ."','". $dados->usuario ."','". $dados->fila ."' )";
        if($dados->id > 0) {
            $sql = "UPDATE atendimento_pericia SET id_medico_perito='". $dados->id_medico_perito ."', procedimento='". $dados->procedimento ."', data_agendada='". $dados->data_agendada ."', hora_agendada='". $dados->hora_agendada ."',
            situacao='". $dados->situacao ."', id_usuario='". $dados->usuario ."', atualizado='". $dados->atualizado ."', resultado='". $dados->resultado ."' WHERE cpf='". $dados->cpf ."'";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        
        return $resultado;
    }

    function excluir($cpf) {
        $sql = "DELETE FROM atendimento_pericia WHERE cpf = '".$cpf."'";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}