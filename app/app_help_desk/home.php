<?php
require_once 'check_access.php';
require_once '../../controllers/CallController.php';

use call\Call as Call;

if (isset($_SESSION['userId'])) {
  $calls = Call::getByUserId($_SESSION['userId']);
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
    <?php if (!isset($_SESSION['admin'])) { ?>
      <div class="row mt-5 col-md-9 ml-auto mr-auto mt-5" id="mm-anchors" style="border: 1px solid #afafaf; border-radius: 40px;">
        <a href="open_call.php" class="d-flex col text-left pl-5">
          <img class="my-4 pr-4 border-right" src="./src/img/write.svg" alt="Novo chamado" width="200px">
          <div class="d-flex justify-content-center align-items-center text-center">
            <p class="h2 pl-4">Clique aqui para abrir um chamado</p>
          </div>
        </a>
      </div>
      <hr>

      <?php
      if ($calls == null) {
      ?>
        <div class="text-center mt-5">
          <h3>Abra um chamado e ele aparecerá aqui...</h3>
        </div>



      <?php } else { ?>

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header text-center">
              <h3>Seus chamados</h3>
            </div>

            <?php foreach ($calls as $call) { ?>


              <div class="card-body">
                <div class="card mb-3 bg-light">
                  <div class="card-body">
                    <div class="text-center">
                      <h6 class="text-muted"> Status: <?= getStatus($call['status']) . $call['closedAt'] ?> </h6>
                    </div>
                    <h4 class="card-title pl-2"><?= $call['title'] ?></h4>
                    <hr>
                    <div class="d-flex">
                      <h6 class="card-subtitle mb-2 text-muted text-left col-md-6">
                        <?= 'Aberto em: ' . $call['createdAt'] . '.' ?></h6>
                      <h6 class="card-subtitle mb-2 text-muted text-right col-md-6"><?= 'Tipo: ' . $call['type'] ?></h6>
                    </div>
                    <span class="card-text pl-2 mt-2" style="font-size: 1.08em;white-space: pre;"><?= $call['description'] ?></span>
                    <hr class="mb-0 pb-0">
                  </div>
                  <div class="d-flex justify-content-center ">
                    <?php if ($call['status'] === 0) { ?>
                      <div class="col-md-6">
                        <a href="messages.php?call=<?= $call['id'] ?>" class="btn btn-lg btn-info col mb-3">Ver mensagens</a>
                      </div>
                      <form action="updateStatus.php" method="POST" class="col">
                        <input type="hidden" class="d-none" name="callId" value="<?= $call['id'] ?>">
                        <button type="submit" class="btn btn-lg btn-warning col  mb-3">Encerrar chamado</button>
                      </form>
                    <?php } else { ?>
                      <div class="col ">
                        <a href="messages.php?call=<?= $call['id'] ?>" class="btn btn-lg btn-info col mb-3">Ver mensagens</a>
                      </div>
                    <?php } ?>
                  </div>


                </div>
              </div>


          <?php }
          } ?>

          </div>
        </div>
  </div>
<?php } ?>
<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
  <div class="row mt-5 col-md-9 ml-auto mr-auto mt-5" id="mm-anchors" style="border: 1px solid #afafaf; border-radius: 40px;">
    <a href="view_calls.php" class="d-flex col text-left pl-5">
      <img class="my-4 pr-4 border-right" src="./src/img/looking-glass.png" alt="Novo chamado" width="190px">
      <div class="d-flex justify-content-center align-items-center text-center">
        <p class="h2 pl-4">Listar chamados</p>
      </div>
    </a>
  </div>
  <div class="row mt-5 col-md-9 ml-auto mr-auto mt-5" id="mm-anchors" style="border: 1px solid #afafaf; border-radius: 40px;">
    <a href="view_users.php" class="d-flex col text-left pl-5">
      <img class="my-4 pr-5 border-right" src="./src/img/clients.png" alt="Novo chamado" width="250px">
      <div class="d-flex justify-content-center align-items-center text-center">
        <p class="h2 pl-4">Listar usuários</p>
      </div>
    </a>
  </div>

<?php } ?>

</div>

</body>

</html>