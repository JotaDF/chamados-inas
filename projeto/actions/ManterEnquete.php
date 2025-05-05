<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Enquete.php');
require_once('dto/Enquete.php'); // Inclui a classe Enquete, que representa uma enquete.
require_once('dto/OpcaoEnquete.php'); // Inclui a classe OpcaoEnquete, que representa uma opção de resposta na enquete.

class ManterEnquete extends Model {

    function __construct() { // Método construtor da classe ManterEnquete
        parent::__construct(); // Chama o construtor da classe pai (Model).
    }

    function listar($filtro = "") { // Método para listar as enquetes com um filtro opcional.
        $sql = "select e.id,e.descricao, e.status, (select count(*) from enquete_resposta as n where n.id_enquete=e.id) as dep FROM enquete as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $array_dados = array(); // Cria um array para armazenar os resultados.
        while ($registro = $resultado->fetchRow()) { // Itera pelos registros retornados pela consulta.
            $dados = new Enquete(); // Cria um objeto da classe Enquete.
            $dados->excluir = true; // Define a flag de exclusão como verdadeira.
            if ($registro["dep"] > 0) { // Se existirem respostas para a enquete, não pode excluir.
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"]; // Atribui o ID da enquete.
            $dados->descricao   = $registro["descricao"]; // Atribui a descrição da enquete.
            $dados->status      = $registro["status"]; // Atribui o status da enquete.
            $array_dados[]      = $dados; // Adiciona o objeto Enquete ao array de resultados.
        }
        return $array_dados; // Retorna o array com as enquetes listadas.
    }

    function getEnquetePorId($id) { // Método para obter uma enquete pelo seu ID.
        $sql = "select e.id,e.descricao, e.status FROM enquete as e WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $dados = new Enquete(); // Cria um objeto da classe Enquete.
        while ($registro = $resultado->fetchRow()) { // Itera pelo registro retornado.
            $dados->id          = $registro["id"]; // Atribui o ID da enquete.
            $dados->descricao   = $registro["descricao"]; // Atribui a descrição da enquete.
            $dados->status      = $registro["status"]; // Atribui o status da enquete.
        }
        return $dados; // Retorna o objeto Enquete com os dados obtidos.
    }

    function getEnqueteAtiva() { // Método para obter a enquete ativa.
        $sql = "select e.id,e.descricao,e.status FROM enquete as e WHERE status=1";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $dados = new Enquete(); // Cria um objeto da classe Enquete.
        if ($registro = $resultado->fetchRow()) { // Verifica se há um registro.
            $dados->id          = $registro["id"]; // Atribui o ID da enquete.
            $dados->descricao   = $registro["descricao"]; // Atribui a descrição da enquete.
            $dados->status      = $registro["status"]; // Atribui o status da enquete.
        } 
        return $dados; // Retorna a enquete ativa.
    }

    function salvar(Enquete $dados) { // Método para salvar ou atualizar uma enquete.
        $sql = "insert into enquete (descricao) values ('" . $dados->descricao . "')";
        if ($dados->id > 0) { // Se a enquete já tem ID, faz um UPDATE.
            $sql = "update enquete set descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados.
        } else { // Caso contrário, faz um INSERT.
            $resultado = $this->db->Execute($sql); // Executa o insert no banco de dados.
            $dados->id = $this->db->insert_Id(); // Obtém o ID do último registro inserido.
        }
        return $resultado; // Retorna o resultado da operação (sucesso ou erro).
    }

    function publicar($id) { // Método para publicar uma enquete (definir seu status como 1).
        $sql = "update enquete set status=1 where id=$id";
        $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados.
        return $resultado; // Retorna o resultado da operação.
    }

    function despublicar($id) { // Método para despublicar uma enquete (definir seu status como 0).
        $sql = "update enquete set status=0 where id=$id";
        $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados.
        return $resultado; // Retorna o resultado da operação.
    }

    function excluir($id) { // Método para excluir uma enquete.
        $sql = "delete from enquete where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão no banco de dados.
        return $resultado; // Retorna o resultado da operação.
    }

    function getOpcoesEnquete($id) { // Método para obter as opções de uma enquete.
        $sql = "select op.id,op.opcao,op.id_enquete from enquete_opcoes as op where op.id_enquete=$id";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $array_dados = array(); // Cria um array para armazenar os resultados.
        while ($registro = $resultado->fetchRow()) { // Itera pelos registros retornados.
            $dados = new OpcaoEnquete(); // Cria um objeto da classe OpcaoEnquete.
            $dados->excluir = true; // Define a flag de exclusão como verdadeira.
            $dados->id          = $registro["id"]; // Atribui o ID da opção.
            $dados->opcao       = $registro["opcao"]; // Atribui a opção de resposta.
            $dados->id_enquete  = $registro["id_enquete"]; // Atribui o ID da enquete.
            $array_dados[]      = $dados; // Adiciona o objeto OpcaoEnquete ao array de resultados.
        }
        return $array_dados; // Retorna o array com as opções da enquete.
    }

    function getTotalVotosEnquete($id_enquete) { // Método para obter o total de votos de uma enquete.
        $sql = "SELECT count(*) as total FROM enquete_resposta WHERE id_enquete=$id_enquete";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $total = 0; // Inicializa a variável de total de votos.
        if ($registro = $resultado->fetchRow()) { // Verifica se há um registro.
            $total = $registro["total"]; // Atribui o total de votos.
        }
        return $total; // Retorna o total de votos.
    }

    function getTotalVotosPorOpcao($id_enquete, $id_opcao) { // Método para obter o total de votos por opção em uma enquete.
        $sql = "SELECT count(*) as total FROM enquete_resposta WHERE id_enquete_opcoes=$id_opcao AND id_enquete=$id_enquete";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $total = 0; // Inicializa a variável de total de votos.
        if ($registro = $resultado->fetchRow()) { // Verifica se há um registro.
            $total = $registro["total"]; // Atribui o total de votos.
        }
        return $total; // Retorna o total de votos por opção.
    }

    function addOpcao(OpcaoEnquete $dados) { // Método para adicionar uma opção a uma enquete.
        $sql = "insert into enquete_opcoes (opcao,id_enquete) values ('" . $dados->opcao . "','" . $dados->id_enquete . "')";
        $resultado = $this->db->Execute($sql); // Executa o insert no banco de dados.
        $dados->id = $this->db->insert_Id(); // Obtém o ID do último registro inserido.
        return $resultado; // Retorna o resultado da operação.
    }

    function delOpcao($id) { // Método para excluir uma opção de uma enquete.
        $sql = "delete from enquete_opcoes where id=" . $id;
        $resultado = $this->db->Execute($sql); // Executa a exclusão no banco de dados.
        return $resultado; // Retorna o resultado da operação.
    }

    function salvarVoto($id_enquete, $id_usuario, $id_opcao) { // Método para salvar o voto de um usuário em uma enquete.
        $sql = "insert into enquete_resposta (registro, id_enquete, id_usuario, id_enquete_opcoes) values (CURRENT_TIMESTAMP()," . $id_enquete . "," . $id_usuario . "," . $id_opcao . ")";
        $resultado = $this->db->Execute($sql); // Executa o insert no banco de dados.
        return $resultado; // Retorna o resultado da operação.
    }

    function jaVotou($id_enquete, $id_usuario) { // Método para verificar se o usuário já votou em uma enquete.
        $sql = "select count(*) as total from enquete_resposta where id_enquete=$id_enquete AND id_usuario=$id_usuario";
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados.
        $total = 0; // Inicializa a variável de total de votos.
        if ($registro = $resultado->fetchRow()) { // Verifica se há um registro.
            $total   = $registro["total"]; // Atribui o total de votos.
        }
        if($total > 0){ // Se o total for maior que 0, o usuário já votou.
            return true;
        }
        return false; // Caso contrário, o usuário ainda não votou.
    }
}
