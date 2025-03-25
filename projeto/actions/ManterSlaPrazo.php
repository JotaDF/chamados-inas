<?php 
require_once('Model.php') ;
require_once('dto/SlaPrazo.php');
Class ManterSlaPrazo extends Model {

    function __construct() {
        parent::__construct();
    }

    function listaSlaPrazo() {
        $sql = "SELECT id, tipo_guia, fila, prazo_dias, prazo_segundos FROM sla_prazo";
        $resultado = $this->db->Execute($sql);
        $array_dados = [];
        while ($registro = $resultado->fetchRow()){
        $dados = new SlaPrazo();
        $dados->id                    = $registro["id"];
        $dados->tipo_guia             = $registro["tipo_guia"];
        $dados->fila                  = $registro["fila"];
        $dados->prazo_dias            = $registro["prazo_dias"];
        $dados->prazo_segundos        = $registro["prazo_segundos"];
        $array_dados[]                = $dados;
        }
        return $array_dados;
    }

    function salvar($dados) {
        $sql = "INSERT INTO sla_prazo (tipo_guia, fila, prazo_dias, prazo_segundos) VALUES('".$dados->tipo_guia."', '".$dados->fila."', ".$dados->prazo_dias.", ".$dados->prazo_segundos.")"; 
        $resultado = $this->db->Execute($sql);  
        return $resultado;
    }

    function excluir ($id) {
        $sql = "DELETE FROM sla_prazo WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function update($id) {
        
    }

    function listarFila() {
        $sql = "SELECT DISTINCT fila FROM sla_prazo";
        $resultado = $this->db->Execute($sql);
        $filas = [];
        while ($registro = $resultado->fetchRow()) {
            $filas[]  = $registro["fila"];
        }
        return !empty($filas) ? $filas : 0;
    }

    function listarTipoGuia() {
        $sql = "SELECT DISTINCT tipo_guia FROM sla_prazo";
        $resultado = $this->db->Execute($sql);
        $tipo_guias = [];
        while($registro = $resultado->fetchRow()) {
             $tipo_guias[] = $registro['tipo_guia'];
        }
        return !empty($tipo_guias) ? $tipo_guias : 0;
    }
    
}
