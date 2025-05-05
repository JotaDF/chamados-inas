<?php

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para São Paulo
require_once('Model.php'); // Inclui o arquivo Model.php, que deve conter a classe base para conexão com o banco de dados

require_once('dto/Chamado.php'); // Inclui o arquivo Chamado.php, onde está a definição da classe Chamado
require_once('dto/Usuario.php'); // Inclui o arquivo Usuario.php, onde está a definição da classe Usuario

class ManterChamado extends Model { // Define a classe ManterChamado que herda da classe Model

    function __construct() { // Método construtor da classe ManterChamado
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    function listar($filtro = "") { // Método para listar todos os chamados com um filtro opcional
        $sql = "select id,descricao,data_abertura, data_atendido,data_atendimento,data_cancelado,status,id_categoria,id_usuario,id_atendente, (select count(*) from interacao as i where i.id_chamado=c.id) as dep FROM chamado as c " . $filtro . " ORDER BY data_abertura ASC"; // SQL para selecionar os chamados
        //echo 'SQL: ' . $sql; // Linha comentada que mostraria a consulta SQL (para debug)
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $array_dados = array(); // Cria um array para armazenar os resultados
        while ($registro = $resultado->fetchRow()) { // Loop para percorrer todos os registros retornados
            $dados = new Chamado(); // Cria uma nova instância da classe Chamado
            $dados->excluir = true; // Define a propriedade 'excluir' como true por padrão
            if ($registro["dep"] > 0) { // Se houverem interações relacionadas ao chamado
                $dados->excluir = false; // Marca o chamado como não excluível
            }
            $dados->id = $registro["id"]; // Atribui o id do chamado
            $dados->descricao = $registro["descricao"]; // Atribui a descrição do chamado
            $dados->data_abertura = isset($registro["data_abertura"]) ? $registro["data_abertura"] : 0; // Atribui a data de abertura, se disponível
            $dados->data_atendido = isset($registro["data_atendido"]) ? $registro["data_atendido"] : 0; // Atribui a data de atendimento, se disponível
            $dados->data_atendimento = isset($registro["data_atendimento"]) ? $registro["data_atendimento"] : 0; // Atribui a data de atendimento, se disponível
            $dados->data_cancelado = isset($registro["data_cancelado"]) ? $registro["data_cancelado"] : 0; // Atribui a data de cancelamento, se disponível
            $dados->status = $registro["status"]; // Atribui o status do chamado
            $dados->categoria = $registro["id_categoria"]; // Atribui o id da categoria
            $dados->usuario = $registro["id_usuario"]; // Atribui o id do usuário
            $dados->atendente = $registro["id_atendente"]; // Atribui o id do atendente

            $array_dados[] = $dados; // Adiciona os dados do chamado ao array de resultados
        }
        return $array_dados; // Retorna o array com os chamados
    }

    function getChamadoPorId($id) { // Método para obter um chamado pelo seu ID
        $sql = "select id,descricao,data_abertura, data_atendido,data_atendimento,data_cancelado,status,id_categoria,id_usuario,id_atendente FROM chamado as c WHERE id=$id"; // SQL para selecionar um chamado pelo ID
        //echo $sql; // Linha comentada que mostraria a consulta SQL (para debug)
        $resultado = $this->db->Execute($sql); // Executa a consulta no banco de dados
        $dados = new Chamado(); // Cria uma nova instância da classe Chamado
        while ($registro = $resultado->fetchRow()) { // Loop para percorrer o resultado
            $dados->id = $registro["id"]; // Atribui o id do chamado
            $dados->descricao = $registro["descricao"]; // Atribui a descrição do chamado
            $dados->data_abertura = isset($registro["data_abertura"]) ? $registro["data_abertura"] : 0; // Atribui a data de abertura, se disponível
            $dados->data_atendido = isset($registro["data_atendido"]) ? $registro["data_atendido"] : 0; // Atribui a data de atendimento, se disponível
            $dados->data_atendimento = isset($registro["data_atendimento"]) ? $registro["data_atendimento"] : 0; // Atribui a data de atendimento, se disponível
            $dados->data_cancelado = isset($registro["data_cancelado"]) ? $registro["data_cancelado"] : 0; // Atribui a data de cancelamento, se disponível
            $dados->status = $registro["status"]; // Atribui o status do chamado
            $dados->categoria = $registro["id_categoria"]; // Atribui o id da categoria
            $dados->usuario = $registro["id_usuario"]; // Atribui o id do usuário
            $dados->atendente = $registro["id_atendente"]; // Atribui o id do atendente
        }
        return $dados; // Retorna os dados do chamado
    }

    function salvar(Chamado $dados) { // Método para salvar ou atualizar um chamado
        $sql = "insert into chamado (descricao,data_abertura,id_usuario,id_categoria) values ('" . $dados->descricao . "',now()," . $dados->usuario . ",1)"; // SQL para inserir um novo chamado
        //echo $sql . "<BR/>"; // Linha comentada que mostraria a consulta SQL (para debug)
        if ($dados->id > 0) { // Se o ID do chamado for maior que 0, significa que é uma atualização
            $sql = "update chamado set descricao='" . $dados->descricao . "',data_abertura=now(),id_usuario='" . $dados->usuario . "' where id=$dados->id"; // SQL para atualizar o chamado
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        } else { // Se o ID for 0, é um novo chamado
            $resultado = $this->db->Execute($sql); // Executa a inserção no banco de dados
            $dados->id = $this->db->insert_Id(); // Obtém o ID gerado para o novo chamado e o atribui
        }
        return $dados; // Retorna os dados do chamado
    }

    function atender(Chamado $dados) { // Método para atender um chamado
        if ($dados->id > 0) { // Se o ID do chamado for maior que 0
            $sql = "update chamado set id_categoria='" . $dados->categoria . "', id_atendente='" . $dados->atendente . "', status=1, data_atendimento=now() where id=$dados->id"; // SQL para atualizar o status do chamado para atendido
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        }
        return $resultado; // Retorna o resultado da execução
    }

    function concluir($id) { // Método para concluir um chamado
        if ($id > 0) { // Se o ID do chamado for maior que 0
            $sql = "update chamado set status=2, data_atendido=now() where id=$id"; // SQL para atualizar o status do chamado para concluído
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        }
        return $resultado; // Retorna o resultado da execução
    }

    function cancelar($id) { // Método para cancelar um chamado
        if ($id > 0) { // Se o ID do chamado for maior que 0
            $sql = "update chamado set status=3, data_cancelado=now() where id=$id"; // SQL para atualizar o status do chamado para cancelado
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        }
        return $resultado; // Retorna o resultado da execução
    }

    function reabrir($id) { // Método para reabrir um chamado
        if ($id > 0) { // Se o ID do chamado for maior que 0
            $sql = "update chamado set status=4, data_reaberto=now() where id=$id"; // SQL para atualizar o status do chamado para reaberto
            $resultado = $this->db->Execute($sql); // Executa a atualização no banco de dados
        }
        return $resultado; // Retorna o resultado da execução
    }

    function excluir($id) { // Método para excluir um chamado
        $sql = "delete from chamado where id=" . $id; // SQL para excluir o chamado com o ID fornecido
        $resultado = $this->db->Execute($sql); // Executa a exclusão no banco de dados
        return $resultado; // Retorna o resultado da execução
    }

}
