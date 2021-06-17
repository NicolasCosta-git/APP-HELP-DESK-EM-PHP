<?php
require_once 'check_access.php';
require_once '../../controllers/UserController.php';

use user\User as User;

$User = User::getById($_SESSION['userId']);
$User = $User[0];

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
  header('location: home.php');
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
    <a class="navbar-brand" href="home.php">
      <img src="./src/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Help Desk
    </a>
    <ul class="navbar-nav ml-auto">
      <?php if (!isset($_SESSION['admin'])) { ?>
        <li class="nav-item ">
          <a href="edit_profile.php" class="nav-link "> <?= strtoupper($_SESSION['userEmail']) ?> </a>
        </li>
      <?php } ?>
      <li class="nav-item ">
        <a href="logout.php" class="nav-link ">SAIR</a>
      </li>
    </ul>
  </nav>

  <div class="col-8 mx-auto text-left mb-3">
    <div class="errors" style="left: 30px;">

      <?php if (isset($_GET['emailInUse'])) { ?>
        <p class="text-red"> * Este email já está em uso! </p>
      <?php
      } ?>
      <?php if (isset($_GET['wrongPassword'])) { ?>
        <p class="text-red"> * Senha errada </p>
      <?php
      } ?>
      <?php if (isset($_GET['fileTypeNotAllowed'])) { ?>
        <p class="text-red"> * Tipo de arquivo não permitido, tipos permitidos: .jpeg, .jpg e .png <br> </p>
      <?php
      } ?>
      <?php if (isset($_GET['missingParameters'])) { ?>
        <p class="text-red"> * Por favor, preencha os campos de senha </p>
      <?php
      } ?>
      <?php if (isset($_GET['fileTooLarge'])) { ?>
        <p class="text-red"> * As senhas não são iguais </p>
      <?php
      } ?>
      <?php if (isset($_GET['errorUploading'])) { ?>
        <p class="text-red"> * Todos os campos devem ser preenchidos </p>
      <?php
      } ?>

    </div>
  </div>
  <div class="m-auto col-8">
    <form action="updateUser.php" method="POST" class="form" enctype="multipart/form-data">
      <div class="row d-flex mt-sm-3 mt-md-3">
        <div class="card col-md-12 col-sm-12 col-lg-7">
          <div class="card-header">
            <h3>Alterar perfil</h3>
          </div>
          <div class="row card-body">
            <div class="col-md-12 col-sm-12 col-lg-7 pt-4">
              <label for="name" class="mb-0 pb-0">
                <h4>Nome:</h4>
              </label>
              <input type="text" class="form-control" id="name" name="name" value="<?= $User['name'] ?>">
              <label for="name" class=" mt-2 mb-0 pb-0">
                <h4>E-mail:</h4>
              </label>
              <input type="text" class="form-control mb-2" id="email" name="email" value="<?= $User['email'] ?>">
            </div>
            <div class="col-md-12 col-sm-12 col-lg-5 mb-2 mt-sm-3 mt-md-3 text-center">
              <?php
              if ($User['avatar'] != null) { ?>
                <img src="<?= $User['avatar'] ?>" id="user-image" alt="Foto do usuário">
                <h6 id="avatarName"></h6>
              <?php } else { ?>
                <div id="user-avatar"></div>
              <?php } ?>
              <button onclick="document.getElementById('file').click(); return false" class="btn btn-lg mt-2 btn-dark btn-block" style="position: relative; top: 2.3px;">
                Alterar foto
              </button>
              <input type="file" id="file" name="photo" onchange="updateAvatar(this)" class="d-none">
            </div>
          </div>
        </div>
        <div class="card col-md-12 ml-lg-auto ml-md-0 col-lg-4 mt-sm-4 mt-md-4 mt-lg-0">
          <div class="card-header">
            <h3>Alterar senha</h3>
          </div>
          <div class="card-body pt-5">
            <div>
              <label for="password">
                <h4>Senha: </h4>
              </label>
              <input type="password" name="currentPassword" class="form-control mb-4" id="password" placeholder="Digite sua senha atual">
              <input type="password" name="newPassword" class="form-control mt-2" placeholder="Digite sua nova senha">
            </div>
          </div>
        </div>
      </div>
      <div class=" row d-flex  mt-4 ">
        <button type="submit" class="btn btn-info btn-lg col-md-12 col-sm-12 col-lg-7">
          Salvar
        </button>
        <a href="home.php" class="btn btn-dark btn-lg col-md-12 ml-lg-auto ml-md-0 col-lg-4 mt-sm-4 mt-md-4 mt-lg-0">
          Voltar
        </a>
      </div>
    </form>
  </div>

</body>

</html>