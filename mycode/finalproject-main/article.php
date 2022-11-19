<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];
$lienaltimg = "https://images.pexels.com/photos/411195/pexels-photo-411195.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";

if(isset($_GET['id']) && !empty($_GET['id'])){
    $get_id = htmlentities($_GET['id']);
    $article = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $article->execute(array($get_id));

    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $title = $article['title'];
        $content = $article['content'];

        if ($article['image_url'] != "assets/images/bdd/"){
            $image = $article['image_url'];
        }
        else {
            $image = $lienaltimg;		
        }
    } else {
        die ('Cet article n\'existe pas !');
    }

} else {
    header("Location: index.php");
}

if($_POST['submit_comment']){
    if(isset($_POST['pseudo'], $_POST['commentaire']) && !empty($_POST['pseudo']) && !empty($_POST['commentaire'])){
        $pseudo = htmlentities($_POST['pseudo']);
        $comment = htmlentities($_POST['commentaire']);

        $commenter = $pdo->prepare('INSERT INTO comments (content, user, post_id) VALUES (?,?,?)');
        $commenter->execute(array($comment, $pseudo, $get_id));
        
    } else {
        $c_error = "tous les champs doivent être complétés";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main>
    <div class="article">
        <div class="div_content">
            <h1 class="article_titre"><?= $title ?></h1>
            <p class="article_content"><?= $content ?></p>
        </div>
        <div class="div_img">
            <img class="article_img" src="<?php echo $image; ?>">
        </div>
    </div>
    <div class="commentaires">
        <h2>Commentaires</h2>
        <form method="POST" class="nouveau_commentaire">
            <label for="pseudo">Pseudo</label>
            <input class="input_form" type="text" name="pseudo" value="<?= $user['pseudo']?>" readonly="readonly" >
            <label for="commentaire">Votre commentaire</label>
            <textarea name="commentaire" ></textarea>
            <input class="submit" type="submit" value="commenter" name="submit_comment">
            <?php if (isset($c_error)) { echo "Erreur : ".$c_error;} ?>
        </form>
        <ul class ="comments">
        <?php
            $commentaires = $pdo->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY id DESC ');
            $commentaires->execute(array($get_id));
            
            if($commentaires->rowCount() > 0) {
                $commentaires = $commentaires->fetchAll(PDO::FETCH_OBJ);
                foreach ($commentaires as $commentaire){ ?>

                <li class="commentaire">
                    <h3><?= $commentaire->user ?></h3>
                    <p><?= $commentaire->content?></p>
                    <span>Publié le : <?= $commentaire->created_at?></span>
                    <?php if(($commentaire->user) == ($user['pseudo']) || ($user['is_admin'] == 1)) { ?>
                        <a href="deletecomment.php?delete=<?= $commentaire->id?>">supprimer</a>
                    <?php } ?>
                </li>
                <?php }} ?>
        </div>
    </div>
</main>

<?php include ('template/footer.php'); ?>

</html>