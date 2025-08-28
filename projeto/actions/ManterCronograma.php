<?php
require_once("Model.php");
require_once("dto/Cronograma.php");

class ManterCronograma extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function lista()
    {
        $sql = "SELECT c.id, c.descricao, c.inicio_prev, c.fim_prev, c.inicio_real, c.fim_real, c.status, c.id_eap_item FROM cronograma as c";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->FetchRow()) {
            $dados = new Cronograma;
            $dados->id = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->inicio_prev = $registro["inicio_prev"];
            $dados->fim_prev = $registro["fim_prev"];
            $dados->inicio_real = $registro["inicio_real"];
            $dados->fim_real = $registro["fim_real"];
            $dados->status = $registro["status"];
            $dados->eap_item = $registro["id"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getCronogramaPorEapId($id)
    {
        $sql = "SELECT c.id, c.descricao, c.inicio_prev, c.fim_prev, c.inicio_real, c.fim_real, c.status, c.id_eap_item FROM cronograma as c WHERE c.id_eap_item =" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->FetchRow()) {
            $dados = new Cronograma;
            $dados->id = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->inicio_prev = $registro["inicio_prev"];
            $dados->fim_prev = $registro["fim_prev"];
            $dados->inicio_real = $registro["inicio_real"];
            $dados->fim_real = $registro["fim_real"];
            $dados->status = $registro["status"];
            $dados->eap_item = $registro["id"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function salvar(Cronograma $dados)
    {
        $sql = "INSERT INTO cronograma (descricao, inicio_prev, fim_prev, inicio_real, fim_real, id_eap_item) 
        VALUES('" . $dados->descricao . "', '" . $dados->inicio_prev . "', '" . $dados->fim_prev . "', " . $dados->inicio_real . ", " . $dados->fim_real . ", '" . $dados->eap_item . "')";
        if ($dados->id > 0) {
            $sql = "UPDATE cronograma SET descricao= '" . $dados->descricao . "',  inicio_prev= '" . $dados->inicio_prev . "', fim_prev='" . $dados->fim_prev . "', id_eap_item= '" . $dados->eap_item . "' WHERE id= $dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        if (!$resultado) {
            echo "Erro na query: " . $this->db->ErrorMsg();
        }
        return $resultado;
    }

    function iniciar($incio_real, $id_cronograma)
    {
        $sql = "UPDATE cronograma SET inicio_real= '" . $incio_real . "', status='Iniciado' WHERE id=" . $id_cronograma;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function finalizar($fim_real, $id_cronograma)
    {
        $sql = "UPDATE cronograma SET fim_real= '" . $fim_real . "', status='Finalizado' WHERE id=" . $id_cronograma;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id)
    {
        $sql = "DELETE FROM Cronograma WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}