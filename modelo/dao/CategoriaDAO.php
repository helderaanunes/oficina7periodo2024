<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/oficina7periodo2024/modelo/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/oficina7periodo2024/modelo/vo/Categoria.php';

class CategoriaDAO {

    public static $instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new CategoriaDAO();

        return self::$instance;
    }

    public function insert(Categoria $categoria) {
        try {
            $sql = "INSERT INTO categoria (nome) VALUES (:nome)";
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $categoria->getNome());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar" . $e->getMessage();
        }
    }

    public function update(Categoria $categoria) {
        try {
            $sql = "UPDATE categoria SET nome=:nome WHERE id=:id";
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $categoria->getNome());
            $p_sql->bindValue(":id", $categoria->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM categoria WHERE id = :id";
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de deletar --" . $e->getMessage();
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT * FROM categoria WHERE id = :id";
            $p_sql = BDPDO::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->converterLinhaDaBaseDeDadosParaObjeto($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }

    private function converterLinhaDaBaseDeDadosParaObjeto($row) {
        $obj = new Categoria();
        $obj->setId($row['id']);
        $obj->setNome($row['nome']);
        return $obj;
    }

    public function listAll() {
        try {
            $sql = "SELECT * FROM categoria";
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
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }

    public function listWhere($restanteDoSQL, $arrayDeParametros, $arrayDeValores) {
        try {
            $sql = "SELECT * FROM categoria " . $restanteDoSQL;
            $p_sql = BDPDO::getInstance()->prepare($sql);
            for ($i = 0; $i < sizeof($arrayDeParametros); $i++) {
                $p_sql->bindValue($arrayDeParametros[$i], $arrayDeValores[$i]);
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
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.".$e->getMessage();
        }
    }

}

?>
