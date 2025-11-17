<?php

require_once('Model.php');
require_once('dto/Beneficiario.php');

class ManterBeneficiario extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }


    function listar() {
        $sql = "SELECT cpf, nome, carteirinha, telefone, email, endereco FROM beneficiario";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados = new Beneficiario();
            $dados->excluir     = true;
            // if($registro['dep'] > 0) {
            //     $dados->excluir = false;
            // }
            $dados->cpf          = $registro['cpf'];
            $dados->nome         = $registro['nome'];
            $dados->carteirinha  = $registro['carteirinha'];
            $dados->telefone     = $registro['telefone'];
            $dados->email        = $registro['email'];
            $dados->endereco     = $registro['endereco'];
            $array_dados[]       = $dados;
        }
        return $array_dados;
    }


    function salvar(Beneficiario $dados) {
        $sql = "UPDATE beneficiario SET telefone='" . $dados->telefone ."', email='" . $dados->email . "' WHERE cpf='". $dados->cpf ."'";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getBeneficiarioPorCpf($cpf) {
        $sql = "SELECT cpf, nome, carteirinha, telefone, email, endereco FROM beneficiario WHERE cpf='". $cpf ."'" ;
        $resultado = $this->db->Execute($sql);
        $registro = $resultado->fetchRow();
            $dados = new Beneficiario();
            $dados->cpf          = $registro['cpf'];
            $dados->nome         = $registro['nome'];
            $dados->carteirinha  = $registro['carteirinha'];
            $dados->telefone     = $registro['telefone'];
            $dados->email        = $registro['email'];
            $dados->endereco     = $registro['endereco'];
            return $dados;
        } 
    }


