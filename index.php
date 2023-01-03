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

<body class="body">
    <div class="area">
        <img class="logo" src="Logo.png" />

        <h2 class="h2">Faça o Login</h2>
        <form action="loginUser.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuário" class="form-control" />
            <br />
            <input type="password" name="senha" placeholder="Senha" class="form-control" />
            <label class="remember">
                <input type="checkbox" name="remember" value="1" />
                Lembrar minha senha
            </label><br/>
            <input type="submit" name="submit" value="Entrar" class="btn btn-lg btn-primary btn-block" />
        </form>
        <p class="gray padding">@ Desenvolvido por Jhony Santos</p>
    </div>
    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/jquery-3.5.1.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>