<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';



// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


$get_pseudo = htmlentities($user['pseudo']);
$user_post = $pdo->prepare('SELECT * FROM posts WHERE user = ? ORDER BY id DESC');
$user_post->execute(array($get_pseudo));

if($user_post->rowCount() != 0) {
	$user_post = $user_post->fetchAll(PDO::FETCH_OBJ);

} 


?>

<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

		<main class="body_profile">
		<h1 class="title_user"> Profil de <?=$user['first_name'];?> </h1>
		
		<div class="info_user">
			<h2>Informations personnelles</h2>
			<p> Tu t'appelles <span> <?=$user['first_name'];?> <?=$user['last_name'];?> </span> !</p>
			<p>
				Ton pseudo est <span> <?=$user['pseudo'];?> </span>.
			</p>
			<p>
				Tu habites en <span> <?=$user['country'];?>	</span>  à cette adresse : <span> <?=$user['address'];?> </span>.
			</p>
			<p>
				Ton numéro de téléphone est <span><?=$user['phone'];?> </span>. 
			</p>
			<p>
				Ton email est <span><?=$user['email'];?> </span>.
			</p>
			<a class="btn_profile" href="informations.php?edit=<?= $user['pseudo']?>"> Modifier mes infos</a> 
			<?php if($user['is_admin'] == 1): ?>
			<a class="btn_profile" href="admin.php"> Page administrateur</a>
			<?php endif ?> 


		</div>
		<div class="newpost_user">
			<a class="a_newpost" href="newpost.php"> Demander de l'aide</a> 

		</div>



		<div class="posts_user">
			<h2>Voici les articles que tu as posté :</h2>
			<div class="elements">
				<?php foreach($user_post as $post) { ?>
					<h3 class="element"><a class="titre_article_profile" href="article.php?id=<?= $post->id ?>"><?= htmlentities($post->title) ?> </a> || <a href="edit.php?edit=<?= $post->id?>">modifier</a> || <a href="delete.php?delete=<?= $post->id?>">supprimer</a></h3>
					<?php } ?>
			</div>
		</div>

		<div class="delete_account">
			<a href="deleteaccount.php?pseudo=<?= $user['pseudo'] ?>" onClick="return confirm('Voulez vous vraiment supprimer votre compte ?')">Supprimer mon compte</a>
		</div>
		</main>

<?php include ('template/footer.php'); ?>

	</body>

</html>