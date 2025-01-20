<?php

Class CartaRecurso extends Model {
    public $id;
    public $carta_informativo;
    public $exercicio;
    public $valor_deferido;
    public $id_nota_glosa;
    public $data_emissao; 
    public $data_validacao;
    public $data_executado;
    public $data_atesto;
    public $data_pagamento;
    public $doc_sei;
    public $status; 


    public $excluir;
    public $msg;
}
