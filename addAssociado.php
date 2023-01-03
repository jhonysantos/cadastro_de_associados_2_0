<?php
session_start();
//print_r($_SESSION);
if ((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
} else {
    $logado = $_SESSION['usuario'];
}

if (isset($_POST['submit'])) {

    include_once('config.php');

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

    switch ($_POST['plano']) {
        case "mensal":
            $data_aquisicao = $_POST['data_aquisicao'];
            $date_aquisicao = strtotime($data_aquisicao);
            $data_vencimento = strtotime('+30 days', $date_aquisicao);
            $dataVencimento = date('Y-m-d', $data_vencimento);
        break;
        case "anual":
            $data_aquisicao = $_POST['data_aquisicao'];
            $date_aquisicao = strtotime($data_aquisicao);
            $data_vencimento = strtotime('+365 days', $date_aquisicao);
            $dataVencimento = date('Y-m-d', $data_vencimento);
        break;
    }

    $result = mysqli_query($conexao, "INSERT INTO associados(nome,estado_civil,nacionalidade,profissao,cpf,email,telefone,
      genero,data_nascimento,cidade,estado,endereco,plano,data_aquisicao,data_vencimento) 
      VALUES ('$nome','$estadoCivil','$nacionalidade','$profissao','$cpf','$email','$telefone',
      '$genero','$dataNascimento','$cidade','$estado','$endereco','$planoAssociado','$dataAquisicao','$dataVencimento')");

    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Associação</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="sb-nav-fixed">

    <div class="container ">

        <fieldset class="bodyContainer">
            <legend class="cabecalho"><b>Cadastro de Associados</b></legend>
            <form class="row g-3" action="addAssociado.php" method="POST">
                <div class="col-12 input">
                    <label for="nome" class="form-label fontbold">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" required>
                </div>
                <fieldset class="radius">
                    <legend class="col-form-label col-12 fontbold">Estado Civil</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado_civil" id="solteiro"
                                value="solteiro">
                            <label class="form-check-label" for="solteiro">
                                Solteiro
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado_civil" id="casado" value="casado">
                            <label class="form-check-label" for="casado">
                                Casado
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado_civil" id="divorciado"
                                value="divorciado">
                            <label class="form-check-label" for="divorciado">
                                Divorciado
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado_civil" id="viuvo" value="viuvo">
                            <label class="form-check-label" for="viuvo">
                                Viúvo
                            </label>
                        </div>
                    </div>
                </fieldset>
                <br /><br /><br />
                <div class="col-12 input">
                    <label for="nacionalidade" class="form-label fontbold">Nacionalidade</label>
                    <input type="text" name="nacionalidade" id="nacionalidade" class="form-control"
                        placeholder="Nacionalidade" required>
                </div>
                <div class="col-12 input">
                    <label for="profissao" class="form-label fontbold">Profissão</label>
                    <input type="text" name="profissao" id="profissao" class="form-control" placeholder="Profissão"
                        required>
                </div>
                <div class="col-12 input">
                    <label for="cpf" class="form-label fontbold">CPF</label>
                    <input type="number" name="cpf" id="cpf" class="form-control" placeholder="CPF" required>
                </div>
                <div class="col-12 input">
                    <label for="email" class="form-label fontbold">E-mail</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="col-12 input">
                    <label for="telefone" class="form-label fontbold">Telefone</label>
                    <input type="tel" name="telefone" id="telefone" class="form-control" placeholder="Telefone"
                        required>
                </div>
                <fieldset class="radius">
                    <legend class="col-form-label col-12 fontbold">Sexo</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" id="feminino" value="feminino">
                            <label class="form-check-label" for="feminino">
                                Feminino
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" id="masculino" value="masculino">
                            <label class="form-check-label" for="masculino">
                                Masculino
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" id="outro" value="outro">
                            <label class="form-check-label" for="outro">
                                Outro
                            </label>
                        </div>
                    </div>
                </fieldset>
                <div class="w-100"></div>
                <div class="col-3 input">
                    <label for="data_nascimento" class="form-label fontbold">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
                </div>
                <div class="col-12 input">
                    <label for="cidade" class="form-label fontbold">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade" required>
                </div>
                <div class="col-12 input">
                    <label for="estado" class="form-label fontbold">Estado</label>
                    <input type="text" name="estado" id="estado" class="form-control" placeholder="Estado" required>
                </div>
                <div class="col-12 input">
                    <label for="endereco" class="form-label fontbold">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereço"
                        required>
                </div>
                <fieldset class="radius">
                    <legend class="col-form-label col-12 fontbold">Plano de Associado</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plano" id="mensal" value="mensal">
                            <label class="form-check-label" for="mensal">
                                Mensal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plano" id="anual" value="anual">
                            <label class="form-check-label" for="anual">
                                Anual
                            </label>
                        </div>
                    </div>
                </fieldset>
                <div class="w-100"></div>
                <div class="col-3 input">
                    <label for="data_aquisicao" class="form-label fontbold">Data de Aquisição</label>
                    <input type="date" name="data_aquisicao" id="data_aquisicao" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block " value="Cadastrar">
                </div>
            </form>
    </div>
    </fieldset>




    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/jquery-3.5.1.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>