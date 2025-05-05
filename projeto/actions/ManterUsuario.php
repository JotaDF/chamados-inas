<?php

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário padrão
require_once('Model.php'); // Importa a classe base Model
require_once('dto/Usuario.php'); // Importa o DTO do usuário
require_once('dto/Modulo.php'); // Importa o DTO do módulo
require_once('dto/Acesso.php'); // Importa o DTO do acesso
require_once('dto/Equipe.php'); // Importa o DTO da equipe

class ManterUsuario extends Model {

    function __construct() { // Método construtor da classe
        parent::__construct(); // Chama o construtor da classe pai (Model)
    }

    // Função para listar usuários com filtro opcional
    function listar($filtro = "") {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.agenda,u.id_setor,u.aniversariantes,
                (select count(*) from acesso as a where a.id_usuario=u.id) as dep 
                FROM usuario as u $filtro order by u.nome";
        $resultado = $this->db->Execute($sql); // Executa a query no banco
        $array_dados = array(); // Inicializa o array de retorno

        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario(); // Cria novo objeto Usuario
            $dados->excluir = true; // Permissão de exclusão padrão

            if ($registro["dep"] > 0) { // Se existir dependência (acessos)
                $dados->excluir = false; // Não permitir exclusão
            }

            // Atribui os dados do banco ao objeto
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]); // Formata data
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->agenda = $registro["agenda"];
            $dados->setor = $registro["id_setor"];
            $dados->aniversariantes = $registro["aniversariantes"];

            $array_dados[] = $dados; // Adiciona ao array de retorno
        }

        return $array_dados; // Retorna lista de usuários
    }

    // Função para obter dados de um usuário específico por ID
    function getUsuarioPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.agenda,u.ativo,u.id_setor,u.aniversariantes 
                FROM usuario as u WHERE id=$id";
        $resultado = $this->db->Execute($sql); // Executa consulta

        $dados = new Usuario(); // Cria objeto Usuario
        while ($registro = $resultado->fetchRow()) {
            // Preenche o objeto com os dados obtidos
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->agenda = $registro["agenda"];
            $dados->setor = $registro["id_setor"];
            $dados->aniversariantes = $registro["aniversariantes"];
        }

        return $dados; // Retorna o objeto Usuario preenchido
    }

    // Função para obter dados de um usuário pelo login
    function getUsuarioPorLogin($login) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.agenda,u.ativo,u.id_setor,u.aniversariantes 
                FROM usuario as u WHERE login='$login'";
        $resultado = $this->db->Execute($sql); // Executa consulta

        $dados = new Usuario(); // Cria objeto Usuario
        while ($registro = $resultado->fetchRow()) {
            // Preenche os campos com os dados retornados
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->agenda = $registro["agenda"];
            $dados->setor = $registro["id_setor"];
            $dados->aniversariantes = $registro["aniversariantes"];
        }

        return $dados; // Retorna o objeto preenchido
    }

    // Função para salvar ou atualizar dados de um usuário
    function salvar(Usuario $dados) {
        // SQL para inserir novo usuário
        $sql = "insert into usuario (nome, login, matricula, cargo, email, nascimento, whatsapp, linkedin, ativo, id_setor) 
                values ('" . $dados->nome . "','" . $dados->login . "','" . $dados->matricula . "','" . $dados->cargo . "','" . $dados->email . "','" . $dados->nascimento . "','" . $dados->whatsapp . "','" . $dados->linkedin . "',1,'" . $dados->setor . "')";

        if ($dados->id > 0) { // Se já existe um ID, atualiza em vez de inserir
            $sql = "update usuario set nome=UPPER('" . $dados->nome . "'),login='" . $dados->login . "',matricula='" . $dados->matricula . "',cargo='" . $dados->cargo . "',email='" . $dados->email . "',nascimento='" . $dados->nascimento . "',whatsapp='" . $dados->whatsapp . "',linkedin='" . $dados->linkedin . "',id_setor='" . $dados->setor . "' 
                    where id=$dados->id";
            $resultado = $this->db->Execute($sql); // Executa update
        } else {
            $resultado = $this->db->Execute($sql); // Executa insert
            $dados->id = $this->db->insert_Id(); // Recupera ID gerado
        }

        return $resultado; // Retorna resultado da operação
    }

    // Função para atualizar perfil do usuário (WhatsApp, LinkedIn, aniversariantes)
    function salvarPerfil(Usuario $dados) {
        $sql = "update usuario set whatsapp='" . $dados->whatsapp . "',linkedin='" . $dados->linkedin . "',aniversariantes='" . $dados->aniversariantes . "' 
                where id=$dados->id";
        $resultado = $this->db->Execute($sql); // Executa update
        return $resultado;
    }

    // Função para desativar o usuário (definir ativo como 0)
    function desativar($id) {
        $sql = "update usuario set ativo=0 where id=$id";
        $resultado = $this->db->Execute($sql); // Executa update
        return $resultado;
    }

    // Função para ativar o usuário (definir ativo como 1)
    function ativar($id) {
        $sql = "update usuario set ativo=1 where id=$id";
        $resultado = $this->db->Execute($sql); // Executa update
        return $resultado;
    }


function excluir($id) {
    // Executa uma instrução SQL para remover um usuário do banco de dados com base no ID fornecido
    $sql = "delete from usuario where id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

function getEditoresPorTarefa($id_tarefa) {
    // Seleciona os dados dos usuários que são editores de uma determinada tarefa
    $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_setor 
            FROM usuario as u, editor as e 
            WHERE e.id_usuario=u.id AND e.id_tarefa=".$id_tarefa." 
            order by u.nome";
    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario();
        $dados->excluir = true;

        // OBS: o campo "dep" não está presente na query acima, essa verificação provavelmente está incorreta aqui
        if ($registro["dep"] > 0) {
            $dados->excluir = false;
        }

        // Preenche os dados do usuário com base no resultado da query
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $dados->login = $registro["login"];
        $dados->matricula = $registro["matricula"];
        $dados->cargo = $registro["cargo"];
        $dados->email = $registro["email"];
        $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
        $dados->whatsapp = $registro["whatsapp"];
        $dados->linkedin = $registro["linkedin"];
        $dados->ativo = $registro["ativo"];
        $dados->setor = $registro["id_setor"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

function getNaoEditoresPorTarefa($id_tarefa) {
    // Seleciona os usuários da equipe da tarefa que não são editores da tarefa
    $sql = "SELECT DISTINCT u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, 
        u.linkedin,u.ativo,u.id_setor 
            FROM usuario as u, equipe_usuario equ, tarefa as tt
            WHERE tt.id=".$id_tarefa." AND u.id=equ.id_usuario AND equ.id_equipe=tt.id_equipe 
            AND u.id NOT IN(
                SELECT e.id_usuario 
                FROM editor as e, equipe_usuario as eu, tarefa as t 
                WHERE eu.id_usuario=e.id_usuario AND e.id_tarefa=".$id_tarefa." 
                AND t.id=".$id_tarefa." AND eu.id_equipe = t.id_equipe
            )
            ORDER BY u.nome;";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario();
        $dados->excluir = true;

        // Preenche os dados do usuário
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $dados->login = $registro["login"];
        $dados->matricula = $registro["matricula"];
        $dados->cargo = $registro["cargo"];
        $dados->email = $registro["email"];
        $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
        $dados->whatsapp = $registro["whatsapp"];
        $dados->linkedin = $registro["linkedin"];
        $dados->ativo = $registro["ativo"];
        $dados->setor = $registro["id_setor"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

function getUsuariosEquipePorTarefa($id_tarefa) {
    // Busca os usuários da equipe associada a uma tarefa específica
    $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_setor 
            FROM usuario as u, equipe_usuario eu, tarefa as t 
            WHERE t.id=$id_tarefa AND eu.id_equipe=t.id_equipe AND u.id=eu.id_usuario 
            order by u.nome";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario();
        $dados->excluir = true;

        // OBS: novamente, "dep" não existe na query; essa verificação deve ser revisada
        if ($registro["dep"] > 0) {
            $dados->excluir = false;
        }

        // Preenche os dados do usuário
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $dados->login = $registro["login"];
        $dados->matricula = $registro["matricula"];
        $dados->cargo = $registro["cargo"];
        $dados->email = $registro["email"];
        $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
        $dados->whatsapp = $registro["whatsapp"];
        $dados->linkedin = $registro["linkedin"];
        $dados->ativo = $registro["ativo"];
        $dados->setor = $registro["id_setor"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

function getUsuariosPorEquipe($id_equipe) {
    // Retorna todos os usuários pertencentes a uma equipe específica
    $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin, 
                   u.ativo,eu.id_equipe,u.id_setor,u.id_perfil 
            FROM usuario as u, equipe_usuario as eu 
            WHERE eu.id_usuario=u.id AND eu.id_equipe=$id_equipe 
            order by u.nome";

    $resultado = $this->db->Execute($sql);
    $array_dados = array();

    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario();
        $dados->excluir = true;

        // OBS: o campo "dep" também não está na query aqui; essa verificação pode ser removida ou ajustada
        if ($registro["dep"] > 0) {
            $dados->excluir = false;
        }

        // Preenche os dados do usuário
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $dados->login = $registro["login"];
        $dados->matricula = $registro["matricula"];
        $dados->cargo = $registro["cargo"];
        $dados->email = $registro["email"];
        $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
        $dados->whatsapp = $registro["whatsapp"];
        $dados->linkedin = $registro["linkedin"];
        $dados->ativo = $registro["ativo"];
        $dados->equipe = $registro["id_equipe"];
        $dados->setor = $registro["id_setor"];
        $dados->perfil = $registro["id_perfil"];

        $array_dados[] = $dados;
    }

    return $array_dados;
}

function getEquipesUsuarioCriador($id_usuario) {
    // Consulta equipes criadas pelo usuário com base no id_usuario
    $sql = "select e.id,e.equipe,e.descricao, e.criador FROM equipe as e where e.criador=".$id_usuario." order by e.id";
    $resultado = $this->db->Execute($sql);
    
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Equipe();
        $dados->excluir = true; // Marca como possível de excluir (padrão)
        $dados->id        = $registro["id"];
        $dados->equipe    = $registro["equipe"];
        $dados->descricao = $registro["descricao"];
        $dados->criador   = $registro["criador"];
        $array_dados[]    = $dados;
    }
    return $array_dados;
}

function getEquipesUsuarioParticipante($id_usuario) {
    // Busca todas as equipes das quais o usuário participa (não apenas as que criou)
    $sql = "select e.id,e.equipe,e.descricao, e.criador FROM equipe as e, equipe_usuario as eu where eu.id_equipe=e.id AND eu.id_usuario=".$id_usuario." order by e.equipe";
    $resultado = $this->db->Execute($sql);
    
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Equipe();
        $dados->excluir = true;
        $dados->id        = $registro["id"];
        $dados->equipe    = $registro["equipe"];
        $dados->descricao = $registro["descricao"];
        $dados->criador   = $registro["criador"];
        $array_dados[]    = $dados;
    }
    return $array_dados;
}

function getAcessosUsuario($id_usuario) {
    // Busca todos os acessos que o usuário tem (módulo, perfil, ícone etc.)
    $sql = "SELECT a.id_modulo, a.id_usuario, a.id_perfil, m.nome as modulo, p.perfil, m.icone, m.link 
            FROM acesso as a, modulo as m, perfil as p 
            WHERE p.id = a.id_perfil
            AND m.id = a.id_modulo 
            AND a.id_usuario = $id_usuario ORDER BY m.nome";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Acesso();
        $dados->excluir = true;
        $dados->id_modulo = $registro["id_modulo"];
        $dados->id_usuario = $registro["id_usuario"];
        $dados->id_perfil = $registro["id_perfil"];
        $dados->modulo = $registro["modulo"];
        $dados->perfil = $registro["perfil"];
        $dados->link = $registro["link"];
        $dados->icone = $registro["icone"];
        $array_dados[] = $dados;
    }
    return $array_dados;
}

function getModulosParaAcessosUsuario($id_usuario) {
    // Retorna os módulos que o usuário ainda não possui acesso
    $sql = "SELECT m.id, m.nome  
            FROM modulo as m 
            WHERE m.id NOT IN (SELECT a.id_modulo FROM acesso as a WHERE a.id_usuario = $id_usuario)
            ORDER BY m.nome";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Modulo();
        $dados->excluir = true;
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $array_dados[] = $dados;
    }
    return $array_dados;
}

function getAtendentesChamado() {
    // Busca atendentes de chamados (perfil 9 e módulo 4)
    $sql = "SELECT a.id_modulo, a.id_usuario, a.id_perfil 
            FROM acesso as a 
            WHERE a.id_perfil = 9
            AND a.id_modulo = 4";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Acesso();
        $dados->id_modulo = $registro["id_modulo"];
        $dados->id_usuario = $registro["id_usuario"];
        $dados->id_perfil = $registro["id_perfil"];
        $array_dados[] = $dados;
    }
    return $array_dados;
}

function getAtendentesBeneficiario() {
    // Busca atendentes de beneficiários (perfil 9 e módulo 5), incluindo o nome do usuário
    $sql = "SELECT a.id_modulo, a.id_usuario, u.nome as usuario, a.id_perfil 
            FROM acesso as a, usuario as u
            WHERE a.id_usuario = u.id
            AND a.id_perfil = 9
            AND a.id_modulo = 5";
    
    $resultado = $this->db->Execute($sql);
    $array_dados = array();
    while ($registro = $resultado->fetchRow()) {
        $dados = new Acesso();
        $dados->id_modulo = $registro["id_modulo"];
        $dados->id_usuario = $registro["id_usuario"];
        $dados->usuario = $registro["usuario"];
        $dados->id_perfil = $registro["id_perfil"];
        $array_dados[] = $dados;
    }
    return $array_dados;
}

function salvarEditor($id, $tarefa, $op="add") {
    // Se a operação for diferente de "add", executa exclusão
    if ($op != "add") {
        $sql = "DELETE FROM editor WHERE id_usuario=" . $id . " AND id_tarefa=" . $tarefa;
    } else {
        // Caso contrário, adiciona um novo editor para a tarefa
        $sql = "insert into editor (id_usuario, id_tarefa) values ('" . $id . "','" . $tarefa . "')";
    }
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

function permitirAcesso($id_modulo, $id_usuario, $id_perfil) {
    // Concede acesso a um módulo para o usuário com determinado perfil
    $sql = "insert into acesso (id_modulo,id_usuario,id_perfil) values ('" . $id_modulo . "','" . $id_usuario . "','" . $id_perfil . "')";
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

function removerAcesso($id_modulo, $id_usuario) {
    // Remove o acesso de um módulo para o usuário
    $sql = "DELETE FROM acesso WHERE id_usuario=" . $id_usuario . " AND id_modulo=" . $id_modulo;
    $resultado = $this->db->Execute($sql);
    return $resultado;
}

function listarAniversariantes($mes = "") {
    // Se nenhum mês for passado, usa o mês atual
    if ($mes == "") {
        $mes = "" . date("m");
    }

    // Consulta os usuários ativos e marcados como aniversariantes no mês especificado
    $sql = "SELECT id, nome, id_setor, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%d') as dia, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') as mes FROM usuario WHERE ativo=1 AND aniversariantes=1 AND DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') = " . $mes . " ORDER BY dia, mes";

    // Executa a consulta
    $resultado = $this->db->Execute($sql);

    $array_dados = array(); // Inicializa o array que armazenará os dados dos aniversariantes

    // Itera sobre os resultados da consulta
    while ($registro = $resultado->fetchRow()) {
        $dados = new stdClass(); // Cria objeto genérico para armazenar os dados
        $dados->id = $registro["id"]; // ID do usuário
        $dados->nome = $registro["nome"]; // Nome do usuário
        $dados->setor = $registro["id_setor"]; // Setor do usuário
        $dados->dia = $registro["dia"]; // Dia do nascimento
        $dados->mes = $registro["mes"]; // Mês do nascimento
        $dados->nascimento = ""; // Inicializa a data de nascimento como vazia
        $array_dados[] = $dados; // Adiciona ao array final
    }

    return $array_dados; // Retorna a lista de aniversariantes
}

function listarAniversariantesAll($mes = "") {
    // Se nenhum mês for passado, usa o mês atual
    if ($mes == "") {
        $mes = "" . date("m");
    }

    // Consulta os aniversariantes com data válida
    $sql = "SELECT id, nome, id_setor, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%d') as dia, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') as mes FROM usuario WHERE ativo=1 AND aniversariantes=1 AND DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') = " . $mes . " ORDER BY dia, mes";
    $resultado = $this->db->Execute($sql);

    $array_dados = array(); // Array que conterá todos os aniversariantes

    // Processa os registros com data de nascimento válida
    while ($registro = $resultado->fetchRow()) {
        $dados = new stdClass();
        $dados->id = $registro["id"];
        $dados->nome = $registro["nome"];
        $dados->setor = $registro["id_setor"];
        $dados->dia = $registro["dia"];
        $dados->mes = $registro["mes"];
        $dados->nascimento = "";
        $array_dados[] = $dados;
    }

    // Consulta usuários com nascimento <= 0 (possivelmente registros antigos)
    $sql70 = "SELECT id, nome, id_setor, nascimento FROM usuario WHERE ativo=1 AND aniversariantes=1 AND nascimento <= 0 ORDER BY nascimento";
    $resultado70 = $this->db->Execute($sql70);

    // Processa esses registros somente se o mês coincidir
    while ($registro70 = $resultado70->fetchRow()) {
        if (date('m', $registro70["nascimento"]) === $mes) {
            $dados = new stdClass();
            $dados->id = $registro70["id"];
            $dados->nome = $registro70["nome"];
            $dados->setor = $registro70["id_setor"];
            $dados->nascimento = $registro70["nascimento"];
            $dados->dia = date('d', $registro70["nascimento"]);
            $dados->mes = date('m', $registro70["nascimento"]);
            $array_dados[] = $dados;
        }
    }

    return $array_dados; // Retorna lista completa de aniversariantes
}

function buscar($filtro = "") {
    // Monta SQL com possível filtro adicional
    $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.ativo,u.id_setor, s.sigla FROM usuario as u, setor as s WHERE u.id_setor=s.id " . $filtro . " order by u.nome";

    // Executa a consulta
    $resultado = $this->db->Execute($sql);

    $array_dados = array(); // Inicializa o array que armazenará os usuários encontrados

    // Processa os resultados da consulta
    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario(); // Cria instância da classe Usuario
        $dados->id = $registro["id"]; // ID do usuário
        $dados->nome = $registro["nome"]; // Nome
        $dados->matricula = $registro["matricula"]; // Matrícula
        $dados->cargo = $registro["cargo"]; // Cargo
        $dados->email = $registro["email"]; // E-mail
        $dados->ativo = $registro["ativo"]; // Status ativo
        $dados->setor = $registro["id_setor"]; // ID do setor
        $dados->sigla = $registro["sigla"]; // Sigla do setor
        $array_dados[] = $dados; // Adiciona ao array final
    }

    return $array_dados; // Retorna os usuários encontrados
}

function permitirAgenda($id){
    // Atualiza o campo agenda para 1 (permitido) no usuário especificado
    $sql = "UPDATE usuario SET agenda=1 WHERE id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da operação
}

function removerAgenda($id){
    // Atualiza o campo agenda para 0 (removido) no usuário especificado
    $sql = "UPDATE usuario SET agenda=0 WHERE id=" . $id;
    $resultado = $this->db->Execute($sql);
    return $resultado; // Retorna o resultado da operação
}

function getInscritosEvento($id_evento) {
    // Consulta todos os usuários inscritos em um determinado evento
    $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.ativo,u.id_setor, s.sigla, i.registro FROM usuario as u, setor as s, inscricao as i WHERE u.id_setor=s.id AND u.id=i.id_usuario AND i.id_evento = " . $id_evento . " order by u.nome";

    $resultado = $this->db->Execute($sql);
    $array_dados = array(); // Inicializa o array que armazenará os inscritos

    // Processa os resultados da consulta
    while ($registro = $resultado->fetchRow()) {
        $dados = new Usuario(); // Cria nova instância de usuário
        $dados->id = $registro["id"]; // ID do usuário
        $dados->nome = $registro["nome"]; // Nome
        $dados->matricula = $registro["matricula"]; // Matrícula
        $dados->cargo = $registro["cargo"]; // Cargo
        $dados->email = $registro["email"]; // E-mail
        $dados->ativo = $registro["ativo"]; // Status ativo
        $dados->setor = $registro["id_setor"]; // Setor
        $dados->sigla = $registro["sigla"]; // Sigla do setor
        $dados->registro = $registro["registro"]; // Registro da inscrição
        $array_dados[] = $dados; // Adiciona ao array final
    }

    return $array_dados; // Retorna os usuários inscritos no evento
}
}