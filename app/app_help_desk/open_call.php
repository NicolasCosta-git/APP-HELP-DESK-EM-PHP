<?php
require_once 'check_access.php';
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
  header('location: home.php');
}
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

  <div class="container">
    <div class="errors mb-2">

      <?php if (isset($_GET['missingParameters'])) { ?>
        <p class="text-red"> * Por favor, preencha todos os campos </p>
      <?php
      } ?>
      
    </div>

    <span class="text-center h6"> Obs: se não selecionar uma categoria, vai ser tratado como não especificado.</span>
    <div class="row">

      <div class="card-open-call">
        <div class="card">
          <div class="card-header">
            Abertura de chamado
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">

                <form method="post" action="newCall.php">
                  <div class="form-group">
                    <label>Título</label>
                    <input name="title" type="text" class="form-control" placeholder="Título">
                  </div>

                  <div class="form-group">
                    <label>Categoria</label>
                    <select name="category" class="form-control">
                      <option value="não especificado">Selecione uma categoria</option>
                      <option>Impressora</option>
                      <option>Hardware</option>
                      <option>Software</option>
                      <option>Rede</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                  </div>

                  <div class="row mt-5">
                    <div class="col-6">
                      <a href="home.php" class="btn btn-lg btn-dark btn-block" type="submit"> Voltar </a>
                    </div>

                    <div class="col-6">
                      <button class="btn btn-lg btn-info btn-block" type="submit"> Abrir </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>