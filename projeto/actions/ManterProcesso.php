<?php

require_once('Model.php');
require_once('dto/Processo.php');

class ManterProcesso extends Model
{

    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "")
    {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_sub_assunto, id_motivo, id_classe_judicial, id_orgao_origem, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas, pessoa_fisica, inas_parte, pediu_danos FROM processo $filtro ORDER BY autuacao";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Processo();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->sub_assunto = $registro["id_sub_assunto"];
            $dados->motivo = $registro["id_motivo"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->orgao_origem = $registro["id_orgao_origem"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];
            $dados->pessoa_fisica = $registro["pessoa_fisica"];
            $dados->inas_parte = $registro["inas_parte"];
            $dados->pediu_danos = $registro["pediu_danos"];

            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getProcessoPorId($id)
    {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_sub_assunto, id_motivo, id_classe_judicial, id_orgao_origem, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas, pessoa_fisica, inas_parte, pediu_danos FROM processo WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Processo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->sub_assunto = $registro["id_sub_assunto"];
            $dados->motivo = $registro["id_motivo"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->orgao_origem = $registro["id_orgao_origem"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];
            $dados->pessoa_fisica = $registro["pessoa_fisica"];
            $dados->inas_parte = $registro["inas_parte"];
            $dados->pediu_danos = $registro["pediu_danos"];
        }
        return $dados;
    }
    function getProcessoPorNumero($numero)
    {
        $sql = "SELECT id, numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_sub_assunto, id_motivo, id_classe_judicial, id_orgao_origem, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas, pessoa_fisica, inas_parte, pediu_danos FROM processo WHERE numero=$numero";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Processo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->numero = $registro["numero"];
            $dados->sei = $registro["sei"];
            $dados->autuacao = $registro["autuacao"];
            $dados->cpf = $registro["cpf"];
            $dados->beneficiario = $registro["beneficiario"];
            $dados->guia = $registro["guia"];
            $dados->senha = $registro["senha"];
            $dados->valor_causa = $registro["valor_causa"];
            $dados->observacao = $registro["observacao"];
            $dados->assunto = $registro["id_assunto"];
            $dados->sub_assunto = $registro["id_sub_assunto"];
            $dados->motivo = $registro["id_motivo"];
            $dados->classe_judicial = $registro["id_classe_judicial"];
            $dados->orgao_origem = $registro["id_orgao_origem"];
            $dados->processo_principal = $registro["processo_principal"];
            $dados->situacao_processual = $registro["id_situacao_processual"];
            $dados->liminar = $registro["id_liminar"];
            $dados->instancia = $registro["id_instancia"];
            $dados->data_cumprimento_liminar = $registro["data_cumprimento_liminar"];
            $dados->usuario = $registro["id_usuario"];
            $dados->atualizacao = $registro["atualizacao"];
            $dados->autor_inas = $registro["autor_inas"];
            $dados->pessoa_fisica = $registro["pessoa_fisica"];
            $dados->inas_parte = $registro["inas_parte"];
            $dados->pediu_danos = $registro["pediu_danos"];
        }
        return $dados;
    }
    function salvar(Processo $dados)
    {
        if ($dados->classe_judicial == "") {
            $dados->classe_judicial = "null";
        }
        if ($dados->orgao_origem == "") {
            $dados->orgao_origem = "null";
        }
        if ($dados->liminar == "") {
            $dados->liminar = "null";
            $dados->data_cumprimento_liminar = 0;
        }
        if ($dados->data_cumprimento_liminar == "") {
            $dados->data_cumprimento_liminar = 0;
        }
        if ($dados->sub_assunto == "") {
            $dados->sub_assunto = 0;
        }
        if ($dados->motivo == "") {
            $dados->motivo = 0;
        }
        if ($dados->autor_inas == "") {
            $dados->autor_inas = 0;
        }
        if ($dados->pessoa_fisica == "") {
            $dados->pessoa_fisica = 1;
        }
        if ($dados->inas_parte == "") {
            $dados->inas_parte = 0;
        }
        if ($dados->pediu_danos == "") {
            $dados->pediu_danos = 0;
        }

        $sql = "insert into processo (numero, sei, autuacao, cpf, beneficiario, guia, senha, valor_causa, observacao, id_assunto, id_sub_assunto, id_motivo, id_classe_judicial, id_orgao_origem, id_situacao_processual, id_liminar, 
        data_cumprimento_liminar, id_instancia, id_usuario, atualizacao, processo_principal, autor_inas, pessoa_fisica, inas_parte, pediu_danos) 
        values ('" . $dados->numero . "','" . $dados->sei . "','" . $dados->autuacao . "','" . $dados->cpf . "','" . $dados->beneficiario . "',
        '" . $dados->guia . "','" . $dados->senha . "','" . $dados->valor_causa . "','" . $dados->observacao . "','" . $dados->assunto . "','" . $dados->sub_assunto . "','" . $dados->motivo . "',
        " . $dados->classe_judicial . "," . $dados->orgao_origem . ",'" . $dados->situacao_processual . "'," . $dados->liminar . ",'" . $dados->data_cumprimento_liminar . "','" . $dados->instancia . "','" . $dados->usuario . "',now(),'" . $dados->processo_principal . "'," . $dados->autor_inas . "," . $dados->pessoa_fisica . "," . $dados->inas_parte . "," . $dados->pediu_danos . ")";
        if ($dados->id > 0) {
            $sql = "update processo set numero='" . $dados->numero . "', sei='" . $dados->sei . "', autuacao='" . $dados->autuacao . "',
            cpf='" . $dados->cpf . "', beneficiario='" . $dados->beneficiario . "', guia='" . $dados->guia . "', senha='" . $dados->senha . "', 
            valor_causa='" . $dados->valor_causa . "', observacao='" . $dados->observacao . "', id_assunto='" . $dados->assunto . "', id_sub_assunto='" . $dados->sub_assunto . "', id_motivo='" . $dados->motivo . "', id_classe_judicial=" . $dados->classe_judicial . ", id_orgao_origem=" . $dados->orgao_origem . ", id_situacao_processual='" . $dados->situacao_processual . "', 
            id_liminar=" . $dados->liminar . ", data_cumprimento_liminar='" . $dados->data_cumprimento_liminar . "', id_instancia='" . $dados->instancia . "', id_usuario='" . $dados->usuario . "', atualizacao=now(), processo_principal='" . $dados->processo_principal . "', autor_inas=" . $dados->autor_inas . ", pessoa_fisica =" . $dados->pessoa_fisica . ", inas_parte =" . $dados->inas_parte . ", pediu_danos =" . $dados->pediu_danos . " where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id)
    {
        $sql = "delete from processo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function relatorioTotalPorAssunto($ano = '0')
    {
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }
        $sql = "SELECT a.id, a.assunto, (SELECT COUNT(*) FROM processo as p WHERE p.id_assunto=a.id " . $filtro . ") as total FROM assunto as a ORDER BY total;";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            if ($registro["total"] > 0) {
                $dados = new stdClass();
                $dados->id = $registro["id"];
                $dados->assunto = $registro["assunto"];
                $dados->total = $registro["total"];
                
                $array_dados[] = $dados;
            }
        }
        return $array_dados;
    }
    function relatorioTotais($ano = '0')
    {
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }
        $sql = "SELECT 
                (SELECT COUNT(*) FROM processo as p WHERE p.id_liminar=1 " . $filtro . ") as total_deferido,
                (SELECT COUNT(*) FROM processo as p WHERE p.id_liminar=2 " . $filtro . ") as total_indeferido,
                (SELECT COUNT(*) FROM processo as p WHERE p.id_situacao_processual=3 " . $filtro . ") as total_arquivado,
                (SELECT COUNT(*) FROM processo as p, valor_processo as vp WHERE vp.id_processo = p.id AND vp.id_tipo_valor=7 " . $filtro . ") as total_danos_moraes,
                (SELECT COUNT(*) FROM processo as p WHERE p.id > 0 " . $filtro . ") as total_processos
                FROM processo 
                LIMIT 1";
                //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new stdClass();
        if ($registro = $resultado->fetchRow()) {
            $dados->total_deferido = $registro["total_deferido"];
            $dados->total_indeferido = $registro["total_indeferido"];
            $dados->total_arquivado = $registro["total_arquivado"];
            $dados->total_danos_moraes = $registro["total_danos_moraes"];
            $dados->total_processos = $registro["total_processos"];
        }
        return $dados;
    }
    
    function getAnos()
    {
        $sql = "SELECT YEAR(FROM_UNIXTIME(p.autuacao)) AS ano FROM processo AS p 
                WHERE p.id_liminar IN (1, 2) GROUP BY ano ORDER BY ano desc";

        $resultado = $this->db->Execute($sql);
        if ($resultado) {
            $anos = [];
            while ($row = $resultado->FetchRow()) {
                $anos[] = $row['ano'];
            }
        }
        return $anos;

    }
    function relatorioTotaisPorMes($ano = '0')
    {
        $filtro = " ";
        if ($ano != '0') {
            $filtro = " AND FROM_UNIXTIME(p.autuacao, '%Y')='" . $ano . "'";
        }

        $sql = "SELECT 
                MONTH(FROM_UNIXTIME(p.autuacao)) AS mes,
                COUNT(*) AS total
                FROM processo AS p
                WHERE p.id_liminar IN (1, 2) " . $filtro . "
                GROUP BY mes
                ORDER BY mes";

        $resultado = $this->db->Execute($sql);
        $dados = array_fill(1, 12, 0); // Inicializa um array com 12 zeros (para os meses)
        while ($registro = $resultado->fetchRow()) {
            $dados[(int) $registro['mes']] = $registro['total'];
        }
        return $dados;
    }


    function relatoriosTotaisPorAno($anos)
    {
        if (is_array($anos)) {
            $anos = implode(",", $anos);
        }
        $sql = "SELECT YEAR(FROM_UNIXTIME(p.autuacao)) AS ano, 
                   MONTH(FROM_UNIXTIME(p.autuacao)) AS mes, 
                   COUNT(*) AS total_processos 
                   FROM processo AS p 
                   WHERE p.id_liminar IN (1, 2) 
                   AND YEAR(FROM_UNIXTIME(p.autuacao)) IN ($anos) 
                   GROUP BY ano, mes 
                   ORDER BY ano, mes";
        $resultado = $this->db->Execute($sql);
        $totaisPorAno = [];

        while ($registro = $resultado->fetchRow()) {
            if (!isset($totaisPorAno[$registro['ano']])) {
                $totaisPorAno[$registro['ano']] = [];
            }
            $totaisPorAno[$registro['ano']][$registro['mes']] = $registro['total_processos'];
        }

        return $totaisPorAno;
    }

    function relatoriosPorAno()
    {
        $sql = "SELECT YEAR(FROM_UNIXTIME(p.autuacao)) AS ano, COUNT(*) AS total 
                FROM processo AS p WHERE p.id_liminar IN (1, 2) 
                GROUP BY YEAR(FROM_UNIXTIME(p.autuacao)) 
                ORDER BY ano";
        $resultado = $this->db->Execute($sql);
        $dados = [];
        while ($registro = $resultado->fetchRow()) {
            $dado = new stdClass;
            $dado->ano = $registro['ano'];
            $dado->total = $registro['total'];
            $dados[] = $dado;
        }
        return $dados;
    }

}
