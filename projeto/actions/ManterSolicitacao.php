<?php
require_once('Model.php');
require_once('dto/Solicitacao.php');

class ManterSolicitacao extends Model
{
    const CAMINHO_DIRETORIO_SOLICITACAO = "anexos_solicitacao";
    function __construct()
    { //metodo construtor
        parent::__construct();
    }

    function listar($filtro)
    {
        $sql = "SELECT id, chave, setor, responsavel, descricao, data_abertura, data_atendimento, data_concluido, data_cancelado, anexos, status, solicitante FROM solicitacao " . $filtro . "";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Solicitacao();
            $dados->id = $registro['id'];
            $dados->chave = $registro['chave'];
            $dados->setor = $registro['setor'];
            $dados->responsavel = $registro['responsavel'];
            $dados->descricao = $registro['descricao'];
            $dados->data_atendimento = $registro['data_atendimento'];
            $dados->data_abertura = $registro['data_abertura'];
            $dados->data_concluido = $registro['data_concluido'];
            $dados->data_cancelado = $registro['data_cancelado'];
            $dados->anexos = $registro['anexos'];
            $dados->status = $registro['status'];
            $dados->solicitante = $registro['solicitante'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    function getSolicitacoesPorIdUsuario(int $id_usuario)
    {
        $sql = "SELECT id, chave, setor, responsavel, descricao, data_abertura, data_atendimento, data_concluido, data_cancelado, anexos, status, solicitante FROM solicitacao where solicitante =" . $id_usuario;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Solicitacao();
            $dados->id = $registro['id'];
            $dados->chave = $registro['chave'];
            $dados->setor = $registro['setor'];
            $dados->responsavel = $registro['responsavel'];
            $dados->descricao = $registro['descricao'];
            $dados->data_atendimento = $registro['data_atendimento'];
            $dados->data_abertura = $registro['data_abertura'];
            $dados->data_concluido = $registro['data_concluido'];
            $dados->data_cancelado = $registro['data_cancelado'];
            $dados->anexos = $registro['anexos'];
            $dados->status = $registro['status'];
            $dados->solicitante = $registro['solicitante'];
            $array_dados[] = $dados;
        }

        return $array_dados;
    }

    function getSolicitacaoPorId(int $id_solicitacao)
    {
        $sql = "SELECT id, chave, setor, responsavel, descricao, data_abertura, data_atendimento, data_concluido, data_cancelado, anexos, status, solicitante FROM solicitacao WHERE id =" . $id_solicitacao;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Solicitacao();
            $dados->id = $registro['id'];
            $dados->chave = $registro['chave'];
            $dados->setor = $registro['setor'];
            $dados->responsavel = $registro['responsavel'];
            $dados->descricao = $registro['descricao'];
            $dados->data_atendimento = $registro['data_atendimento'];
            $dados->data_abertura = $registro['data_abertura'];
            $dados->data_concluido = $registro['data_concluido'];
            $dados->data_cancelado = $registro['data_cancelado'];
            $dados->anexos = $registro['anexos'];
            $dados->status = $registro['status'];
            $dados->solicitante = $registro['solicitante'];
        }
        return $dados;
    }

    function concluir(int $id_solicitacao)
    {
        if ($id_solicitacao > 0) {
            $sql = "update solicitacao set status=2, data_atendimento=now() where id=$id_solicitacao";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }
    function salvar(Solicitacao $dados)
    {
        $sql = "INSERT INTO solicitacao (chave, setor, responsavel, descricao, data_abertura, anexos, status, solicitante)
    values('" . $dados->chave . "', '" . $dados->setor . "', '" . $dados->responsavel . "', '" . $dados->descricao . "',now(), $dados->anexos , 0 , '" . $dados->solicitante . "')";
        $this->db->Execute($sql);
        return $this->db->Insert_ID();
    }

    function excluir(int $id = 0)
    {
        $sql = "DELETE FROM solicitacao WHERE id =" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function atender(Solicitacao $dados)
    {
        if ($dados->id > 0) {
            $sql = "update solicitacao set status=1, data_atendimento=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }

    function cancelar(int $id)
    {
        if ($id > 0) {
            $sql = "update solicitacao set status=3, data_cancelado=now() where id=$id";
            $resultado = $this->db->Execute($sql);
        }
        return $resultado;
    }

    function atualizaColunaAnexo(int $id_solicitacao)
    {
        $sql = "UPDATE solicitacao SET anexos = 1 where id =" . $id_solicitacao;
        return $this->db->Execute($sql);
    }

    function excluiArquivoSolicitacao(string $pasta, string $arquivo)
    {
        if (!is_dir($pasta)) {
            return false;
        }

        $arquivo = basename($arquivo);

        $caminho = $pasta . DIRECTORY_SEPARATOR . $arquivo;

        if (!is_file($caminho)) {
            return false;
        }

        return unlink($caminho);
    }

    function processaAnexos(array $anexos)
    {
        $arquivos = [];

        foreach ($anexos['error'] as $indice => $erro) {

            if ($erro === UPLOAD_ERR_OK) {

                $arquivos[] = [
                    'nome' => $anexos['name'][$indice],
                    'tmpName' => $anexos['tmp_name'][$indice],
                    'size' => $anexos['size'][$indice]
                ];
            }
        }

        return $arquivos;
    }

    function getSolicitantePorIdUsuario(int $id)
    {
        $sql = "SELECT nome FROM usuario WHERE id = " . $id;

        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();

        return $registro['nome'];
    }

    private function criarDiretorio(string $caminho)
    {
        if (is_dir($caminho)) {
            return $caminho;
        }

        return mkdir($caminho, 0755, true) ? $caminho : false;
    }

    function processarSolicitacao(int $id_solicitacao, bool $possuiAnexos, array $anexos)
    {

        if (!$id_solicitacao) {
            return false;
        }

        $diretorio = $this->criarDiretorioPorSolicitacao($id_solicitacao);

        if (!$diretorio) {
            return false;
        }

        if (!$this->criarDiretorioDeInteracoes($diretorio)) {
            return false;
        }

        if ($possuiAnexos) {
            $arquivos = $this->processaAnexos($anexos);
            if (!$this->armazenaAnexos($arquivos, $diretorio)) {
                return false;
            }
        }

        return true;
    }


    function criarDiretorioPorSolicitacao(int $id_solicitacao)
    {
        $caminho = self::CAMINHO_DIRETORIO_SOLICITACAO
            . DIRECTORY_SEPARATOR
            . $id_solicitacao . "_solicitacao";

        return $this->criarDiretorio($caminho);
    }

    function criarDiretorioDeInteracoes(string $diretorio)
    {
        return $this->criarDiretorio($diretorio . DIRECTORY_SEPARATOR . "interacoes");
    }

    function criarDiretorioDeArquivosPorInteracao(string $diretorio, int $id_interacao)
    {
        return $this->criarDiretorio($diretorio . DIRECTORY_SEPARATOR . $id_interacao);
    }
    function moverArquivos(array $arquivos, string $diretorio)
    {
        foreach ($arquivos as $arquivo) {
            $caminho = $diretorio . DIRECTORY_SEPARATOR . $arquivo['nome'];
            if (!move_uploaded_file($arquivo['tmpName'], $caminho)) {
                return false;
            }
        }
        return true;
    }

    function armazenaAnexos(array $arquivos, string $diretorio)
    {
        if (!is_dir($diretorio)) {
            return false;
        }

        return $this->moverArquivos($arquivos, $diretorio);
    }

    function armazenaAnexosPorInteracao(array $arquivos, string $diretorio, int $id_interacao)
    {
        $caminho_interacao = $this->criarDiretorioDeArquivosPorInteracao($diretorio, $id_interacao);

        if (!$caminho_interacao) {
            return false;
        }

        return $this->moverArquivos($arquivos, $caminho_interacao);
    }


}