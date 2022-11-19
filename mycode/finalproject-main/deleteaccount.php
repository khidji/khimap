<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


if(isset($_GET['pseudo']) && !empty($_GET['pseudo'])) {
    $delete_id = htmlentities($_GET['pseudo']);
    $delete_user = $pdo->prepare('SELECT * FROM users WHERE pseudo = ?');
    $delete_user->execute(array($delete_id));
    if($delete_user->rowCount() == 1) {
        $delete_user = $delete_user->fetch();
        $suppression = $pdo->prepare('DELETE FROM users WHERE pseudo = ?');
        $suppression->execute(array($delete_id));
        unset($_SESSION['user']);
        header('Location: login.php');

    } else {
       die('Erreur : le compte n\'existe pas...');
    }
}


?>
