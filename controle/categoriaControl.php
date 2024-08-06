<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/oficina7periodo2024/modelo/vo/Categoria.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/oficina7periodo2024/modelo/dao/CategoriaDAO.php";

if (isset($_GET['idDel'])) {
    CategoriaDAO::getInstance()->delete($_GET['idDel']);
    echo "<script>
        alert('Categoria removida com sucesso!');
        window.location='../CategoriaList.php';
    </script>";
} elseif (isset($_POST)) {
    $categoriaQueEuQueroSalvar = new Categoria();
    $categoriaQueEuQueroSalvar->setNome($_POST['nome']);

    if ($_POST['id'] == 0) {
        CategoriaDAO::getInstance()->insert($categoriaQueEuQueroSalvar);
    } else {
        $categoriaQueEuQueroSalvar->setId($_POST['id']);
        CategoriaDAO::getInstance()->update($categoriaQueEuQueroSalvar);
    }
    echo "<script>
        alert('Categoria salva com sucesso!');
        window.location='../CategoriaAddEdit.php';
    </script>";
}
?>
