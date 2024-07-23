<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/oficina7periodo2024/modelo/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/oficina7periodo2024/modelo/vo/Usuario.php';

class UsuarioDAO {

    public static $instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new UsuarioDAO();

        return self::$instance;
    }

    public function insert(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario (nome,login,email,senha,foto)"
                    . "VALUES "
                    . "(:nome,:login,:email,:senha,:foto)";
            //perceba que na linha abaixo vai precisar de um import
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":login", $usuario->getLogin());
            $p_sql->bindValue(":email", $usuario->getEmail());
            $p_sql->bindValue(":senha", $usuario->getSenha());
            $p_sql->bindValue(":foto", $usuario->getFoto());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar" . $e->getMessage();
        }
    }

    public function update($usuario) {
        try {
            $sql = "UPDATE usuario SET nome=:nome, cpf =:cpf,logradouro=:logradouro,numero=:numero,"
                    . "bairro=:bairro, cidade=:cidade,uf =:uf,telefone=:telefone, email=:email, senha=:senha "
                    . "where id=:id";
            //perceba que na linha abaixo vai precisar de um import
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":cpf", $usuario->getCpf());
            $p_sql->bindValue(":logradouro", $usuario->getLogradouro());
            $p_sql->bindValue(":numero", $usuario->getNumero());
            $p_sql->bindValue(":bairro", $usuario->getBairro());
            $p_sql->bindValue(":cidade", $usuario->getCidade());
            $p_sql->bindValue(":uf", $usuario->getUf());
            $p_sql->bindValue(":telefone", $usuario->getTelefone());
            $p_sql->bindValue(":email", $usuario->getEmail());
            //iremos critografar a senha para md5, asism o usuário terá mais segurança, já que frequentemente usamos a mesma senha           //  para diversas aplicações.
            $p_sql->bindValue(":senha", md5($usuario->getSenha()));
            $p_sql->bindValue(":id", $usuario->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $sql = "delete from usuario where id = :id";
            //perceba que na linha abaixo vai precisar de um import
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de deletar --" . $e->getMessage();
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->converterLinhaDaBaseDeDadosParaObjeto($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
        }
    }

    private function converterLinhaDaBaseDeDadosParaObjeto($row) {
        $obj = new Usuario();
        $obj->setId($row['id']);
        $obj->setNome($row['nome']);
        $obj->setLogin($row['login']);
        $obj->setEmail($row['email']);
        $obj->setSenha($row['senha']);
        $obj->setFoto($row['foto']);
        return $obj;
    }

    public function listAll() {
        try {
            $sql = "SELECT * FROM usuario ";
            $p_sql = BDPDO::getInstance()->prepare($sql);

            $p_sql->execute();

            $lista = array();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            while ($row) {
                $lista[] = $this->converterLinhaDaBaseDeDadosParaObjeto($row);
                $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
        }
    }

    public function listWhere($restanteDoSQL, $arrayDeParametros, $arrayDeValores) {
        try {
            $sql = "SELECT * FROM usuario " . $restanteDoSQL;
            $p_sql = BDPDO::getInstance()->prepare($sql);
            for ($i = 0; $i < sizeof($arrayDeParametros); $i++) {
                $p_sql->bindValue($arrayDeParametros[$i], $arrayDeValores [$i]);
            }
            $p_sql->execute();
            $lista = array();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            while ($row) {
                $lista[] = $this->converterLinhaDaBaseDeDadosParaObjeto($row);
                $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.".$e->getMessage();
        }
    }

}

?>