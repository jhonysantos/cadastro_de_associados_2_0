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


if(isset($_POST['update'])){
    $id = $_POST['id'];
        switch ($_POST['plano']) {
            case "mensal":
                $data_vencimento = $_POST['data_vencimento'];
                $date_vencimento = strtotime($data_vencimento);
                $data_renovacao = strtotime('+29 days', $date_vencimento);
                $dataRenovacao = date('Y-m-d', $data_renovacao);
                break;
            case "anual":
                $data_vencimento = $_POST['data_vencimento'];
                $date_vencimento = strtotime($data_vencimento);
                $data_renovacao = strtotime('+364 days', $date_vencimento);
                $dataRenovacao = date('Y-m-d', $data_renovacao);
                break;
        }
    $sqlRenovar = "UPDATE associados SET data_vencimento='$dataRenovacao' WHERE id='$id'";

        $resultRenova = $conexao->query($sqlRenovar);
        
        header('Location: home.php');
    
}
?>