<?php
require_once 'check_access.php';
require_once '../../controllers/UserController.php';
if (!isset($_SESSION['admin'])) {
  header('location: home.php');
}

use user\User as User;

$Users = User::getAll();

?>

<html>

<head>
  <meta charset="utf-8" />
  <title> Help Desk </title>

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
      <li class="nav-item ">
        <a href="logout.php" class="nav-link ">SAIR</a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">

      <?php if ($Users != null) {
        foreach ($Users as $user) { ?>

          <div class="col-md-5 m-auto">
            <div class="user-card my-5 col pt-4 pb-4">
              <div class="d-flex justify-content-center">
                <?php
                if ($user['avatar'] != null) { ?>
                  <img src="<?= $user['avatar'] ?>" id="user-image" alt="Foto do usuário">
                <?php } else { ?>
                  <div id="user-avatar"></div>
                <?php } ?>
                <input type="hidden" class="d-none" id="avatar" value="">
              </div>
              <div class="text-center pt-4">
                <p class="user-data h4"><span class="h5">Nome:</span> <?= $user['name'] ?></p>
                <p class="user-data h5"><span class="h5">E-mail:</span> <?= $user['email'] ?></p>
              </div>
            </div>
          </div>

        <?php }
      } else { ?>

        <div class="mt-5 mb-5">
          <p class="h1 text-center">
            Não existem usuários cadastrados...
          </p>
        </div>

      <?php } ?>

    </div>

    <div class="text-center mb-4 ">
      <a href="home.php" class="btn btn-lg btn-dark text-white col-md-9">Voltar</a>
    </div>
  </div>
</body>
<script>

</script>

</html>