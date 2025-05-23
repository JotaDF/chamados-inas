<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');
require_once('dto/Usuario.php');
require_once('dto/Modulo.php');
require_once('dto/Acesso.php');
require_once('dto/Equipe.php');

class ManterUsuario extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.agenda,u.id_setor,u.aniversariantes,(select count(*) from acesso as a where a.id_usuario=u.id) as dep FROM usuario as u ".$filtro." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
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
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getUsuarioPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.agenda,u.ativo,u.id_setor,u.aniversariantes FROM usuario as u WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Usuario();
        while ($registro = $resultado->fetchRow()) {
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
        return $dados;
    }
    function getUsuarioPorLogin($login) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.agenda,u.ativo,u.id_setor,u.aniversariantes FROM usuario as u WHERE login='$login'";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Usuario();
        while ($registro = $resultado->fetchRow()) {
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
        return $dados;
    }
    function salvar(Usuario $dados) { 
        $sql = "insert into usuario (nome, login, matricula, cargo, email, nascimento, whatsapp, linkedin, ativo, id_setor) values ('" . $dados->nome . "','" . $dados->login . "','" . $dados->matricula . "','" . $dados->cargo . "','" . $dados->email . "','" . $dados->nascimento . "','" . $dados->whatsapp . "','" . $dados->linkedin . "',1,'" . $dados->setor . "')";
//        echo $sql . "<BR/>";
//        exit;
        if ($dados->id > 0) {
            $sql = "update usuario set nome=UPPER('" . $dados->nome . "'),login='" . $dados->login . "',matricula='" . $dados->matricula . "',cargo='" . $dados->cargo . "',email='" . $dados->email . "',nascimento='" . $dados->nascimento . "',whatsapp='" . $dados->whatsapp . "',linkedin='" . $dados->linkedin . "',id_setor='" . $dados->setor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function salvarPerfil(Usuario $dados) {
        $sql = "update usuario set whatsapp='" . $dados->whatsapp . "',linkedin='" . $dados->linkedin . "',aniversariantes='" . $dados->aniversariantes . "' where id=$dados->id";
        $resultado = $this->db->Execute($sql);
        //echo $sql . "<BR/>";
        return $resultado;
    }
    function desativar($id) {
        $sql = "update usuario set ativo=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        //echo $sql . "<BR/>";
        return $resultado;
    }
    function ativar($id) {
        $sql = "update usuario set ativo=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        //echo $sql . "<BR/>";
        return $resultado;
    }
    function excluir($id) {
        $sql = "delete from usuario where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getEditoresPorTarefa($id_tarefa) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_setor FROM usuario as u, editor as e WHERE e.id_usuario=u.id AND e.id_tarefa=".$id_tarefa." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
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
        $sql = "SELECT DISTINCT u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, 
        u.linkedin,u.ativo,u.id_setor 
                FROM usuario as u, equipe_usuario equ, tarefa as tt
                WHERE tt.id=".$id_tarefa." AND u.id=equ.id_usuario AND equ.id_equipe=tt.id_equipe 
                AND u.id NOT IN(SELECT e.id_usuario FROM editor as e, equipe_usuario as eu, tarefa as t WHERE eu.id_usuario=e.id_usuario AND e.id_tarefa=".$id_tarefa." AND t.id=".$id_tarefa."
                 AND eu.id_equipe = t.id_equipe)
                ORDER BY u.nome;";
        ;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
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
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_setor FROM usuario as u, equipe_usuario eu, tarefa as t WHERE t.id=$id_tarefa AND eu.id_equipe=t.id_equipe AND u.id=eu.id_usuario order by u.nome";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
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
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin, u.ativo,eu.id_equipe,u.id_setor,u.id_perfil FROM usuario as u, equipe_usuario as eu WHERE eu.id_usuario=u.id AND eu.id_equipe=$id_equipe order by u.nome";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
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
        $sql = "select e.id,e.equipe,e.descricao, e.criador FROM equipe as e where e.criador=".$id_usuario." order by e.id";
        $resultado = $this->db->Execute($sql);
        //print_r($resultado);
        //echo $sql;
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
    function getEquipesUsuarioParticipante($id_usuario) {
        $sql = "select e.id,e.equipe,e.descricao, e.criador FROM equipe as e, equipe_usuario as eu where eu.id_equipe=e.id AND eu.id_usuario=".$id_usuario." order by e.equipe";
        $resultado = $this->db->Execute($sql);
        //print_r($resultado);
        //echo $sql;
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
        $sql = "SELECT a.id_modulo, a.id_usuario, a.id_perfil, m.nome as modulo, p.perfil, m.icone, m.link 
        FROM acesso as a, modulo as m, perfil as p 
        WHERE p.id = a.id_perfil
        AND m.id = a.id_modulo 
        AND a.id_usuario =$id_usuario ORDER BY m.nome";
        //echo $sql;
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
    function getAcessoUsuario($id_usuario,$id_modulo) {
        $sql = "SELECT a.id_modulo, a.id_usuario, a.id_perfil, m.nome as modulo, p.perfil, m.icone, m.link 
        FROM acesso as a, modulo as m, perfil as p 
        WHERE p.id = a.id_perfil
        AND m.id = a.id_modulo 
        AND a.id_usuario =$id_usuario 
        AND a.id_modulo = $id_modulo";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $id_perfil = 0;
        if ($registro = $resultado->fetchRow()) {
            $id_perfil = $registro["id_perfil"];
        }
        return $id_perfil;
    }
    function encryptarMensagem(string $texto): string {
        $cipher = 'aes-256-cbc';
        if (!in_array($cipher, openssl_get_cipher_methods())) {
            die('Cipher não suportado: ' . $cipher);
        }
        // Gera uma chave de 256 bits (32 bytes) a partir da senha
        $iv_length = openssl_cipher_iv_length($cipher);
        // Gera um vetor de inicialização (IV) aleatório
        $iv = openssl_random_pseudo_bytes($iv_length);
        $key = "sai_que_e_sua_tafarell_inas_2025"; // Chave segura!
           
        $ciphertext = openssl_encrypt($texto, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        // Concatena o IV (Initialization Vector) ao texto cifrado para descriptografia
        return base64_encode($iv . $ciphertext);
    }
    function getModulosParaAcessosUsuario($id_usuario) {
        $sql = "SELECT m.id, m.nome  
        FROM modulo as m 
        WHERE  m.id NOT IN (SELECT a.id_modulo FROM acesso as a WHERE a.id_usuario = $id_usuario)
        ORDER BY m.nome";
        //echo $sql;
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
        $sql = "SELECT a.id_modulo, a.id_usuario, a.id_perfil 
        FROM acesso as a 
        WHERE a.id_perfil = 9
        AND a.id_modulo = 4";
        //echo $sql;
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
        $sql = "SELECT a.id_modulo, a.id_usuario, u.nome as usuario, a.id_perfil 
        FROM acesso as a, usuario as u
        WHERE a.id_usuario = u.id
        AND a.id_perfil = 9
        AND a.id_modulo = 5";
        //echo $sql;
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
    function salvarEditor($id,$tarefa,$op="add"){
        $sql = "insert into editor (id_usuario, id_tarefa) values ('" . $id . "','" . $tarefa . "')";
        //echo $sql . "<BR/>";
        //exit;
        if ($op != "add") {
            $sql = "DELETE FROM editor WHERE id_usuario=" . $id . " AND id_tarefa=" . $tarefa ;
        }
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function permitirAcesso($id_modulo,$id_usuario,$id_perfil){
        $sql = "insert into acesso (id_modulo,id_usuario,id_perfil) values ('" . $id_modulo . "','" . $id_usuario . "','" . $id_perfil . "')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function removerAcesso($id_modulo,$id_usuario){
        $sql = "DELETE FROM acesso WHERE id_usuario=" . $id_usuario . " AND id_modulo=" . $id_modulo ;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function listarAniversariantes($mes = "") {
        if ($mes == "") {
            $mes = "" . date("m");
        }
        $sql = "SELECT id, nome, id_setor, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%d') as dia, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') as mes FROM usuario WHERE ativo=1 AND aniversariantes=1 AND DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') = " . $mes . " ORDER BY dia, mes";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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

        return $array_dados;
    }
    function listarAniversariantesAll($mes = "") {
        if ($mes == "") {
            $mes = "" . date("m");
        }
        $sql = "SELECT id, nome, id_setor, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%d') as dia, DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') as mes FROM usuario WHERE ativo=1 AND aniversariantes=1 AND DATE_FORMAT(FROM_UNIXTIME(nascimento), '%m') = " . $mes . " ORDER BY dia, mes";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
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

        $sql70 = "SELECT id, nome, id_setor, nascimento FROM usuario WHERE ativo=1 AND aniversariantes=1 AND nascimento <= 0 ORDER BY nascimento";
        $resultado70 = $this->db->Execute($sql70);
        while ($registro70 = $resultado70->fetchRow()) {
            if (date('m', $registro70["nascimento"]) === $mes) {
                $dados = new stdClass();
                $dados->id = $registro70["id"];
                $dados->nome = $registro70["nome"];
                $dados->setor = $registro70["id_setor"];
                $dados->nascimento = $registro70["nascimento"];
                $dados->dia =date('d', $registro70["nascimento"]);
                $dados->mes = date('m', $registro70["nascimento"]);
                $array_dados[] = $dados;
            }
        }

        return $array_dados;
    }
    function buscar($filtro = "") {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.ativo,u.id_setor, s.sigla FROM usuario as u, setor as s WHERE u.id_setor=s.id ".$filtro." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();

            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->ativo = $registro["ativo"];
            $dados->setor = $registro["id_setor"];
            $dados->sigla = $registro["sigla"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function permitirAgenda($id){
        $sql = "UPDATE usuario SET agenda=1 WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function removerAgenda($id){
        $sql = "UPDATE usuario SET agenda=0 WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getInscritosEvento($id_evento) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.ativo,u.id_setor, s.sigla, i.registro FROM usuario as u, setor as s, inscricao as i WHERE u.id_setor=s.id AND u.id=i.id_usuario AND i.id_evento = ".$id_evento." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();

            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->ativo = $registro["ativo"];
            $dados->setor = $registro["id_setor"];
            $dados->sigla = $registro["sigla"];
            $dados->registro = $registro["registro"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
}
