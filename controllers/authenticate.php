 <?php
	session_start();

	require_once '../../controllers/UserController.php';

	use user\User as User;

	$user = User::authenticate($_POST['email'], $_POST['password']);
	if ($user != null && $user[0]['id'] === 1) {
		$_SESSION['authenticated'] = true;
		$_SESSION['admin'] = true;
		$_SESSION['userId'] = $user[0]['id'];
		$_POST = null;
		return header('location: home.php');
	} else if ($user != null) {
		$_SESSION['authenticated'] = true;
		$_SESSION['userId'] = $user[0]['id'];
		$_SESSION['userName'] = $user[0]['name'];
		$_SESSION['userEmail'] = $user[0]['email'];
		$_POST = null;
		return header('location: home.php');
	} else {
		$_SESSION['authenticated'] = false;
		return header('location: index.php?login=error');
	}

	?>