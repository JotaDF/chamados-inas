<?php
  class QuestCategoriaPergunta{
	    public $id;
      public $nome;
      public $questionario;
      public $perguntas; //array de perguntas
      public $total_perguntas; //total de perguntas

      //variaveis de manipulação
      public $excluir;
      public $status = true;
      public $msg;
		
  }
