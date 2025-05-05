<?php

// Requerendo a classe Model e a classe Fila
require_once('Model.php');
require_once('dto/Fila.php');

// A classe ManterFila herda de Model
class ManterFila extends Model {

    // Método construtor que chama o construtor da classe pai (Model)
    function __construct() { 
        parent::__construct();
    }

    // Método para listar todos os registros da fila
    function listar() {
        // SQL para buscar os registros da tabela 'fila' com cálculos e contagens
        $sql = "select f.id, f.cpf, f.nome, f.preferencial, f.entrada, f.qtd_chamadas, f.atendido, f.id_servico, f.chamar, 
        f.ultima_chamada, f.id_guiche_chamador,TIMESTAMPDIFF(MINUTE, f.entrada,  now()) as tempo, (select count(*) from atendimento as a where a.id_fila=f.id) as dep 
        FROM fila as f order by f.id";

        // Executando a consulta e armazenando o resultado
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        
        // Loop para percorrer os resultados e montar objetos da classe Fila
        while ($registro = $resultado->fetchRow()) {
            $dados = new Fila();
            $dados->excluir = true; // Inicializa a flag de exclusão como verdadeira
            if ($registro["dep"] > 0) {
                $dados->excluir = false; // Se houver dependentes, não permite exclusão
            }
            
            // Preenchendo os dados da fila no objeto Fila
            $dados->id              = $registro["id"];
            $dados->cpf             = $registro["cpf"];
            $dados->nome            = $registro["nome"];
            $dados->preferencial    = $registro["preferencial"];
            $dados->entrada         = $registro["entrada"];
            $dados->qtd_chamadas    = $registro["qtd_chamadas"];
            $dados->atendido        = $registro["atendido"];
            $dados->servico         = $registro["id_servico"];
            $dados->chamar          = $registro["chamar"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->guiche_chamador = $registro["id_guiche_chamador"];
            $dados->tempo           = $registro["tempo"];
            $array_dados[]          = $dados; // Adicionando o objeto Fila no array
        }
        return $array_dados; // Retorna o array de filas
    }

    // Método para buscar as filas não atendidas e dentro do tempo limite
    function getFila() {
        $sql = "SELECT f.id, f.cpf, f.nome, f.preferencial, f.entrada, f.qtd_chamadas, f.atendido, f.id_servico, f.chamar, f.ultima_chamada, f.id_guiche_chamador, 
        TIMESTAMPDIFF(MINUTE, f.entrada,  now()) as tempo 
        FROM fila as f 
        WHERE f.atendido is NULL AND TIMESTAMPDIFF(MINUTE, f.entrada, now()) <= 720 order by f.preferencial DESC, f.entrada";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Fila();
            $dados->id              = $registro["id"];
            $dados->cpf             = $registro["cpf"];
            $dados->nome            = $registro["nome"];
            $dados->preferencial    = $registro["preferencial"];
            $dados->entrada         = $registro["entrada"];
            $dados->qtd_chamadas    = $registro["qtd_chamadas"];
            $dados->atendido        = $registro["atendido"];
            $dados->servico         = $registro["id_servico"];
            $dados->chamar          = $registro["chamar"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->guiche_chamador = $registro["id_guiche_chamador"];
            $dados->tempo           = $registro["tempo"];
            $array_dados[]          = $dados; // Adicionando o objeto Fila no array
        }
        return $array_dados; // Retorna o array de filas não atendidas
    }

    // Método para buscar uma fila por ID
    function getFilaPorId($id) {
        $sql = "select f.id, f.cpf, f.nome, f.preferencial, f.entrada, f.qtd_chamadas, f.atendido, f.id_servico, f.chamar, 
        f.ultima_chamada, f.id_guiche_chamador, TIMESTAMPDIFF(MINUTE, f.entrada,  now()) as tempo 
        FROM fila as f WHERE id=$id";

        $resultado = $this->db->Execute($sql);
        $dados = new Fila();

        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->cpf             = $registro["cpf"];
            $dados->nome            = $registro["nome"];
            $dados->preferencial    = $registro["preferencial"];
            $dados->entrada         = $registro["entrada"];
            $dados->qtd_chamadas    = $registro["qtd_chamadas"];
            $dados->atendido        = $registro["atendido"];
            $dados->servico         = $registro["id_servico"];
            $dados->chamar          = $registro["chamar"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->guiche_chamador = $registro["id_guiche_chamador"];
            $dados->tempo           = $registro["tempo"];
        }
        return $dados; // Retorna os dados da fila com o ID especificado
    }

    // Método para salvar ou atualizar a fila
    function salvar(Fila $dados) {
        $sql = "insert into fila (cpf,nome, preferencial, entrada, qtd_chamadas, atendido, id_servico, chamar, ultima_chamada) 
        values ('" . $dados->cpf . "','" . $dados->nome . "','" . $dados->preferencial . "',now(),0,NULL,'" . $dados->servico . "',0,NULL)";

        // Verificando se a fila tem ID (atualização) ou é nova (inserção)
        if ($dados->id > 0) {
            $sql = "update fila set cpf='" . $dados->cpf . "',nome='" . $dados->nome . "',preferencial='" . $dados->preferencial . "',id_servico='" . $dados->servico . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id(); // Obtendo o ID da última inserção
        }
        return $resultado; // Retorna o resultado da operação
    }

    // Método para chamar um cliente na fila (incrementa a quantidade de chamadas)
    function chamar($id, $id_guiche) {
        $sql = "update fila set chamar=1,  qtd_chamadas=(qtd_chamadas+1), ultima_chamada = now(), id_guiche_chamador=$id_guiche where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado; // Retorna o resultado da operação
    }

    // Método para cancelar um chamado
    function cancelarChamado($id) {
        $sql = "update fila set chamar=0,  qtd_chamadas=0, ultima_chamada = NULL, id_guiche_chamador=NULL where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado; // Retorna o resultado da operação
    }

    // Método para indicar que o painel chamou um cliente
    function chamouPainel($id) {
        $sql = "update fila set chamar=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado; // Retorna o resultado da operação
    }

    // Método para marcar um cliente como atendido
    function atender($id) {
        $sql = "update fila set atendido=now() where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado; // Retorna o resultado da operação
    }

    // Método para obter o próximo chamado no painel
    function getProximoChamadoPainel() {
        $sql = "SELECT f.id, f.cpf, f.nome, f.preferencial, f.entrada, f.qtd_chamadas, f.atendido, f.id_servico, f.chamar, f.ultima_chamada, f.id_guiche_chamador, g.numero, 
        TIMESTAMPDIFF(MINUTE, f.entrada, now()) as tempo 
        FROM fila as f, guiche as g 
        WHERE g.id=f.id_guiche_chamador AND f.ultima_chamada is not NULL AND f.chamar=1 AND TIMESTAMPDIFF(MINUTE, f.entrada, now()) <= 720 order by f.ultima_chamada DESC LIMIT 1";
        
        $resultado = $this->db->Execute($sql);
        $dados = new Fila();

        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->cpf             = $registro["cpf"];
            $dados->nome            = $registro["nome"];
            $dados->preferencial    = $registro["preferencial"];
            $dados->entrada         = $registro["entrada"];
            $dados->qtd_chamadas    = $registro["qtd_chamadas"];
            $dados->atendido        = $registro["atendido"];
            $dados->servico         = $registro["id_servico"];
            $dados->chamar          = $registro["chamar"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->id_guiche_chamador = $registro["id_guiche_chamador"];
            $dados->guiche_chamador = $registro["numero"];
            $dados->tempo           = $registro["tempo"];
        }
        return $dados; // Retorna o próximo chamado
    }

    // Método para obter os chamados no painel
    function getChamadosPainel() {
        $sql = "SELECT f.id, f.cpf, f.nome, f.preferencial, f.entrada, f.qtd_chamadas, f.atendido, f.id_servico, f.chamar, f.ultima_chamada, f.id_guiche_chamador, g.numero, 
        TIMESTAMPDIFF(MINUTE, f.entrada, now()) as tempo 
        FROM fila as f , guiche as g
        WHERE g.id=f.id_guiche_chamador AND f.ultima_chamada is not NULL AND TIMESTAMPDIFF(MINUTE, f.entrada, now()) <= 720 order by f.ultima_chamada DESC LIMIT 4;";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();

        while ($registro = $resultado->fetchRow()) {
            $dados = new Fila();
            $dados->id              = $registro["id"];
            $dados->cpf             = $registro["cpf"];
            $dados->nome            = $registro["nome"];
            $dados->preferencial    = $registro["preferencial"];
            $dados->entrada         = $registro["entrada"];
            $dados->qtd_chamadas    = $registro["qtd_chamadas"];
            $dados->atendido        = $registro["atendido"];
            $dados->servico         = $registro["id_servico"];
            $dados->chamar          = $registro["chamar"];
            $dados->ultima_chamada  = $registro["ultima_chamada"];
            $dados->id_guiche_chamador = $registro["id_guiche_chamador"];
            $dados->guiche_chamador = $registro["numero"];
            $dados->tempo           = $registro["tempo"];
            $array_dados[]          = $dados; // Adicionando no array
        }
        return $array_dados; // Retorna os chamados no painel
    }

    // Método para verificar se o guichê já chamou alguém
    function isChamou($guiche) {
        $sql = "SELECT * FROM fila as f 
        WHERE f.atendido is NULL AND f.id_guiche_chamador =" . $guiche;
        
        $resultado = $this->db->Execute($sql);
        
        // Se o guichê tiver chamado alguém, retorna true
        while ($registro = $resultado->fetchRow()) {
            return true;
        }
        return false; // Caso contrário, retorna false
    }

    // Método para excluir uma fila
    function excluir($id) {
        $sql = "delete from fila where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado; // Retorna o resultado da operação
    }

}

