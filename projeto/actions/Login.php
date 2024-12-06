<?php

include_once('Model.php');
include_once('ManterUsuario.php');

class Login extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function logar($login, $senha) {
        $sql = "SELECT id, nome, cargo, login, matricula, id_perfil, id_equipe, id_setor, agenda FROM usuario   WHERE login='" . $login . "' AND ativo=1";
        //echo 'SQL:'.$sql;
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            $server = '10.194.250.111';
            $domain = '@governo.gdfnet.df';
            $port = 389;

            $connection = ldap_connect($server, $port);
            if (!$connection) {
                return false;
            }

            // Help talking to AD
            ldap_set_option($connection , LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($connection , LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($connection, $login.$domain, $senha);
            if (!$bind) {
                return false;
            }
            $dados = new Usuario();
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->cargo       = $registro["cargo"];
            $dados->login       = $registro["login"];
            $dados->matricula   = $registro["matricula"];
            $dados->senha       = $senha;
            $dados->ativo       = $registro["ativo"];
            $dados->equipe      = $registro["id_equipe"];
            $dados->setor       = $registro["id_setor"];
            $dados->perfil      = $registro["id_perfil"];
            $dados->agenda      = $registro["agenda"];

            ldap_close($connection );
            return $dados;
        }
        return false;
    }

}

?>