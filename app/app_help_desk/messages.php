<?php
require_once 'check_access.php';
require_once '../../controllers/CallController.php';
require_once '../../controllers/MessageController.php';

use call\Call as Call;
use message\Message as Message;

$call = Call::getById($_GET['call']);
$call = $call[0];

$messages = Message::getAll($_GET['call']);

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
    <div>
      <div class="d-flex justify-content-around mb-0 mt-4">
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) { ?>
          <h6 class="card-subtitle mb-2 text-muted text-left col-md-6"><?= $call['name'] . ' - aberto em: ' . $call['createdAt'] . '.' ?></h6>
        <?php } else { ?>
          <h6 class="card-subtitle mb-2 text-muted text-left col-md-6"><?= 'Aberto em: ' . $call['createdAt'] . '.' ?></h6>
        <?php } ?>
        <h6 class="card-subtitle mb-2 text-muted text-right col-md-6"><?= 'Tipo: ' . $call['type'] ?></h6>
      </div>
    </div>
    <div class="card mt-1">
      <div class="card-body">
        <div>
          <h1 style="white-space: pre;"><?= $call['title'] ?></h1>
        </div>
        <hr>
        <div>
          <span style="white-space: pre;">
            <?= $call['description'] ?>
          </span>
        </div>
      </div>
    </div>
    <div>
      <h6 class="card-subtitle text-muted mt-2 text-center">Status: <?= getStatus($call['status']) . ' ' . $call['closedAt'] ?></h6>
      <div class="mt-4">
        <div>
          <div class="col-md-10 m-auto">
          </div>
        </div>
        <div>
          <div class="mt-3">

            <?php if ($messages != null) {
              foreach ($messages as $message) { ?>
                <?php if ($message['userId'] === $_SESSION['userId']) { ?>

                  <div class="col-md-6 ml-auto">
                    <div class="col">
                      <div class="text-right pr-1 mt-2">
                        <h5>Você</h5>
                      </div>
                      <div class="question-card col">
                        <div class="pl-3 pt-2 pb-2">
                          <h5 style="white-space: pre;"><?= $message['message'] ?></h5>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } else { ?>

                  <div class="col-md-6">
                    <div class="row mr-5 col-md-4 mt-2">
                      <?php if ($message['avatar'] != null) { ?>
                        <img src="<?= $message['avatar'] ?>" class="mr-1 mb-1 message-avatar" alt="User photo" width="36px">
                      <?php } ?>
                      <div class="d-flex align-items-center">
                        <span class="h5"><?= $message['name'] ?></span>
                      </div>
                    </div>
                    <div class="inverse-question-card col ">
                      <div class="pl-3 pt-2 pb-2">
                        <h5 style="white-space: pre;"><?= $message['message'] ?></h5>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              <?php }
            } else { ?>

              <div>
                <h4>Sem respostas...</h4>
              </div>

            <?php } ?>

          </div>
          <div class="mt-5 mb-5">
            <?php if (isset($_GET['new']) || isset($_GET['emptyField'])) { ?>
              <hr id="scroll-target">
            <?php } else { ?>
              <hr>
            <?php } ?>
            <div>

              <?php if ($call['status'] != 0) { ?>

                <div class="text-center mb-3 h6">
                  Chamadas concluídas não podem mais receber mensagens
                </div>

              <?php } ?>

              <?php if (isset($_GET['emptyField'])) { ?>

                <div class="text-center mb-3 h6" style="color: red;">
                  * Preencha o campo antes de enviar sua mensagem!
                </div>

              <?php } ?>

            </div>

            <?php if ($call['status'] === 0) { ?>

              <form action="messageSender.php" method="POST" class="col-md-10 m-auto">
                <textarea name="message" id="" cols="30" rows="10" class="form-control" placeholder="Digite sua mensagem aqui..."></textarea>
                <input type="hidden" name="userId" value="<?= $_SESSION['userId'] ?>" class="d-none">
                <input type="hidden" name="callId" value="<?= $_GET['call'] ?>" class="d-none">
                <div class="d-flex justify-content-around">
                  <button type="submit" class="btn btn-lg btn-info col-md-5 mt-2">
                    <h6 class="m-auto">Enviar</h6>
                  </button>
                  <a onclick="endCall(this)" class="btn btn-lg btn-warning col-md-5 mt-2 d-flex">
                    <h6 class="m-auto">Finalizar chamado</h6>
                  </a>
                </div>
              </form>

              <form action="updateStatus.php" id="end-call" method="POST">
                <input type="hidden" name="callId" value="<?= $call['id'] ?>">
              </form>

            <?php } ?>

          </div>
        </div>
      </div>
      <div>
        <div class="text-center mb-4">
          <a href="home.php" class="btn btn-lg btn-dark col-md-6">Voltar</a>
        </div>
      </div>
    </div>
  </div>

</body>

<script>
  scroll()
</script>

</html>