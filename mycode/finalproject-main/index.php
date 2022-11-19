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

$articles = $pdo->query('SELECT * FROM posts ORDER BY id DESC LIMIT 9');

$lienaltimg = "https://images.pexels.com/photos/411195/pexels-photo-411195.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";

?>

<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>


		<main>
			<div class="accueil">
				<h1 class="welcome">Bienvenue
					<?=$user['pseudo'];?>
				</h1>
				<p class="p_home">Si tu galères avec les langages de programmation, tu es au bon endroit ! Dépose une demande d'aide et quelqu'un te donnera surement la solution </p>
				<a class="a_newpost" href="newpost.php"> Demander de l'aide</a> 
			</div>




			<div class="container_recentposts">
				<h2 class="h2_home">Dernières publications:</h2>
				<ul class="recent_posts">
					<?php while ($a = $articles->fetch()) { ?>
						<li class ="post"> 
							<div class="card">
								
								<img src="<?php if ($a['image_url'] != "assets/images/bdd/"): ?>
										<?=$a['image_url'];?> 
									<?php else : ?>
										<?=$lienaltimg;?>		
								 <?php endif?>" alt="image" class="card__image "> 
								
								<div class="card__content">
									<div class="card__title"><h3><?= $a['title']?> </h3> </div>
									<p class="card__text"> <?= substr(($a['content']), 0, 70).'...' ?> </p>
									<a class="btn btn--block card__btn" href="article.php?id=<?= $a['id'] ?>"> voir l'article </a>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
				<a class="bouton_accueil boutons_pages_btn" href="posts.php">voir tous les posts</a>
			</div>
		</main>

<?php include ('template/footer.php'); ?>


</html>