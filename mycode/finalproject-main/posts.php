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

$currentPage = (int)($_GET['page'] ?? 1) ?: 1;
if ($currentPage <= 0){
    $e = 'Numéro de page invalide';
}
$count = (int)$pdo->query('SELECT COUNT(id) FROM posts')->fetch(PDO::FETCH_NUM)[0];
$perpage = 6;
$pages = ceil($count / $perpage);
if ($currentPage > $pages){
    $e = 'Cette page n\'existe pas';
}
$offset = $perpage * ($currentPage - 1);
$query = $pdo->query("SELECT * FROM posts ORDER BY id DESC LIMIT $perpage OFFSET $offset");
$query = $query->fetchAll();
$lienaltimg = "https://images.pexels.com/photos/411195/pexels-photo-411195.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";



?>

<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>


		<main>
			<h1 class="welcome"> Voici tous les posts
				<?=$user['pseudo'];?>
			</h1>

			<ul class="recent_posts">
				<?php foreach ($query as $a):  ?>
					<li class ="post"> 
						<div class="card">
							
							<img src="<?php if ($a['image_url'] != "assets/images/bdd/"): ?>
									<?=$a['image_url'];?> 
								<?php else : ?>
									<?=$lienaltimg;?>		
							<?php endif?>" alt="image" class="card__image "> 
							
							<div class="card__content">
								<div class="card__title"><h3><?= $a['title']?> </h3> </div>
								<p class="card__text"> <?= substr(($a['content']), 0, 100).'...' ?> </p>
								<a class="btn btn--block card__btn" href="article.php?id=<?= $a['id'] ?>"> voir l'article </a>
							</div>
						</div>

				<?php endforeach; ?>
			</ul>							

			</li>

			<div class='boutons_pages'>
					<?php if ($currentPage > 1): ?>
						<a href="posts.php?page=<?= $currentPage -1 ?>" class="boutons_pages_btn">Page précédente</a>
					<?php endif ?>	
					<?php if ($currentPage < $pages): ?>
						<a type="button" href="posts.php?page=<?= $currentPage +1 ?>" class="boutons_pages_btn">Page suivante</a>
					<?php endif ?>	

			</div>

		</main>

<?php include ('template/footer.php'); ?>


</html>