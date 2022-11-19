<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = htmlentities($_GET['delete']);
    $delete_article = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $delete_article->execute(array($delete_id));
    if($delete_article->rowCount() == 1) {
        $delete_article = $delete_article->fetch();
        $suppression = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $suppression->execute(array($delete_id));
        header("Location: profile.php");


    } else {
       die('Erreur : l\'article n\'existe pas...');
    }
}


?>
