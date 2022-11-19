<?php

session_start();
if (isset($_SESSION['user'])) {
  header('Location: /');
}

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = validateForm($_POST);

  if (empty($errors)) {
    [
	  'pseudo' => $pseudo,
      'first_name' => $firstName,
      'last_name' => $lastName,
	  'phone' => $phone,
	  'address' => $address,
	  'city' => $city,
	  'country' => $country,
	  'postal_code' => $postalCode,
      'email' => $email,
      'password' => $password,
      'confirm_password' => $confirmPassword,
    ] = $_POST;

    $passwordMatch = false;

    // si les mots de passe concordent
    if ($password === $confirmPassword) {
      $passwordMatch = true;
      // on hash le mot de pass (sécurise)
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 14]);

      $query = <<< EOL
			INSERT INTO users (
				pseudo,
				first_name,
				last_name,
				phone,
				address,
				city,
				country,
				postal_code,
				email,
				password
			)
			VALUES
			(:pseudo, :first_name, :last_name, :phone, :address, :city, :country, :postal_code, :email, :password);
			EOL;

      $statement = $pdo->prepare($query);
      // on execute la requete en lui passant les paramètres dont elle a besoin pour sa requete préparée
      $success = $statement->execute([
		'pseudo' => htmlentities($pseudo),
    	'first_name' => htmlentities($firstName),
    	'last_name' => htmlentities($lastName),
		'phone' => htmlentities($phone),
		'address' => htmlentities($address),
		'city' => htmlentities($city),
		'country' => htmlentities($country),
		'postal_code' => htmlentities($postalCode),
    	'email' => htmlentities($email),
    	'password' => $hashedPassword,
      ]);

      // si l'ajout s'est bien passé on redirige vers le login
      if ($success) {
        header('Location: login.php');
      }

      $errors['db_error'] = "Un problème est survenu lors de l'ajout.";
    }

    if (!$passwordMatch) {
      $errors["password_match"] = "Les mots de passe ne concordent pas.";
    }
  }
}

;?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>finalproject | Inscription</title>

		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/auth/auth.css">
		<script src="assets/js/auth.js" defer></script>
	</head>

	<body>

		<main>
			<div class="container">
				<form method='POST'>
					<fieldset>
						<?php if (isset($errors['password_match'])): ?>
						<p class="error"><?=$errors['password_match'];?></p>
						<?php endif;?>
						<?php if (isset($errors['db_error'])): ?>
						<p class="error"><?=$errors['db_error'];?></p>
						<?php endif;?>
						<div>
							<input value="<?=$_POST['pseudo'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
								name="pseudo" id="pseudo">
							<label for="pseudo">Pseudo</label>
						</div>
						<?php if (isset($errors['last_name'])): ?>
						<p class="error"><?=$errors['last_name'];?></p>
						<?php endif;?>
						<div>
							<input value="<?=$_POST['first_name'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
								name="first_name" id="first_name">
							<label for="first_name">Prénom</label>
						</div>
						<?php if (isset($errors['first_name'])): ?>
						<p class="error"><?=$errors['first_name'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['last_name'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
								name="last_name" id="last_name">
							<label for="last_name">Nom</label>
						</div>
						<?php if (isset($errors['last_name'])): ?>
						<p class="error"><?=$errors['last_name'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['email'] ?? '';?>" placeholder=" " autocomplete="off" type="email" name="email"
								id="email">
							<label for="email">Email</label>
						</div>
						<?php if (isset($errors['email'])): ?>
						<p class="error"><?=$errors['email'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['phone'] ?? '';?>" placeholder=" " autocomplete="off" type="phone" name="phone"
								id="phone">
							<label for="phone">Numéro de téléphone</label>
						</div>
						<?php if (isset($errors['phone'])): ?>
						<p class="error"><?=$errors['phone'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['address'] ?? '';?>" placeholder=" " autocomplete="off" type="address" name="address"
								id="address">
							<label for="address">Adresse</label>
						</div>
						<?php if (isset($errors['address'])): ?>
						<p class="error"><?=$errors['address'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['postal_code'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="postal_code"
								id="postal_code">
							<label for="postal_code">Code postal</label>
						</div>
						<?php if (isset($errors['postal_code'])): ?>
						<p class="error"><?=$errors['postal_code'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['city'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="city"
								id="city">
							<label for="city">Ville</label>
						</div>
						<?php if (isset($errors['city'])): ?>
						<p class="error"><?=$errors['city'];?></p>
						<?php endif;?>

						<div>
							<input value="<?=$_POST['country'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="country"
								id="country">
							<label for="country">Pays</label>
						</div>
						<?php if (isset($errors['country'])): ?>
						<p class="error"><?=$errors['country'];?></p>
						<?php endif;?>


						<div class="password__container">
							<span class="eye--open"></span>
							<span class="tooltip"
								title="8 caractères minimum, au moins une majuscule, au moins une minuscule, un chiffre et un caractère spécial">ℹ</span>
							<input value="<?=$_POST['password'] ?? '';?>" placeholder=" " autocomplete="off" type="password"
								name="password" id="password">
							<label for="password">Mot de passe</label>
						</div>
						<?php if (isset($errors['password'])): ?>
						<p class="error"><?=$errors['password'];?></p>
						<?php endif;?>

						<div class="password__container">
							<span class="eye--open"></span>
							<input value="<?=$_POST['confirm_password'] ?? '';?>" placeholder=" " autocomplete="off" type="password"
								name="confirm_password" id="confirm_password">
							<label for="confirm_password">Confirmation mot de passe</label>
						</div>
						<?php if (isset($errors['confirm_password'])): ?>
						<p class="error"><?=$errors['confirm_password'];?></p>
						<?php endif;?>

						<div>
							<button type="submit">S'inscrire</button>
						</div>
					</fieldset>
				</form>
				<div class="blur"></div>
			</div>
		</main>
	</body>

</html>