<?php
require_once  $_SERVER['DOCUMENT_ROOT'] 
        ."/oficina7periodo2024/modelo/vo/Usuario.php";
require_once $_SERVER['DOCUMENT_ROOT'] 
        ."/oficina7periodo2024/modelo/dao/UsuarioDAO.php";

$usuarioQueEuQueroSalvar = new Usuario(); 
$usuarioQueEuQueroSalvar->setNome($_POST['nome']);
$usuarioQueEuQueroSalvar->setEmail($_POST['email']);
$usuarioQueEuQueroSalvar->setLogin($_POST['login']);
$usuarioQueEuQueroSalvar->setSenha($_POST['senha']);

print_r($usuarioQueEuQueroSalvar);
UsuarioDAO::getInstance()->insert($usuarioQueEuQueroSalvar);
echo " <script> 
    alert ('Usuario salvo com sucesso!');
    window.location='../UsuarioAddEdit.php';
</script>";