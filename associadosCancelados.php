<?php
session_start();
include_once('config.php');
if ((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['usuario'];

$sqlCancelados = "SELECT * FROM associados_excluidos";
$resultCancelados = $conexao->query($sqlCancelados);

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
    <div class="mt-5 pt-3">
        <div class="container-fluid">
            <div id="areatrabalho">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span><i class="bi bi-table me-2"></i></span> Associados Cancelados
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
                                            while ($user_associado = mysqli_fetch_assoc($resultCancelados)) {
                                                echo "<tr>";
                                                echo "<td>" . $user_associado['id'] . "</td>";
                                                echo "<td>" . $user_associado['cpf'] . "</td>";
                                                echo "<td>" . $user_associado['nome'] . "</td>";
                                                echo "<td>
                                                    
                                                    <button id='$user_associado[id]' class='btn btn-success btn-sm'  onclick='reativarAssociado($user_associado[id])'>Reativar</button> 
                                                    
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



    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/jquery-3.6.2.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>