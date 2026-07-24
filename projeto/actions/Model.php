<?php
//jotadf
//include_once('../adodb5/adodb.inc.php'); //biblioteca necessaria para trabalhar com adodb

//Local
require('adodb/adodb.inc.php'); //biblioteca necessaria para trabalhar com adodb

require_once('dto/Usuario.php');

class Model
{
	protected $db;
	protected $id_usuario = 0;
	function __construct()
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (isset($_SESSION['usuario'])) {
			$usuario = unserialize($_SESSION['usuario']);
			$this->id_usuario = $usuario->id;
		}

		$tipo_banco = "mysqli";
		/*local 
		$servidor      = "db";
		$usuario       = "root";
		$senha         = "root";
		$db            = "gerente_db";
		*/
		/** web */
		$servidor = "db";
		$usuario = "root";
		$senha = "root";
		$db = "chamados";

		$this->db = $banco = NewADOConnection($tipo_banco);
		$this->db->dialect = 3;
		$this->db->debug = false;
		$this->db->Connect($servidor, $usuario, $senha, $db);
		$this->db->Execute("SET NAMES 'utf8mb4'");
		$this->db->Execute("SET CHARACTER SET 'utf8mb4'");
	}
	//metodo para remover acentos de uma string
	function removerAcentos($string)
	{
		return preg_replace(
			array(
				'/[áàãâä]/u',
				'/[ÁÀÃÂÄ]/u',
				'/[éèêë]/u',
				'/[ÉÈÊË]/u',
				'/[íìîï]/u',
				'/[ÍÌÎÏ]/u',
				'/[óòõôö]/u',
				'/[ÓÒÕÔÖ]/u',
				'/[úùûü]/u',
				'/[ÚÙÛÜ]/u',
				'/[ç]/u',
				'/[Ç]/u'
			),
			array(
				'a',
				'A',
				'e',
				'E',
				'i',
				'I',
				'o',
				'O',
				'u',
				'U',
				'c',
				'C'
			),
			$string
		);
	}
	//metodo formatar o campo data para inserção no bando de dados
	function formataDataDB($data)
	{
		list($dia, $mes, $ano) = split('[/.-]', $data);
		$data_formatada = $ano . "-" . $mes . "-" . $dia;
		return $data_formatada;
	}
	//metodo para formatar data para inserção no bando de dados recebe somente numeros
	function formataDataDBtxt($data)
	{
		$data = preg_replace("/[^0-9]/", "", $data);
		if (strlen($data) == 8) {
			$data = $this->formataDataDB(substr($data, 0, 2) . '/' .
				substr($data, 2, 2) . '/' .
				substr($data, 4, 4));
			return $data;
		} else {
			return $this->formataDataDB($data);
		}
	}

	//metodo formatar o campo data padrão brasil
	function formataDataCampo($data)
	{
		list($ano, $mes, $dia) = split('[/.-]', $data);
		$data_formatada = $dia . "/" . $mes . "/" . $ano;
		return $data_formatada;
	}

	//metodo para formatar o CEP
	function formataCep($cep)
	{
		$cep = preg_replace("/[^0-9]/", "", $cep);
		if (strlen($cep) == 8) {
			$cep = substr($cep, 0, 2) . '.' .
				substr($cep, 3, 3) . '-' .
				substr($cep, 5, 3);
			return $cep;
		} else {
			return $cep;
		}
	}
	//metodo para formatar o Telefone
	function formataTelefone($tel)
	{
		$tel = preg_replace("/[^0-9]/", "", $tel);
		if (strlen($tel) == 10) {
			$tel = '(' .
				substr($tel, 0, 2) . ')' .
				substr($tel, 2, 4) . '-' .
				substr($tel, 6, 4);
			return $tel;
		} else {
			return $tel;
		}
	}
	//metodo para formatar o CPF
	function formataCpf($cpf)
	{
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		if (strlen($cpf) == 11) {
			$cpf = substr($cpf, 0, 3) . '.' .
				substr($cpf, 3, 3) . '.' .
				substr($cpf, 6, 3) . '-' .
				substr($cpf, 9, 2);
			return $cpf;
		} else {
			return $cpf;
		}
	}
	//metodo para formatar o CNPJ
	function formataCnpj($cnpj)
	{
		$cnpj = preg_replace("/[^0-9]/", "", $cnpj);
		if (strlen($cnpj) == 14) {
			$cnpj = substr($cnpj, 0, 2) . '.' .
				substr($cnpj, 2, 3) . '.' .
				substr($cnpj, 5, 3) . '/' .
				substr($cnpj, 8, 4) . '-' .
				substr($cnpj, 12, 2);
			return $cnpj;
		} else {
			return $cnpj;
		}
	}

	function executeComAuditoria(string $sql = "", array $auditoria = [], $dados = null)
	{
		$acao = strtoupper($auditoria['acao']);

		switch ($acao) {

			case 'SELECT':
				return $this->db->Execute($sql);

			case 'UPDATE':
				return $this->auditarAtualizacao($sql, $auditoria);

			case 'DELETE':
				return $this->auditarExclusao($sql, $auditoria);

			case 'INSERT':
				return $this->auditarInsercao($sql, $auditoria, $dados);

			default:
				throw new InvalidArgumentException("Ação '{$acao}' não suportada.");
		}
	}

	function auditarAtualizacao($sql, $auditoria)
	{
		if (empty($auditoria['identificador'])) {
			throw new InvalidArgumentException(
				'Identificador não informado para auditoria de atualização.'
			);
		}

		// Estado antes da atualização
		$valores_antigos = $this->buscaRegistro($auditoria);

		// Executa o UPDATE
		$resultado = $this->db->Execute($sql);

		if ($resultado === false) {
			return false;
		}

		// Estado após a atualização
		$valores_novos = $this->buscaRegistro($auditoria);

		// Obtém apenas os campos alterados
		$diferenca = $this->getValoresModificados(
			$valores_antigos,
			$valores_novos
		);

		// Se nada mudou, não registra auditoria
		if (empty($diferenca['valores_antigos'])) {
			return $resultado;
		}

		$ip = $_SERVER['REMOTE_ADDR'] ?? '';

		$sql_auditoria = "INSERT INTO auditoria_intranet (id_usuario, acao, tabela_afetada, identificador, valores_anteriores, valores_novos, ip, data_hora)
    VALUES ('" . $this->id_usuario . "', 'UPDATE', '" . $auditoria['tabela'] . "', '" . json_encode($auditoria['identificador']) . "', '" . json_encode($diferenca['valores_antigos']) . "', '" . json_encode($diferenca['valores_novos']) . "', '" . $ip . "', NOW())";

		$this->db->Execute($sql_auditoria);

		return $resultado;
	}

	function auditarInsercao($sql, $auditoria, $dados)
	{
		$resultado = $this->db->Execute($sql);

		if ($resultado === false) {
			return false;
		}

		if (empty($auditoria['identificador'])) {

			$identificador = [
				'id' => $this->db->insert_Id()
			];

		} else {
			$identificador = $auditoria['identificador'];
		}

		$valores_novos = json_encode($this->normalizarDados($dados));

		$ip = $_SERVER['REMOTE_ADDR'] ?? '';

		$sql_auditoria = "INSERT INTO auditoria_intranet (id_usuario, acao, tabela_afetada, id_registro, valores_anteriores, valores_novos, ip, data_hora) 
		VALUES ('" . $this->id_usuario . "', 'INSERT', '" . $auditoria['tabela'] . "', '" . json_encode($identificador) . "', NULL, '" . $valores_novos . "', '" . $ip . "', NOW())";

		$this->db->Execute($sql_auditoria);

		return $resultado;
	}

	function auditarExclusao($sql, $auditoria)
	{
		// O identificador é obrigatório para DELETE
		if (empty($auditoria['identificador'])) {
			throw new InvalidArgumentException(
				'Identificador não informado para auditoria de exclusão.'
			);
		}
		// Busca os dados antes da exclusão
		$valores_antigos = json_encode($this->buscaRegistro($auditoria));

		// Executa o DELETE
		$resultado = $this->db->Execute($sql);

		if ($resultado === false) {
			return false;
		}

		$ip = $_SERVER['REMOTE_ADDR'] ?? '';

		$sql_auditoria = "INSERT INTO auditoria_intranet (id_usuario, acao, tabela_afetada, id_registro, valores_anteriores, valores_novos, ip, data_hora) 
		VALUES ('" . $this->id_usuario . "', 'DELETE', '" . $auditoria['tabela'] . "', '" . json_encode($auditoria['identificador']) . "', '" . $valores_antigos . "', NULL, '" . $ip . "', NOW())";
		$this->db->Execute($sql_auditoria);
		return $resultado;
	}

	function buscaRegistro($auditoria)
	{
		$where = [];

		foreach ($auditoria['identificador'] as $campo => $valor) {
			$where[] = "{$campo} = '" . addslashes($valor) . "'";
		}

		$sql = "SELECT * FROM " . $auditoria['tabela'] . " WHERE " . implode(' AND ', $where);
		// echo $sql;

		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);

		$resultado = $this->db->Execute($sql);

		if ($resultado === false) {
			throw new Exception($this->db->ErrorMsg());
		}

		return $resultado->fetchRow();
	}

	function getValoresModificados(array $antigos, array $novos): array
	{
		$retorno = [
			'valores_antigos' => [],
			'valores_novos' => [],
		];

		$chaves = array_unique(array_merge(
			array_keys($antigos),
			array_keys($novos)
		));

		foreach ($chaves as $chave) {

			$valorAntigo = $antigos[$chave] ?? null;
			$valorNovo = $novos[$chave] ?? null;

			if ((string) $valorAntigo !== (string) $valorNovo) {
				$retorno['valores_antigos'][$chave] = $valorAntigo;
				$retorno['valores_novos'][$chave] = $valorNovo;
			}
		}

		return $retorno;
	}

	function normalizarDados($dados)
	{
		if (is_null($dados)) {
			return [];
		}

		if (is_array($dados)) {
			return $dados;
		}

		if (is_object($dados)) {
			return get_object_vars($dados);
		}

		return ['valor' => $dados];
	}
	//metodo que retorna o valor por extenso de um numero
	function valorPorExtenso($valor = 0)
	{
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

		$z = 0;

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for ($i = 0; $i < count($inteiro); $i++)
			for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
				$inteiro[$i] = "0" . $inteiro[$i];

		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
		$fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
		for ($i = 0; $i < count($inteiro); $i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

			$r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
			$t = count($inteiro) - 1 - $i;
			$r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")
				$z++;
			elseif ($z > 0)
				$z--;
			if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
				$r .= (($z > 1) ? " de " : "") . $plural[$t];
			if ($r)
				$rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		return ($rt ? $rt : "zero");
	}

}
?>