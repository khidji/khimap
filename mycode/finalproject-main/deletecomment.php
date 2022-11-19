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
    $delete_comment = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
    $delete_comment->execute(array($delete_id));
    if($delete_comment->rowCount() == 1) {
        $delete_comment = $delete_comment->fetch();
        $suppression = $pdo->prepare('DELETE FROM comments WHERE id = ?');
        $suppression->execute(array($delete_id));
        header("Location: article.php?id=" . $delete_comment['post_id']);

    } else {
       die('Erreur : le commentaire n\'existe pas...');
    }
}


?>
