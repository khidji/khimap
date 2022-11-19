<?php
session_start();

// si l'utilisateur est connecté on le redirige vers la page d'accueil
if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = validateForm($_POST, true);

  // si le tableau d'erreur est vide on peut proceder au traitement du formulaire
  if (empty($errors)) {
    [
      'email' => $email,
      'password' => $password,
    ] = $_POST;

    // on cherche dans la base de donnée un utilisateur qui aurait un email qui correspond à celui envoyé via le formulaire
    $statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $statement->execute(["email" => htmlentities($email)]);
    $user = $statement->fetch();

    // password_verify va nous permettre de comparer les mots de passes (celui du formulaire et celui de l'utilisateur de la BDD)
    if ($user && password_verify($password, $user['password'])) {

      // on connecte l'utilisateur et on redirige
      $_SESSION['user'] = $user;
      header('Location: index.php');
    }

    // on ajoute une clé d'erreur au cas ou l'email ou le mot de passe sont incorrect
    $errors['notFound'] = "email ou mot de passe incorrect.";
  }
}

;?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Connexion</title>

		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/auth/auth.css">
		<script src="assets/js/auth.js" defer></script>
	</head>

	<body>
		<main>

			<div class="container">
				<form method='POST'>
					<fieldset>
						<?php if (isset($errors['notFound'])): ?>
						<p class="error"><?=$errors['notFound'];?></p>
						<?php endif;?>
						<div>
							<!--
							on renvoie les données transmises par l'utilisateur dans l'attribut value pour eviter qu'il retape tout en cas d'erreur
							-->
							<input value="<?=$_POST['email'] ?? '';?>" placeholder=" " autocomplete="off" type="email" name="email"
								id="email">
							<label for="email">Email</label>
						</div>
						<!-- message d'erreur -->
						<?php if (isset($errors['email'])): ?>
						<p class="error"><?=$errors['email'];?></p>
						<?php endif;?>

						<div class="password__container">
							<span class="eye--open"></span>
							<input value="<?=$_POST['password'] ?? '';?>" placeholder=" " autocomplete="off" type="password"
								name="password" id="password">
							<label for="password">Mot de passe</label>
						</div>
						<!-- message d'erreur -->
						<?php if (isset($errors['password'])): ?>
						<p class="error"><?=$errors['password'];?></p>
						<?php endif;?>

						<div>
							<button type="submit">Se connecter</button>
							<a href="signup.php">pas de compte ?</a>
						</div>
					</fieldset>
				</form>
				<div class="blur"></div>
			</div>
		</main>

	</body>

</html>