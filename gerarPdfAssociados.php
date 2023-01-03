<?php

session_start();
include_once('config.php');
//print_r($_SESSION);
if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)){

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}

$logado = $_SESSION['usuario'];


$sql = "SELECT * FROM associados ORDER BY id DESC";
$result = $conexao->query($sql);

while($user_data = mysqli_fetch_assoc($result)){
    $html .= "<strong>Matricula: </strong>";
    $html .= $user_data['id']."<br/>";

    $html .= "<strong>Nome: </strong>";
    $html .= $user_data['nome']."<br/>";

    $html .= "<strong>CPF: </strong>";
    $html .= $user_data['cpf']."<br/>";

    $html .= "<strong>Estado Civil: </strong>";
    $html .= $user_data['estado_civil']."<br/>";

    $html .= "<strong>Nacionalidade: </strong>";
    $html .= $user_data['nacionalidade']."<br/>";

    $html .= "<strong>Profissão: </strong>";
    $html .= $user_data['profissao']."<br/>";

    $html .= "<strong>E-mail: </strong>";
    $html .= $user_data['email']."<br/>";

    $html .= "<strong>Telefone: </strong>";
    $html .= $user_data['telefone']."<br/>";

    $html .= "<strong>Gênero: </strong>";
    $html .= $user_data['genero']."<br/>";

    $html .= "<strong>Data de Nascimento: </strong>";
    $html .= $user_data['data_nascimento']."<br/>";

    $html .= "<strong>Cidade: </strong>";
    $html .= $user_data['cidade']."<br/>";

    $html .= "<strong>Estado: </strong>";
    $html .= $user_data['estado']."<br/>";

    $html .= "<strong>Endereço: </strong>";
    $html .= $user_data['endereco']."<br/>";

    $html .= "<strong>Plano: </strong>";
    $html .= $user_data['plano']."<br/>";

    $html .= "<strong>Data de Aquisição: </strong>";
    $html .= $user_data['data_aquisicao']."<hr/>";


}

require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf();

$mpdf->WriteHTML('<h1 style="text-align: center;"> Relação de Associados </h1>'. $html .' ');
$mpdf->Output();

?>