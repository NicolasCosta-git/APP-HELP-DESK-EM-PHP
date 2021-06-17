<?php
require_once 'check_access.php';
require_once '../../controllers/CallController.php';
if (!isset($_SESSION['admin'])) {
  header('location: home.php');
}

use call\Call as Call;

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
  $calls = Call::getAll();
}

function getStatus($status)
{
  switch ($status) {
    case 0:
      return 'Em andamento';
    case 1:
      return 'Concluído em: ';
  }
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
      <li class="nav-item ">
        <a href="logout.php" class="nav-link ">SAIR</a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">

      <div class="card-view-calls">
        <div class="card">
          <div class="card-header">
            <h3>Lista de chamados</h3>
          </div>

          <div class="card-body">

            <?php
            if ($calls != null) {
              foreach ($calls as $call) { ?>

                <div class="card mb-4 bg-light">
                  <div class="card-body">
                    <div class="text-center">
                      <h6 class="text-muted"> Status: <?= getStatus($call['status']) . $call['closedAt'] ?> </h6>
                    </div>
                    <h4 class="card-title pl-2"><?= $call['title'] ?></h4>
                    <hr>
                    <div class="d-flex">
                      <h6 class="card-subtitle mb-2 text-muted text-left col-md-6"><?= $call['name'] . ' - aberto em: ' . $call['createdAt'] . '.' ?></h6>
                      <h6 class="card-subtitle mb-2 text-muted text-right col-md-6"><?= 'Tipo: ' . $call['type'] ?></h6>
                    </div>
                    <span class="card-text pl-2 mt-2" style="font-size: 1.08em; white-space: pre;"><?= $call['description'] ?></span>
                  </div>

                  <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true && $call['status'] === 0) { ?>

                    <div class="d-flex justify-content-around">
                      <div class="col-md-4">
                        <form action="updateStatus.php" method="POST">
                          <button type="submit" class="btn btn-lg btn-info text-center text-white" style="width: 96%;">Concluir chamado</button>
                          <input type="hidden" class="d-none" name="callId" value=<?= $call['id'] ?>>
                        </form>
                      </div>
                      <div class="col-md-4">
                        <form action="messages.php?call=<?= $call['id'] ?>" method="POST">
                          <button type="submit" class="btn btn-lg btn-secondary text-center text-white" style="width: 96%;">Mensagens</button>
                          <input type="hidden" class="d-none" name="callId" value=<?= $call['id'] ?>>
                        </form>
                      </div>
                      <div class="col-md-4">
                        <form action="deleteCall.php" method="POST">
                          <input type="hidden" class="d-none" name="callId" value="<?= $call['id'] ?>">
                          <button type="submit" class="btn btn-lg btn-warning text-center  " style="width: 96%;">Excluir chamado</button>
                        </form>
                      </div>
                    </div>

                  <?php } else { ?>

                    <div class="d-flex justify-content-around">
                      <div class="col-md-6">
                        <form action="messages.php?call=<?= $call['id'] ?>" method="POST">
                          <button type="submit" class="btn btn-lg btn-secondary text-center text-white" style="width: 96%;">Mensagens</button>
                          <input type="hidden" class="d-none" name="callId" value=<?= $call['id'] ?>>
                        </form>
                      </div>
                      <div class="col-md-6">
                        <form action="deleteCall.php" method="POST">
                          <input type="hidden" class="d-none" name="callId" value="<?= $call['id'] ?>">
                          <button type="submit" class="btn btn-lg btn-warning text-center  " style="width: 96%;">Excluir chamado</button>
                        </form>
                      </div>
                    </div>

                  <?php } ?>

                </div>

              <?php }
            } else { ?>

              <div class="text-center mt-3">
                <h3>Não existem chamados...</h3>
              </div>

            <?php } ?>

            <div class="row mt-4">
              <div class="col-12">
                <a href="home.php" class="btn btn-lg btn-dark btn-block" type="submit">Voltar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>