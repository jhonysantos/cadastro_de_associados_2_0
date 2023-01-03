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

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
echo "<script>console.log('Console: " . $id . "' );</script>";
   /*  $buscarAssociado = "SELECT * FROM associados WHERE id =$id ";
    $result_associado = $conexao->query($buscarAssociado);

    if (isset($_POST['renovar'])) {
        switch ($_POST['plano']) {
            case "mensal":
                $data_vencimento = $result_associado['data_vencimento'];
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
        $result = mysqli_query($conexao, "UPDATE associados SET (data_vencimento) 
    VALUES ('$dataVencimento') WHERE id=$_post[id]");
        header('Location: home.php');
    } */
}
?>