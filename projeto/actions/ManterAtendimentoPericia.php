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

    function getAtendimentoPorBeneficiario($cpf) {
        $sql = "SELECT ap.id, ap.id_medico_perito, ap.cpf, ap.guia, ap.procedimento, ap.data_agendada, ap.hora_agendada, ap.situacao, ap.id_usuario, ap.atualizado, ap.resultado FROM atendimento_pericia ap WHERE ap.cpf = '".$cpf."' ORDER BY ap.situacao";
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

        function listaFilaPorCpf($cpf) {
        $sql = "SELECT fpe.id, fpe.id_guia, fpe.autorizacao, fpe.data_solicitacao, fpe.justificativa, fpe.situacao, fpe.descricao, fpe.cpf FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '". $cpf ."' AND fpe.id_guia NOT IN ( SELECT ap.guia FROM atendimento_pericia AS ap)";
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
        $sql = "SELECT COUNT(*) AS total FROM fila_pericia_eco AS fpe WHERE fpe.cpf = '". $cpf ."' AND fpe.id_guia NOT IN ( SELECT ap.guia FROM atendimento_pericia AS ap )";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }
    function getTotalAtendimentoPorBeneficiario($cpf) {
        $sql = "SELECT COUNT(*) as total FROM atendimento_pericia as ap WHERE ap.cpf  = '".$cpf."'";
        $resultado = $this->db->getRow($sql);
        $total = $resultado['total'];
        return $total;
    }

    function salvar(AtendimentoPericia $dados) {
        $sql = "INSERT INTO atendimento_pericia (id_medico_perito, cpf, guia, procedimento, data_agendada, hora_agendada, situacao, id_usuario, atualizado, resultado) 
        VALUES('". $dados->id_medico_perito ."','". $dados->cpf ."','". $dados->guia ."','". $dados->procedimento ."','". $dados->data_agendada ."','". $dados->hora_agendada ."','". $dados->situacao ."','". $dados->usuario ."','". $dados->atualizado ."','". $dados->resultado ."')";
        if($dados->id > 0) {
            $sql = "UPDATE atendimento_pericia SET id_medico_perito='". $dados->id_medico_perito ."', cpf=,'". $dados->cpf ."', guia=,'". $dados->guia ."', procedimento='". $dados->procedimento ."', data_agendada='". $dados->data_agendada ."', hora_agendada='". $dados->hora_agendada ."',
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