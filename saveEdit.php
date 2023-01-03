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
      $nome = $_POST['nome'];
      $estadoCivil = $_POST['estado_civil'];
      $nacionalidade = $_POST['nacionalidade'];
      $profissao = $_POST['profissao'];
      $cpf = $_POST['cpf'];
      $email = $_POST['email'];
      $telefone = $_POST['telefone'];
      $genero = $_POST['genero'];
      $dataNascimento = $_POST['data_nascimento'];
      $cidade = $_POST['cidade'];
      $estado = $_POST['estado'];
      $endereco = $_POST['endereco'];
      $planoAssociado = $_POST['plano'];
      $dataAquisicao = $_POST['data_aquisicao'];

      $sqlUPdate = "UPDATE associados SET nome='$nome',estado_civil='$estadoCivil',nacionalidade='$nacionalidade',
      profissao='$profissao',cpf='$cpf',email='$email',telefone='$telefone',genero='$genero',data_nascimento='$dataNascimento',
      cidade='$cidade',estado='$estado',endereco='$endereco',plano='$planoAssociado',data_aquisicao='$dataAquisicao' 
      WHERE id='$id'";

      $result = $conexao->query($sqlUPdate);
    }
    header('Location: home.php');
?>