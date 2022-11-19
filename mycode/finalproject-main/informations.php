<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';
require_once __DIR__ . '/functions.php';


// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


if(isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_pseudo = htmlentities($_GET['edit']);
    $edit_user = $pdo->prepare('SELECT * FROM users WHERE pseudo = ?');
    $edit_user->execute(array($edit_pseudo));
    if($edit_user->rowCount() == 1) {
       $edit_user = $edit_user->fetch();
    } else {
       die('Erreur : l\'utilisateur n\'existe pas...');
    }
}    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateForm($_POST);
  
    if (empty($errors)) {
      [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'phone' => $phone,
        'address' => $address,
        'city' => $city,
        'country' => $country,
        'postal_code' => $postalCode,
        'email' => $email,
      ] = $_POST;
  
        $query = ("UPDATE users SET
                first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                address = :address,
                city = :city,
                country = :country,
                postal_code = :postal_code,
                email = :email
                WHERE pseudo = :pseudo");
  
        $statement = $pdo->prepare($query);
        // on execute la requete en lui passant les paramètres dont elle a besoin pour sa requete préparée
        $success = $statement->execute([
          'first_name' => htmlentities($firstName),
          'last_name' => htmlentities($lastName),
          'phone' => htmlentities($phone),
          'address' => htmlentities($address),
          'city' => htmlentities($city),
          'country' => htmlentities($country),
          'postal_code' => htmlentities($postalCode),
          'email' => htmlentities($email),
          'pseudo' => $user['pseudo']
        ]);
  
        // si l'ajout s'est bien passé on redirige vers le login
        if ($success) {
          header('Location: logout.php');
        }
  
        $errors['db_error'] = "Un problème est survenu lors de la mise à jour.";
    }
  
}


?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main class ="informations_perso">



<div class="container_infos">

    <form method='POST'>
        <?php if (isset($errors['password_match'])): ?>
            <p class="error"><?=$errors['password_match'];?></p>
        <?php endif;?>
        <?php if (isset($errors['db_error'])): ?>
            <p class="error"><?=$errors['db_error'];?></p>
        <?php endif;?>
                
        <div>
            <label for="pseudo">Pseudo</label>
            <input value="<?=$user['pseudo'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
            name="pseudo" class="inputpseudo" id="pseudo" readonly="readonly">
        </div>
                
                
        <?php if (isset($errors['last_name'])): ?>
            <p class="error"><?=$errors['last_name'];?></p>
        <?php endif;?>
        <div>
            <label for="first_name">Prénom</label>
            <input value="<?=$user['first_name'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
            name="first_name" id="first_name">
        </div>
        <?php if (isset($errors['first_name'])): ?>
            <p class="error"><?=$errors['first_name'];?></p>
        <?php endif;?>
        <div>
            <label for="last_name">Nom</label>
            <input value="<?=$user['last_name'] ?? '';?>" placeholder=" " autocomplete="off" type="text"
            name="last_name" id="last_name">
        </div>
        <?php if (isset($errors['last_name'])): ?>
            <p class="error"><?=$errors['last_name'];?></p>
            <?php endif;?>
                
        <div>
            <label for="email">Email</label>
            <input value="<?=$user['email'] ?? '';?>" placeholder=" " autocomplete="off" type="email" name="email"
            id="email">
        </div>
        <?php if (isset($errors['email'])): ?>
            <p class="error"><?=$errors['email'];?></p>
        <?php endif;?>
                
        <div>
            <label for="phone">Numéro de téléphone</label>
            <input value="<?=$user['phone'] ?? '';?>" placeholder=" " autocomplete="off" type="phone" name="phone"
            id="phone">
        </div>
        <?php if (isset($errors['phone'])): ?>
            <p class="error"><?=$errors['phone'];?></p>
        <?php endif;?>
                    
        <div>
            <label for="address">Adresse</label>
            <input value="<?=$user['address'] ?? '';?>" placeholder=" " autocomplete="off" type="address" name="address"
            id="address">
        </div>
        <?php if (isset($errors['address'])): ?>
            <p class="error"><?=$errors['address'];?></p>
        <?php endif;?>
            
        <div>
            <label for="postal_code">Code postal</label>
            <input value="<?=$user['postal_code'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="postal_code"
            id="postal_code">
        </div>
        <?php if (isset($errors['postal_code'])): ?>
            <p class="error"><?=$errors['postal_code'];?></p>
        <?php endif;?>
                
        <div>
            <label for="city">Ville</label>
            <input value="<?=$user['city'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="city"
            id="city">
        </div>
        <?php if (isset($errors['city'])): ?>
            <p class="error"><?=$errors['city'];?></p>
        <?php endif;?>
                    
        <div>
            <label for="country">Pays</label>
            <input value="<?=$user['country'] ?? '';?>" placeholder=" " autocomplete="off" type="text" name="country"
            id="country">
        </div>
        <?php if (isset($errors['country'])): ?>
            <p class="error"><?=$errors['country'];?></p>
        <?php endif;?>
        
            
        <div>
            <button type="submit">Modifier les informations</button>
        </div>

    </form>
                        
</div>


</main>

<?php include ('template/footer.php'); ?>

</html>