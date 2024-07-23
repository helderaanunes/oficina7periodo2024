<?php
if (isset ($_POST['email']) && isset($_POST['senha'])){
    $sql ="where email =:email  and senha =:senha";
    $arrayDeParametros = array(":email",":senha");
    $arrayDeValores = array ($_POST['email'],$_POST['senha']);
    
    require_once $_SERVER['DOCUMENT_ROOT'] .
        '/oficina7periodo2024/modelo/dao/UsuarioDAO.php';
    
    $listaUsuario= UsuarioDAO::getInstance()->
        listWhere($sql,$arrayDeParametros,$arrayDeValores);
    // conseguiu encontrar usuario 
    if (count ($listaUsuario)>0){
        session_start();
        $_SESSION['idUsuarioLogado']=$listaUsuario[0]->getId();
        header ("Location: ./UsuarioList.php");
    }
    else{
        header ("Location: ./login.php?erro=1");
    }
}
