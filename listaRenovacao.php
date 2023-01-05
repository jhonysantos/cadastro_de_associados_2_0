<?php
session_start();
include_once('config.php');

//print_r($_SESSION);
if ((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
} else {
    $logado = $_SESSION['usuario'];
}
$renovarAssociado = "SELECT id,nome,cpf,data_vencimento FROM associados";
$resultRenovacao = $conexao->query($renovarAssociado);
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
            <legend class="cabecalho"><b> Planos vencendo</b></legend>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">MATRICULA</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Vencimento</th>
                        <th scope="col">Renovação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user_data = mysqli_fetch_assoc($resultRenovacao)) {
                        $dataAtual = date('Y-m-d');
                        $dataVenc = $user_data['data_vencimento'];
                        $diferenca = strtotime($dataVenc) - strtotime($dataAtual);
                        $prazo = floor($diferenca / (60 * 60 * 24));
                        if (($prazo >= 0) and ($prazo <= 10)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $user_data['id'] . "</th>";
                            echo "<td>" . $user_data['nome'] . "</td>";
                            echo "<td>" . $user_data['cpf'] . "</td>";
                            echo "<td>" . $user_data['data_vencimento'] . "</td>";
                            echo "<td>
                                    <button id='$user_data[id]' class='btn btn-warning btn-sm'  onclick='renovarAssociado($user_data[id])'>Renovar</button>
                                </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </fieldset>
    </div>
    <!-- Modal -->
    <div type="hidden" class="modal fade" id="renovar-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="modal-title" id="modalLabel">Escolha o plano de renovação do(a) associado(a)?</b>

                </div>
                <div class="modal-body">
                    <form class="row g-3" action="saveRenovacao.php" method="POST">
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
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="data_vencimento" id="data_vencimento">
                
                <div class="btn-block d-flex justify-content-evenly">
                    <input type="submit" name="update" id="update" class="btn  btn-primary btn-block " value="Renovar">
                    <input type="submit" class="btn  btn-secondary btn-block" data-bs-dismiss="modal" value="Não">
                </div>
                </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
<script>
    var search = document.getElementById('pesquisar');
    search.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            searchData();
        }
    });
    function searchData() {
        window.location = 'associados.php?search=' + search.value;
    }
</script>

</html>