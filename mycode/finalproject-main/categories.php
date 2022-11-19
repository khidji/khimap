<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
// on inclu database pour récupérer le pdo
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';


// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
}

$user = $_SESSION['user'];

$selection = $pdo->query('SELECT id, name FROM categories;');
$selection->execute();
$selection = $selection->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<?php include ('template/header.php'); ?>

<main class ="body_categories">
  
  <ul class ="lien_categories">
  <?php foreach ($selection as $category) { ?>
    <li class ="lien_categorie"> <a href="categorie.php?id=<?= $category->id ?>"> <?= $category->name?> </a> </li>
    <?php } ?>
  </ul>

</main>



<?php include ('template/footer.php'); ?>




</html>