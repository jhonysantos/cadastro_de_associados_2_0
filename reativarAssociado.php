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

    $ReativarAssociado = "INSERT INTO associados SELECT * FROM associados_excluidos WHERE id =$id";
    $reativarCancelados = $conexao->query($ReativarAssociado);

    $removerAssociado = "DELETE FROM associados_excluidos WHERE id =$id ";
    $reativar_associado = $conexao->query($removerAssociado);

    
    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role= 'alert'> Usuário excluido com sucesso!</div>"];
    
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role= 'alert'> Erro: Nenhum associado encontrado!</div>"];
}

echo json_encode($retorna);
?>