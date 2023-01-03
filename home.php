<?php
session_start();
include_once('config.php');
if ((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['usuario'];

$sqlAssociados = "SELECT * FROM associados";
$resultAssociados = $conexao->query($sqlAssociados);

$dataRequerimento = "SELECT data_vencimento FROM associados ORDER BY id DESC";
$resultData = $conexao->query($dataRequerimento);

$dataRenovacao = "SELECT id,nome,cpf,data_vencimento FROM associados ORDER BY id DESC";
$resultRenov = $conexao->query($dataRenovacao);


$contAnual = "SELECT COUNT(plano) AS qnt_anual FROM associados WHERE plano='anual'";
$resultAnual = $conexao->query($contAnual);
$row_anual = mysqli_fetch_assoc($resultAnual);

$contMensal = "SELECT COUNT(plano) AS qnt_mensal FROM associados WHERE plano='mensal'";
$resultMensal = $conexao->query($contMensal);
$row_mensal = mysqli_fetch_assoc($resultMensal);

$contTotal = "SELECT COUNT(*) AS qnt_total FROM associados";
$resultTotal = $conexao->query($contTotal);
$row_total = mysqli_fetch_assoc($resultTotal);


$contVencimento = 0;
while ($data_req = mysqli_fetch_assoc($resultData)) {
    $dataAtual = date('Y-m-d');
    $dataVenc = $data_req['data_vencimento'];
    $diferenca = strtotime($dataVenc) - strtotime($dataAtual);
    $prazo = floor($diferenca / (60 * 60 * 24));
    if (($prazo >= 0) and ($prazo <= 10)) {
        $contVencimento++;


    }

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

<body>
    <!-- navBar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- offCanvas trigger -->
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
            </button>
            <!-- offCanvas trigger -->
            <a class="navbar-brand fw-bold text-uppercase me-auto" href="">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="usuario d-flex ms-auto">
                    <?php
                    echo "$logado";
                    ?>
                </div>

                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="sair.php">Sair</a></li>
                            <li><a class="dropdown-item" href="update.php">Update</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- navBar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">

        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mt-4 mb-3">CORE</div>
                    </li>
                    <li>
                        <a href="home.php" class="nav-link px-3 active">
                            <span class="me-2">
                                <i class="bi bi-speedometer2"></i>
                            </span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">Interface</div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#gerenciamentocolapse"
                            role="button" aria-expanded="false" aria-controls="gerenciamentocolapse">
                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                            <span>Gerenciamento</span>
                            <span class="right-icon ms-auto">
                                <span><i class="bi bi-chevron-down"></i></span>
                            </span>
                        </a>
                        <div class="collapse multi-collapse" id="gerenciamentocolapse">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a onclick="carregar('addAssociado.php')" class="nav-link px-3" href="#">
                                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                                            <span>Add Associado</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-3" href="gerarPdfAssociados.php" target="_blank">
                                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                                            <span>Imprimir Associados</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>


                </ul>

            </nav>
        </div>
    </div>
    <!-- offcanvas -->

    <main class="mt-2 pt-3">
        <div class="container-fluid">
            <div id="areatrabalho">
                <div class="row">
                    <div class="mt-2 mb-2">
                        <h5>
                            <ol class="breadcrumb ">
                                <li class="breadcrumb-item active">
                                    Associação Progresso dos Pequenos Produtores Rurais do PA Presidente
                                </li>
                            </ol>
                        </h5>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-primary mb-3 h-60">
                                <div class="card-header">
                                    <h6>Associados cadastrados</h6>
                                </div>
                                <div class="card-body">
                                    Existem <?php
                                    echo "<b>" . $row_total['qnt_total'] . "</b>";
                                    ?>
                                    Associados cadastrados

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-warning mb-3 h-60">
                                <div class="card-header">
                                    <h6>Plano Anual</h6>
                                </div>
                                <div class="card-body">
                                    Existem
                                    <?php
                                    echo "<b>" . $row_anual['qnt_anual'] . "</b>";
                                    ?>
                                    Associados com plano anual

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-success mb-3 h-60">
                                <div class="card-header">
                                    <h6>Plano Mensal</h6>
                                </div>
                                <div class="card-body">
                                    Existem <?php
                                    echo "<b>" . $row_mensal['qnt_mensal'] . "</b>";
                                    ?>
                                    Associados com plano mensal

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a class="renovar" data-bs-toggle="modal" href="" data-bs-target="#listaVencimento">
                                <div class="card text-white bg-danger mb-3 h-60">
                                    <div class="card-header">
                                        <h6>Plano vencendo</h6>
                                    </div>
                                    <div class="card-body">
                                        Existem <?php
                                        echo "<b>" . $contVencimento . "</b>";
                                        ?> Associados com plano vencendo

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <span><i class="bi bi-table me-2"></i></span> Associados Ativos
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped data-table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Matricula</th>
                                                    <th>CPF</th>
                                                    <th>Nome</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($user_associado = mysqli_fetch_assoc($resultAssociados)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $user_associado['id'] . "</td>";
                                                    echo "<td>" . $user_associado['cpf'] . "</td>";
                                                    echo "<td>" . $user_associado['nome'] . "</td>";
                                                    echo "<td>
                                                    <button id='$user_associado[id]' class='btn btn-success btn-sm' onclick='visualizarAssociado($user_associado[id])'>Visualizar</button>
                                                    <button id='$user_associado[id]' class='btn btn-primary btn-sm' onclick='editarAssociado($user_associado[id])'>Editar</button>
                                                    <button id='$user_associado[id]' class='btn btn-warning btn-sm'  data-bs-toggle='modal' data-bs-target='#renovarAssociado'>Renovar</button> 
                                                    <button id='$user_associado[id]' class='btn btn-danger btn-sm'  onclick='deleteAssociado($user_associado[id])'>Excluir</button> 
                                                    <a class='btn btn-light btn-sm'  href='gerarPdfAssoc.php?id=$user_associado[id]' target='_blank'>Imprimir</a> 
                                                    

                                                    <!-- Modal Renovar Associado -->
                                                    <div class='modal fade' id='renovarAssociado' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                        <div class='modal-dialog' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header'>
                                                                    <h4 class='modal-title' id='modalLabel'>Excluir Item</h4>
                                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                Escolha a opção de renovação do plano do associado <b>" . $user_associado['nome'] . "</b>:
                                                                <br/>
                                                                
                                                                <form class='row g-3' action='saveRenovacao.php' method='POST'>
                                                                <fieldset>
                                                                    <legend class='col-form-label col-12 fontbold'>Plano de Associado:</legend>
                                                                    <div class='col-sm-10'>
                                                                        <div class='form-check'>
                                                                            <input class='orm-check-input' type='radio' name='plano' id='mensal' value='mensal'>
                                                                            <label class='form-check-label' for='mensal'>
                                                                                Mensal
                                                                            </label>
                                                                        </div>
                                                                        <div class='form-check'>
                                                                            <input class='form-check-input' type='radio' name='plano' id='anual' value='anual'>
                                                                            <label class='form-check-label' for='anual'>
                                                                                Anual
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <input type='submit' name='submit' class='btn btn-primary' value='Renovar'>
                                                                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Não</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- /.modal -->   

                                                    </td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Matricula</th>
                                                    <th>CPF</th>
                                                    <th>Nome</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal Perfil Associado -->
    <div class="modal fade" id="perfilAssociado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 position-absolute  start-50 translate-middle-x " id="exampleModalLabel">
                        <b><span id="nomeAssociado"></span></b>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p><strong>Matricula do Associado</strong></p>
                            <p>
                                <span id="idAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Estado Civil</strong></p>
                            <p>
                                <span id="estadoCivilAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Nacionalidade</strong></p>
                            <p>
                                <span id="nacionalidadeAssociado"></span>
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p><strong>CPF</strong></p>
                            <p>
                                <span id="cpfAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>E-mail</strong></p>
                            <p>
                                <span id="emailAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Profissão</strong></p>
                            <p>
                                <span id="profissaoAssociado"></span>
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p><strong>Sexo</strong></p>
                            <p>
                                <span id="generoAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Data de Nascimento</strong></p>
                            <p>
                                <span id="dataNascimentolidadeAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Telefone</strong></p>
                            <p>
                                <span id="telefoneAssociado"></span>
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p><strong>Estado</strong></p>
                            <p>
                                <span id="estadoAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Endereço</strong></p>
                            <p>
                                <span id="enderecoAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Cidade</strong></p>
                            <p>
                                <span id="cidadeAssociado"></span>
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div class="row justify-content-center text-center">
                        <div class="col-md-6">
                            <p><strong>Data de Aquisição</strong></p>
                            <p>
                                <span id="dataAquisicaoAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Data de Vencimento</strong></p>
                            <p>
                                <span id="datavencimentoAssociado"></span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Plano Atual</strong></p>
                            <p>
                                <span id="planoAssociado"></span>
                            </p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Editar Associado -->
    <div class="modal fade" id="editarAssociados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 position-absolute  start-50 translate-middle-x " id="exampleModalLabel">
                        <b>Editar Associado</b>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" action="saveEdit.php" method="POST">
                        <div class="col-12 input">
                            <label for="nome" class="form-label fontbold">Nome completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo"
                                required>
                        </div>
                        <fieldset class="radius">
                            <legend class="col-form-label col-12 fontbold">Estado Civil</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="solteiro"
                                        value="solteiro" required>
                                    <label class="form-check-label" for="solteiro">
                                        Solteiro
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="casado"
                                        value="casado" required>
                                    <label class="form-check-label" for="casado">
                                        Casado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="divorciado"
                                        value="divorciado" required>
                                    <label class="form-check-label" for="divorciado">
                                        Divorciado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="viuvo"
                                        value="viuvo" required>
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
                            <input type="text" name="profissao" id="profissao" class="form-control"
                                placeholder="Profissão" required>
                        </div>
                        <div class="col-12 input">
                            <label for="cpf" class="form-label fontbold">CPF</label>
                            <input type="number" name="cpf" id="cpf" class="form-control" placeholder="CPF" required>
                        </div>
                        <div class="col-12 input">
                            <label for="email" class="form-label fontbold">E-mail</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="E-mail"
                                required>
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
                                    <input class="form-check-input" type="radio" name="genero" id="feminino"
                                        value="feminino" required>
                                    <label class="form-check-label" for="feminino">
                                        Feminino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="masculino"
                                        value="masculino" required>
                                    <label class="form-check-label" for="masculino">
                                        masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="outro" value="outro"
                                        required>
                                    <label class="form-check-label" for="outro">
                                        Outro
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="w-100"></div>
                        <div class="col-3 input">
                            <label for="data_nascimento" class="form-label fontbold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control"
                                required>
                        </div>
                        <div class="col-12 input">
                            <label for="cidade" class="form-label fontbold">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade"
                                required>
                        </div>
                        <div class="col-12 input">
                            <label for="estado" class="form-label fontbold">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" placeholder="Estado"
                                required>
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
                                    <input class="form-check-input" type="radio" name="plano" id="mensal" value="mensal"
                                        required>
                                    <label class="form-check-label" for="mensal">
                                        Mensal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="plano" id="anual" value="anual"
                                        required>
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
                        <input type="hidden" name="id" id="id">
                        <div class="w-100"></div>
                        <div class="btn-block d-flex justify-content-evenly">
                            <input type="submit" name="update" id="update" class="btn  btn-primary btn-block "
                                value="Atualizar">
                            <input type="submit" class="btn  btn-secondary btn-block" data-bs-dismiss="modal"
                                value="Fechar">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Excluir Associado -->
    <div class="modal fade" id="removerAssociado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Deseja realmente deletar o(a) associado(a) <b><span id="nomeAssociadoDel"></span></b> com mátricula <b><span id="idAssociadoDel"></span></b> ?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="deleteAssociado.php?id=$user_associado[id]">Sim</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Lista de Vencimento-->
    <div class="modal fade" id="listaVencimento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Planos de associados vencendo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Matricula</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Data de Vencimento</th>

                            </tr>
                        </thead>
                        <?php
                        while ($renovacao = mysqli_fetch_assoc($resultRenov)) {
                            $dataAtual = date('Y-m-d');
                            $dataVenc = $renovacao['data_vencimento'];
                            $diferenca = strtotime($dataVenc) - strtotime($dataAtual);
                            $prazo = floor($diferenca / (60 * 60 * 24));
                            if (($prazo >= 0) and ($prazo <= 10)) {
                                echo "<tr>";
                                echo "<td>" . $renovacao['id'] . "</td>";
                                echo "<td>" . $renovacao['cpf'] . "</td>";
                                echo "<td>" . $renovacao['nome'] . "</td>";
                                echo "<td>" . $renovacao['data_vencimento'] . "</td>";
                            }
                        }
                        ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function carregar(pagina) {
            $("#areatrabalho").load(pagina);
        }
    </script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/jquery-3.6.2.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>

    <?php
    if ($contVencimento > 0) { ?>
        <script>
            $(document).ready(function () {
                $('#listaVencimento').modal('show');
            });
        </script>
        <?php
    }
    ?>
</body>

</html>