<?php
session_start();

require_once 'ADMseeder.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true && $_SESSION['authenticated'] === true) {
  header('location: home.php');
} else if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
  header('location: home.php');
}

$name = null;
$email = null;
if (isset($_SESSION['temp'][0])) {
  $name = $_SESSION['temp'][0];
}
if (isset($_SESSION['temp'][1])) {
  $email = $_SESSION['temp'][1];
}

function destroySession()
{
  session_destroy();
}

?>

<html>

<head>

  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <script src="./src/js/index.js"></script>
  <link rel="stylesheet" href="./src/css/style.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="index.php">
      <img src="./src/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Help Desk
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item ">
        <a href="index.php" class="nav-link ">ENTRAR</a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div>
      <p class="text-center pb-0 mb-0 mt-4 h6">Campos marcados com * são obrigatórios</p>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="card-register">
        <div class="card">
          <div class="card-header">
            Registre-se
          </div>
          <div class="card-body">
            <form action="registerUser.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="text-center mb-3">
                  <div class="m-auto" id='avatar'></div>
                  <p class="mt-2 mb-1 text-bold" id="avatarName"></p>
                  <button class="btn btn-md btn-dark mt-2" onclick=" document.getElementById('photo').click(); return false; ">Selecione sua foto</button>
                  <input type="file" name="photo" onchange="updateAvatar2(this)" class="d-none" id="photo" accept="image/*">
                  <hr>
                </div>
                <label for="name">
                  <h6>* Nome: </h6>
                </label>
                <input name="name" id="name" type="text" class="form-control" value="<?= $name ?>" placeholder="Digite seu nome">
              </div>
              <div class="form-group">
                <label for="name">
                  <h6>* E-mail: </h6>
                </label>
                <input name="email" id="email" type="email" class="form-control" value="<?= $email ?>" placeholder="Digite seu e-mail">
              </div>
              <div class="form-group">
                <label for="password">
                  <h6>* Senha: </h6>
                </label>
                <input name="password" type="password" id="password" class="form-control" placeholder="Digite sua senha">
                <input name="checkPassword" type="password" class="form-control mt-2" placeholder="Repita sua senha">
              </div>
              <button class="btn btn-lg btn-info btn-block" type="submit">Registrar</button>
              <p class="text-center pt-3">Já tem uma conta ? <a href="index.php" class="">entrar </a></p>
            </form>
          </div>
        </div>
      </div>
      <div class="errors" style="left: 30px;">

        <?php if (isset($_GET['fileTooLarge'])) { ?>
          <p class="text-red" style="position: absolute;"> * A foto enviada é muito grande! </p>
        <?php destroySession();
        } ?>
        <?php if (isset($_GET['errorUploading'])) { ?>
          <p class="text-red" style="position: absolute;"> * Houve um erro ao enviar o arquivo </p>
        <?php destroySession();
        } ?>
        <?php if (isset($_GET['fileTypeNotAllowed'])) { ?>
          <p class="text-red" style="position: absolute;"> * Tipo de arquivo não permitido, tipos permitidos: .jpeg, .jpg e .png <br> </p>
        <?php destroySession();
        } ?>
        <?php if (isset($_GET['userAlreadyExists'])) { ?>
          <p class="text-red" style="position: absolute;"> * Já existe um usuário com este email </p>
        <?php destroySession();
        } ?>
        <?php if (isset($_GET['passwordsNotEqual'])) { ?>
          <p class="text-red" style="position: absolute;"> * As senhas não são iguais </p>
        <?php destroySession();
        } ?>
        <?php if (isset($_GET['inputsCannotBeNull'])) { ?>
          <p class="text-red" style="position: absolute;"> * Todos os campos devem ser preenchidos </p>
        <?php destroySession();
        } ?>
        
      </div>
    </div>
  </div>
</body>

</html>