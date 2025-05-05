<?php

require_once('Model.php');  // Requer o arquivo Model.php para herdar funcionalidades
require_once('dto/Evento.php');  // Requer o arquivo Evento.php, que contém a definição do DTO (Data Transfer Object) Evento

class ManterEvento extends Model {

    function __construct() { // Método construtor da classe
        parent::__construct();  // Chama o construtor da classe pai (Model)
    }

    function listar($filtro = "") { // Método para listar eventos com base no filtro fornecido
        $sql = "select e.id,e.descricao, e.titulo, e.inscreve, e.data, e.hora, e.status, (select count(*) from inscricao as n where n.id_evento=e.id) as dep FROM evento as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);  // Executa a consulta SQL
        $array_dados = array();  // Cria um array para armazenar os eventos
        while ($registro = $resultado->fetchRow()) {  // Loop para pegar os registros do resultado
            $dados = new Evento();  // Cria um novo objeto Evento
            $dados->excluir = true;  // Define a propriedade excluir como verdadeira por padrão
            if ($registro["dep"] > 0) {  // Se houver dependências (inscrições), não pode excluir
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];  // Atribui os valores dos campos do banco ao objeto
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
            $array_dados[]      = $dados;  // Adiciona o objeto ao array de dados
        }
        return $array_dados;  // Retorna o array com os eventos
    }

    function getEventoPorId($id) {  // Método para obter um evento específico pelo ID
        $sql = "select e.id,e.descricao, e.titulo, e.inscreve, e.data, e.hora, e.status FROM evento as e WHERE id=$id";
        $resultado = $this->db->Execute($sql);  // Executa a consulta SQL
        $dados = new Evento();  // Cria um novo objeto Evento
        while ($registro = $resultado->fetchRow()) {  // Loop para pegar o registro do resultado
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
        }
        return $dados;  // Retorna o objeto Evento com os dados
    }

    function getEventoAtivo() {  // Método para obter o evento ativo
        $sql = "select e.id, e.descricao, e.titulo, e.inscreve, e.data, e.hora,e.status FROM evento as e WHERE status=1";
        $resultado = $this->db->Execute($sql);  // Executa a consulta SQL
        $dados = new Evento();  // Cria um novo objeto Evento
        if ($registro = $resultado->fetchRow()) {  // Se encontrar um evento ativo
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
        } 
        return $dados;  // Retorna o evento ativo
    }

    function salvar(Evento $dados) {  // Método para salvar ou atualizar um evento
        $sql = "insert into evento (titulo, descricao, inscreve, data, hora) 
                values ('" . $dados->titulo . "','" . $dados->descricao . "'," . $dados->inscreve . ",'" . $dados->data . "','" . $dados->hora . "')";
        if ($dados->id > 0) {  // Se o evento já existir (id > 0), faz um update
            $sql = "update evento set titulo='" . $dados->titulo . "',descricao='" . $dados->descricao . "',inscreve='" . $dados->inscreve . "',data='" . $dados->data . "',hora='" . $dados->hora . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);  // Executa o update
        } else {  // Se o evento não existir, faz um insert
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();  // Pega o ID do evento inserido
        }
        return $dados;  // Retorna o objeto evento (com o id atualizado, se necessário)
    }

    function publicar($id) {  // Método para publicar um evento (alterar status para 1)
        $sql = "update evento set status=0 where status=1";  // Despublica todos os eventos
        $resultado = $this->db->Execute($sql);
        $sql = "update evento set status=1 where id=$id";  // Publica o evento com o ID passado
        $resultado = $this->db->Execute($sql);
        return $resultado;  // Retorna o resultado da execução do SQL
    }

    function despublicar($id) {  // Método para despublicar um evento (alterar status para 0)
        $sql = "update evento set status=0 where id=$id";  // Despublica o evento com o ID passado
        $resultado = $this->db->Execute($sql);
        return $resultado;  // Retorna o resultado da execução do SQL
    }

    function excluir($id) {  // Método para excluir um evento
        $sql = "delete from evento where id=" . $id;  // SQL para excluir o evento
        $resultado = $this->db->Execute($sql);
        return $resultado;  // Retorna o resultado da execução do SQL
    }

    function salvarInscricao($id_evento, $id_usuario) {  // Método para salvar uma inscrição de um usuário em um evento
        $sql = "insert into inscricao (registro, id_evento, id_usuario) values (now()," . $id_evento. "," . $id_usuario . ")";
        $resultado = $this->db->Execute($sql);  // Executa o SQL para salvar a inscrição
        return $resultado;  // Retorna o resultado da execução do SQL
    }

    function cancelarInscricao($id_evento, $id_usuario) {  // Método para cancelar a inscrição de um usuário em um evento
        $sql = "delete from inscricao where id_evento=" . $id_evento. " and id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql);  // Executa o SQL para excluir a inscrição
        return $resultado;  // Retorna o resultado da execução do SQL
    }

    function jaInscreveu($id_evento, $id_usuario) {  // Método para verificar se o usuário já está inscrito no evento
        $sql = "select count(*) as total from inscricao where id_evento=$id_evento AND id_usuario=$id_usuario";
        $resultado = $this->db->Execute($sql);  // Executa o SQL
        $total = 0;
        if ($registro = $resultado->fetchRow()) {
            $total   = $registro["total"];  // Conta o número de inscrições
        }
        return $total > 0;  // Retorna true se o usuário já estiver inscrito, senão false
    }

    function getTotalInscritos($id_evento) {  // Método para contar o total de inscritos em um evento
        $sql = "select count(*) as total from inscricao where id_evento=$id_evento";
        $resultado = $this->db->Execute($sql);  // Executa o SQL
        $total = 0;
        if ($registro = $resultado->fetchRow()) {
            $total = $registro["total"];  // Conta o número total de inscritos
        }
        return $total;  // Retorna o total de inscritos
    }

    public static function delPasta($dir) {  // Função estática para excluir uma pasta e seu conteúdo
        if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.','..'));  // Obtém os arquivos dentro da pasta
            foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delPasta("$dir/$file") : unlink("$dir/$file");  // Exclui recursivamente arquivos e subpastas
            }
            return rmdir($dir);  // Exclui a pasta vazia
        }
        return false;  // Retorna false se não for uma pasta
    }

    public static function addPasta($dir) {  // Função estática para criar uma nova pasta
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);  // Cria a pasta com permissão total
            return true;  // Retorna true se a pasta foi criada
        }
        return false;  // Retorna false se a pasta já existir
    }
}
