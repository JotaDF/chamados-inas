<?php 
require_once 'Model.php';
require_once 'dto/Arquivo.php';

class ManterArquivo  extends Model {

    function listar() {
        $sql = "SELECT a.id, a.nome, a.url, a.tipo, a.id_projeto FROM arquivo";
        $resultado = $this->db->query($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $arquivo = new Arquivo();
            $arquivo->id = $registro['id'];
            $arquivo->nome = $registro['nome'];
            $arquivo->url = $registro['url'];
            $arquivo->tipo = $registro['tipo'];
            $arquivo->projeto = $registro['projeto'];
            $array_dados[] = $arquivo;
        }
        return $array_dados;
    }

    function getArquivosPorIdProjeto($id = 0) {
        $sql = "SELECT a.id, a.nome, a.url, a.tipo, a.id_projeto FROM arquivo a WHERE a.id_projeto = " . $id;
        $resultado = $this->db->query($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Arquivo();
            $dados->id = $registro['id'];
            $dados->nome = $registro['nome'];
            $dados->url = $registro['url'];
            $dados->tipo = $registro['tipo'];
            $dados->projeto = $registro['projeto'];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function uploadArquivo($file, $id_projeto) {
        $a             = new Arquivo();
        $caminho_tmp                   = $file['tmp_name'];
        $nome_arquivo_input            = $_POST['nome'];
        $nome_arquivo_tmp              = strtolower((preg_replace('/\s+/', '_', $file['name'])));
        $dir                           = './arquivos_projeto/';
        $nome_arquivo_definitivo       = $id_projeto . '/' . $nome_arquivo_tmp;
        $tipo_arquivo                  = pathinfo($nome_arquivo_tmp, PATHINFO_EXTENSION);
        $caminho_destino = $dir . $nome_arquivo_definitivo;

        if(move_uploaded_file($caminho_tmp, $caminho_destino)) {
            $a->nome   = $nome_arquivo_input;
            $a->url    = $caminho_destino;
            $a->tipo   = $tipo_arquivo;
            $a->projeto = $id_projeto;
            $resultado = $this->salvar($a);
            if($resultado) {
                return $resultado;
            } else {
                return false;
            }
        }
    }

    function excluir($id) {
        $sql = "DELETE FROM arquivo WHERE id = " . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function removeArquivo($url) {
        if (file_exists($url)) {
            unlink($url);
            return true;
        } else {
            return false;
        }
    }

    function salvar(Arquivo $dados) {
        $sql = "INSERT INTO arquivo (nome, url, tipo, id_projeto) VALUES ('".$dados->nome."', '".$dados->url."', '".$dados->tipo."', '".$dados->projeto."')";
        if($dados->id > 0) {
            $sql = "UPDATE arquivo SET nome= '". $dados->nome ."', url= '" . $dados->url . "', tipo= '" . $dados->tipo . "', id_projeto= '" . $dados->projeto . "' WHERE id= ".$dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

}

