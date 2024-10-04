<?php
  class Prestador{
	    public $id;
            public $cnpj;
            public $razao_social;
            public $nome_fantasia;
            public $credenciado;
            public $telefone;
            public $ativo;
            public $processo_sei;
            public $tipo_prestador;
            public $executores = array();

            //variaveis de manipulação
            public $excluir;
            public $status = true;
            public $msg;
		
  }
