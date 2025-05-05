<?php

require_once('Model.php'); // Inclui o arquivo Model.php, que deve conter a classe base para conexão com o banco de dados
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Categoria.php'); // Linha comentada que carregaria a classe Categoria de um caminho específico
require_once('dto/Categoria.php'); // Inclui o arquivo Categoria.php, onde está a definição da classe Categoria

class ManterCategoria extends Model { // Define a classe ManterCategoria que herda da classe Model

    function __construct() { // Método construtor da classe ManterCategoria
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar() { // Método para listar todas as categorias
        $sql = "select c.id,c.nome,c.descricao, (select count(*) from chamado as ch where uch.id_categoria=c.id) as dep FROM categoria as c order by c.nome"; // SQL que seleciona as categorias e conta o número de chamados relacionados
        $resultado = $this->db->Execute($sql); // Executa o SQL no banco de dados
        $array_dados = array(); // Cria um array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop para percorrer todos os registros retornados
            $dados = new Categoria(); // Cria uma nova instância da classe Categoria
            $dados->excluir = true; // Define a propriedade 'excluir' como true por padrão
            if ($registro["dep"] > 0) { // Se houverem chamados relacionados à categoria
                $dados->excluir = false; // Marca a categoria como não excluível
            }
            $dados->id          = $registro["id"]; // Atribui o id da categoria
            $dados->nome        = $registro["nome"]; // Atribui o nome da categoria
            $dados->descricao   = $registro["descricao"]; // Atribui a descrição da categoria
            $array_dados[]      = $dados; // Adiciona os dados da categoria ao array de resultados
        }
        return $array_dados; // Retorna o array com as categorias
    }

    function getCategoriaPorId($id) { // Método para obter uma categoria pelo seu ID
        $sql = "select c.id,c.nome,c.descricao FROM categoria as c WHERE id=$id"; // SQL para selecionar uma categoria pelo ID
        //echo $sql; // Linha comentada que mostraria a consulta SQL (para debug)
        $resultado = $this->db->Execute($sql); // Executa o SQL no banco de dados
        $dados = new Categoria(); // Cria uma nova instância da classe Categoria
        while ($registro = $resultado->fetchRow()) { // Loop para percorrer o resultado
            $dados->id          = $registro["id"]; // Atribui o id da categoria
            $dados->nome        = $registro["nome"]; // Atribui o nome da categoria
            $dados->descricao   = $registro["descricao"]; // Atribui a descrição da categoria
        }
        return $dados; // Retorna os dados da categoria
    }

    function salvar(Categoria $dados) { // Método para salvar ou atualizar uma categoria
        $sql = "insert into categoria (nome,descricao) values ('" . $dados->nome . "','" . $dados->descricao . "')"; // SQL para inserir uma nova categoria
        if ($dados->id > 0) { // Se o ID da categoria for maior que 0, significa que é uma atualização
            $sql = "update categoria set nome='" . $dados->nome . "',descricao='" . $dados->descricao . "' where id=$dados->id"; // SQL para atualizar a categoria existente
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        } else { // Se o ID for 0, é uma nova categoria
            $resultado = $this->db->Execute($sql); // Executa a inserção no banco de dados
            $dados->id = $this->db->insert_Id(); // Obtém o ID gerado para a nova categoria e o atribui
        }
        return $resultado; // Retorna o resultado da execução
    }

    function excluir($id) { // Método para excluir uma categoria pelo ID
        $sql = "delete from categoria where id=" . $id; // SQL para excluir a categoria com o ID fornecido
        $resultado = $this->db->Execute($sql); // Executa a exclusão no banco de dados
        return $resultado; // Retorna o resultado da exclusão
    }

}
