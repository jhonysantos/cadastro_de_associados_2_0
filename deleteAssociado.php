<?php

session_start();
include_once('config.php');
//print_r($_SESSION);
if ((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}

$logado = $_SESSION['usuario'];

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);


if (!empty($id)) {

    $apagarAssociado = "DELETE FROM associados WHERE id=: id ";
    $result_del_associado = $conexao->query($apagarAssociado);

   $row_del_associado =  mysqli_fetch_assoc($result_del_associado);

    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role= 'alert'> Usuário excluido com sucesso!</div>"];
    header('Location: home.php');
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role= 'alert'> Erro: Nenhum associado encontrado!</div>"];
}

echo json_encode($retorna);