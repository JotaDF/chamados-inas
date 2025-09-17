<?php
  class Usuario{
	    public $id;
      public $nome;
      public $login;
      public $matricula;
      public $cargo;
      public $email;
      public $nascimento;
      public $whatsapp;
      public $linkedin;
      public $setor;
      public $agenda;
      public $aniversariantes;
      public $ativo;
      public $descricao_lotacao;
      public $codigo_lotacao;
      public $simbolo_cargo;
      public $cargo_efetivo;
      public $cpf;
      public $horario;
      public $acessos = array();
      public $equipes = array();

      //variaveis de manipulação
      public $perfil;
      public $excluir;
      public $senha;
      public $status = true;
      public $msg;
		
  }
