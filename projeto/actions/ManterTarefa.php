<?php

// Configura o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Inclui os arquivos necessários
require_once('Model.php');
require_once('ManterEtapa.php');
require_once('ManterUsuario.php');
require_once('dto/Tarefa.php');
require_once('dto/Usuario.php');

// Define a classe ManterTarefa que estende a classe Model
class ManterTarefa extends Model {

    // Construtor da classe
    function __construct() { 
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    // Função para listar as tarefas com filtro opcional
    function listar($filtro = "") {
        // SQL para buscar tarefas com o filtro
        $sql = "select id,nome,descricao,categoria,inicio,fim,tipo,id_criador,id_responsavel,id_equipe,
            (SELECT SUM(aa.qtd_dias) FROM acao as aa, etapa as ee, tarefa as tt WHERE aa.id_etapa=ee.id AND ee.id_tarefa=tt.id AND tt.id = t.id) as total_dias,
            (select count(*) from etapa as e where e.id_tarefa=t.id) as dep 
            FROM tarefa as t " . $filtro . " ORDER BY inicio desc";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Processa os resultados da consulta e armazena em um array
        while ($registro = $resultado->fetchRow()) {
            $dados = new Tarefa();
            $dados->excluir = true;
            // Se a tarefa tem dependências, não pode ser excluída
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            // Preenche os dados da tarefa
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->descricao = $registro["descricao"];
            $dados->categoria = $registro["categoria"];
            $dados->tipo = $registro["tipo"];
            $dados->inicio = date('Y-m-d', $registro["inicio"]);
            $dados->fim = date('Y-m-d', $registro["fim"]);
            $dados->criador = $registro["id_criador"];
            $dados->responsavel = $registro["id_responsavel"];
            $dados->equipe = $registro["id_equipe"];
            $dados->total_dias = $registro["total_dias"];

            // Adiciona o objeto Tarefa ao array de dados
            $array_dados[] = $dados;
        }
        // Retorna o array com as tarefas
        return $array_dados;
    }

    // Função para listar tarefas para relatório com filtro opcional
    function listarRelatorio($filtro = "") {
        // SQL para buscar tarefas para relatório
        $sql = "select id,nome,descricao,categoria,inicio,fim,tipo,id_criador,id_responsavel,id_equipe 
            FROM tarefa as t " . $filtro . " ORDER BY inicio_inscricao, inicio, nome";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        // Processa os resultados e armazena em um array
        while ($registro = $resultado->fetchRow()) {
            $dados = new Tarefa();
            // Preenche os dados da tarefa
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->descricao = $registro["descricao"];
            $dados->categoria = $registro["categoria"];
            $dados->tipo = $registro["tipo"];
            $dados->inicio = date('Y-m-d', $registro["inicio"]);
            $dados->fim = date('Y-m-d', $registro["fim"]);
            $dados->criador = $registro["id_criador"];
            $dados->responsavel = $registro["id_responsavel"];
            $dados->equipe = $registro["id_equipe"];

            // Adiciona o objeto Tarefa ao array de dados
            $array_dados[] = $dados;
        }
        // Retorna o array de tarefas para relatório
        return $array_dados;
    }

    // Função para buscar uma tarefa por seu ID
    function getTarefaPorId($id) {
        // SQL para buscar os detalhes de uma tarefa pelo ID
        $sql = "select id,nome,descricao,categoria,inicio,fim,tipo,id_criador,id_responsavel,id_equipe, 
            (SELECT SUM(aa.qtd_dias) FROM acao as aa, etapa as ee, tarefa as tt WHERE aa.id_etapa=ee.id AND ee.id_tarefa=tt.id AND tt.id = t.id) as total_dias 
            FROM tarefa as t WHERE id=$id";
        
        // Executa a consulta SQL
        $resultado = $this->db->Execute($sql);
        $dados = new Tarefa();

        // Processa o resultado e preenche o objeto Tarefa
        while ($registro = $resultado->fetchRow()) {
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->descricao = $registro["descricao"];
            $dados->categoria = $registro["categoria"];
            $dados->tipo = $registro["tipo"];
            $dados->inicio = date('Y-m-d', $registro["inicio"]);
            $dados->fim = date('Y-m-d', $registro["fim"]);
            $dados->criador = $registro["id_criador"];
            $dados->responsavel = $registro["id_responsavel"];
            $dados->equipe = $registro["id_equipe"];
            $dados->total_dias = $registro["total_dias"];
        }
        // Retorna o objeto Tarefa com os dados
        return $dados;
    }

    // Função para salvar ou atualizar uma tarefa
    function salvar(Tarefa $dados) {
        // SQL para inserir ou atualizar uma tarefa
        $sql = "insert into tarefa (nome,descricao,categoria,inicio,fim,tipo,id_criador,id_responsavel,id_equipe) 
            values ('" . $dados->nome . "','" . $dados->descricao . "','" . $dados->categoria . "','" . $dados->inicio . "','" . $dados->fim . "','" . $dados->tipo . "'," . $dados->criador . "," . $dados->responsavel . "," . $dados->equipe . ")";
        
        // Se a tarefa já tem um ID, faz o update
        if ($dados->id > 0) {
            $sql = "update tarefa set nome='" . $dados->nome . "',descricao='" . $dados->descricao . "',categoria='" . $dados->categoria . "',inicio='" . $dados->inicio . "',fim='" . $dados->fim . "',tipo='" . $dados->tipo . "',id_criador=" . $dados->criador . ",id_responsavel=" . $dados->responsavel . ",id_equipe=" . $dados->equipe . " where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            // Se não, faz o insert
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        // Retorna o resultado da execução
        return $resultado;
    }

    // Função para duplicar uma tarefa
    function duplicar(Tarefa $dados) {
        // SQL para duplicar uma tarefa
        $sql = "insert into tarefa (nome,descricao,categoria,inicio,fim,tipo,id_criador,id_responsavel,id_equipe) 
            values ('" . $dados->nome . "','" . $dados->descricao . "','" . $dados->categoria . "','" . $dados->inicio . "','" . $dados->fim . "','" . $dados->tipo . "'," . $dados->criador . "," . $dados->responsavel . "," . $dados->equipe . ")";
        
        // Executa o insert para duplicar a tarefa
        $id_duplicar = $dados->id;
        $resultado = $this->db->Execute($sql);
        $dados->id = $this->db->insert_Id();

        // Duplica as etapas e ações associadas
        $sql_busca_etapas = "select e.id,e.nome,e.ordem,e.id_tarefa FROM etapa as e WHERE e.id_tarefa=" . $id_duplicar . " order by e.ordem";
        $rs_etapas = $this->db->Execute($sql_busca_etapas);
        while ($reg_etapa = $rs_etapas->fetchRow()) {
            // Insere as etapas duplicadas
            $sql_insert_etapa = "insert into etapa (nome, ordem, id_tarefa) values ('" . $reg_etapa["nome"] . "','" . $reg_etapa["ordem"] . "','" . $dados->id . "')";
            $rs_insert_etapa = $this->db->Execute($sql_insert_etapa);
            $id_etapa = $this->db->insert_Id();

            // Duplica as ações associadas à etapa
            $sql_busca_acoes = "select a.id,a.acao,a.ordem,a.data_check,a.id_etapa,a.id_usuario,(select count(*) from etapa as e where e.id=a.id_etapa) as dep FROM acao as a WHERE id_etapa=" . $reg_etapa["id"] . " order by a.ordem";
            $rs_acoes = $this->db->Execute($sql_busca_acoes);
            while ($reg_acao = $rs_acoes->fetchRow()) {
                $sql_insert_acao = "insert into acao (acao, ordem, id_etapa) values ('" . $reg_acao["acao"] . "','" . $reg_acao["ordem"] . "','" . $id_etapa . "')";
                $rs_insert_acao = $this->db->Execute($sql_insert_acao);
            }
        }
        // Retorna o objeto Tarefa duplicado
        return $dados;
    }
 // Função para excluir uma tarefa com base no id fornecido
function excluir($id) {
    // Instancia o objeto ManterEtapa para manipular etapas associadas
    $manterEtapa = new ManterEtapa();
    // Lista as etapas associadas à tarefa
    $etapas = $manterEtapa->listar($id);
    
    // Itera sobre as etapas e exclui as ações associadas
    foreach ($etapas as $obj) {
        $sql_acao = "delete from acao where id_etapa=" . $obj->id;
        $rs_acao = $this->db->Execute($sql_acao);
        // Exclui a etapa
        $manterEtapa->excluir($obj->id);
    }
    
    // Exclui a tarefa
    $sql = "delete from tarefa where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

// Função para obter o percentual de uma tarefa concluída com base no id
function getPercentualTarefaPorId($id) {
    // SQL para contar o total de ações e as concluídas
    $sql = "SELECT
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.tipo=1 AND a.id_etapa=e.id AND e.id_tarefa=$id) as total,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.tipo=1 AND a.id_etapa=e.id AND e.id_tarefa=$id AND a.data_check > 0) as concluido
    FROM etapa 
    GROUP BY total, concluido";
    
    // Executa a consulta SQL
    $resultado = $this->db->Execute($sql);
    if ($registro = $resultado->fetchRow()) {
        $total = $registro["total"];
        $concluido = $registro["concluido"];
        if ($total > 0 && $concluido > 0) {
            // Calcula o percentual de conclusão
            $percentual = ($concluido * 100) / $total;
            return $percentual;
        } else {
            return 0;
        }
    }
    return 0;
}

// Função para obter o painel de tarefas de um usuário, considerando suas equipes e papéis
function getPainelTarefa(Usuario $user) {
    // Instancia o objeto ManterUsuario para manipulação de equipes
    $manterUsuario = new ManterUsuario();
    // Busca as equipes das quais o usuário é participante ou criador
    $equipesUsuario  = $manterUsuario->getEquipesUsuarioParticipante($user->id);
    $equipesCriador  = $manterUsuario->getEquipesUsuarioCriador($user->id);
    
    // Monta um filtro com os ids das equipes
    $filtro_equipes = "";
    foreach ($equipesUsuario as $eq) {
        if ($filtro_equipes === "") {
            $filtro_equipes .=  $eq->id;
        } else {
            $filtro_equipes .= ", ". $eq->id;
        }
    }
    foreach ($equipesCriador as $eq) {
        if ($filtro_equipes === "") {
            $filtro_equipes .=  $eq->id;
        } else {
            $filtro_equipes .= ", ". $eq->id;
        }
    }
    
    // Se houver equipes associadas, inclui um campo para total de tarefas por equipe
    $sql_equipe = "";
    $group= "";
    if ($filtro_equipes != "") {
        $group= "total_equipe,";
        $sql_equipe = "(SELECT count(*) FROM tarefa as t WHERE t.id_equipe IN (" . $filtro_equipes . ")) as total_equipe,";
    }

    // SQL para obter contagens de tarefas totais, por equipe, criador e responsável
    $sql = "SELECT
    (SELECT count(*) FROM tarefa) as total," . $sql_equipe . "
    (SELECT count(*) FROM tarefa as t WHERE t.id_criador=" . $user->id . ") as total_criador,
    (SELECT count(*) FROM tarefa as t WHERE t.id_responsavel=" . $user->id . ") as total_responsavel
    FROM tarefa 
    GROUP BY total," . $group . "total_criador,total_responsavel";
    
    $dados = new stdClass();
    // Executa a consulta SQL
    $resultado = $this->db->Execute($sql);
    if ($registro = $resultado->fetchRow()) {
        $dados->total = $registro["total"];
        $dados->total_equipe = 0;
        if ($filtro_equipes != "") {
            $dados->total_equipe = $registro["total_equipe"];
        }
        $dados->total_criador = $registro["total_criador"];
        $dados->total_responsavel = $registro["total_responsavel"];
    }
    return $dados;
}

// Função para obter o painel de tarefas concluídas de um usuário
function getPainelTarefaConcluidas(Usuario $user) {
    // SQL para contar tarefas concluídas
    $sql_concluidas = "SELECT t.id as concluidas,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id) as total,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id AND a.data_check > 0) as concluido
    FROM tarefa as t
    GROUP BY concluidas
    HAVING total > 0 AND total = concluido";
    
    $rs_concluidas = $this->db->Execute($sql_concluidas);
    $count_concluidas = $rs_concluidas->rowCount() != NULL ? $rs_concluidas->rowCount() : 0;

    // Busca id de equipes participantes e criador
    $manterUsuario = new ManterUsuario();
    $equipesUsuario  = $manterUsuario->getEquipesUsuarioParticipante($user->id);
    $equipesCriador  = $manterUsuario->getEquipesUsuarioCriador($user->id);
    
    // Monta o filtro de equipes
    $filtro_equipes = "";
    foreach ($equipesUsuario as $eq) {
        if ($filtro_equipes === "") {
            $filtro_equipes .=  $eq->id;
        } else {
            $filtro_equipes .= ", ". $eq->id;
        }
    }
    foreach ($equipesCriador as $eq) {
        if ($filtro_equipes === "") {
            $filtro_equipes .=  $eq->id;
        } else {
            $filtro_equipes .= ", ". $eq->id;
        }
    }
    
    // SQL para contar tarefas concluídas por equipe
    $count_concluidas_equipe = 0;
    if ($filtro_equipes != "") {
        $sql_concluidas_equipe = "SELECT t.id as concluidas,
        (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id) as total,
        (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id AND a.data_check > 0) as concluido
        FROM tarefa as t
        WHERE t.id_equipe IN (" . $filtro_equipes . ") 
        GROUP BY concluidas
        HAVING total > 0 AND total = concluido";
        $rs_concluidas_equipe = $this->db->Execute($sql_concluidas_equipe);
        $count_concluidas_equipe = $rs_concluidas_equipe->rowCount() != NULL ? $rs_concluidas_equipe->rowCount() : 0;
    }

    // SQL para contar tarefas concluídas por criador
    $sql_concluidas_criador = "SELECT t.id as concluidas,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id) as total,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id AND a.data_check > 0) as concluido
    FROM tarefa as t
    WHERE t.id_criador=" . $user->id . "
    GROUP BY concluidas
    HAVING total > 0 AND total = concluido";

    $rs_concluidas_criador = $this->db->Execute($sql_concluidas_criador);
    $count_concluidas_criador = $rs_concluidas_criador->rowCount() != NULL ? $rs_concluidas_criador->rowCount() : 0;

    // SQL para contar tarefas concluídas por responsável
    $sql_concluidas_responsavel = "SELECT t.id as concluidas,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id) as total,
    (SELECT count(*) FROM acao as a, etapa as e WHERE a.id_etapa=e.id AND e.id_tarefa=t.id AND a.data_check > 0) as concluido
    FROM tarefa as t
    WHERE t.id_responsavel=" . $user->id . "
    GROUP BY concluidas
    HAVING total > 0 AND total = concluido";

    $rs_concluidas_responsavel = $this->db->Execute($sql_concluidas_responsavel);
    $count_concluidas_responsavel = $rs_concluidas_responsavel->rowCount() != NULL ? $rs_concluidas_responsavel->rowCount() : 0;

    // Preenche o objeto de dados com os totais
    $dados = new stdClass();
    $dados->total = $count_concluidas;
    $dados->total_equipe = $count_concluidas_equipe;
    $dados->total_criador = $count_concluidas_criador;
    $dados->total_responsavel = $count_concluidas_responsavel;

    return $dados;
}
}