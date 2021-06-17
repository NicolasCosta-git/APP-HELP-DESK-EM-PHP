<?php
session_start();

require_once 'ADMseeder.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true && $_SESSION['authenticated'] === true) {
  header('location: home.php');
} else if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
  header('location: home.php');
}
?>

<html>

<head>
  <meta charset="utf-8" />
  <title>Help Desk</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    .card-login {
      padding: 30px 0 0 0;
      width: 350px;
      margin: 0 auto;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="index.php">
      <img src="./src/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Help Desk
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item ">
        <a href="register.php" class="nav-link ">REGISTRE-SE</a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">
      <div class="card-login">
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form action="authenticate.php" method="POST">

              <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="E-mail">
              </div>
              <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Senha">

                <?php if (isset($_GET['login']) && $_GET['login'] == 'error') { ?>

                  <div class="text-danger">
                    usuario e/ou senha inválido(s)
                  </div>

                <?php } else if (isset($_GET['authentication']) && $_GET['authentication'] == 'error') { ?>

                  <div class="text-danger">
                    Efetue o login para acessar páginas protegidas.
                  </div>

                <?php }; ?>

              </div>
              <button class="btn btn-lg btn-info btn-block" type="submit">Entrar</button>
              <div class="pt-3 text-center">
                <span>Ainda não tem uma conta ? <a href="register.php">crie uma!</a></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</body>

</html>