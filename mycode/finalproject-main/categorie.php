<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];

if(isset($_GET['id']) && !empty($_GET['id'])){
    $get_id = htmlentities($_GET['id']);
    $currentPage = (int)($_GET['page'] ?? 1) ?: 1;
    if ($currentPage <= 0){
        $e = 'Numéro de page invalide';
    }
    $count = (int)$pdo->query('SELECT COUNT(id) FROM posts WHERE category_id = ' .$get_id)->fetch(PDO::FETCH_NUM)[0];
    $perpage = 6;
    $pages = ceil($count / $perpage);
    if ($currentPage > $pages){
        $e = 'Cette page n\'existe pas';
    }
    $offset = $perpage * ($currentPage - 1);


    $articles = $pdo->prepare("SELECT * FROM posts WHERE category_id =:id ORDER BY id DESC LIMIT $perpage OFFSET $offset");
    $articles->execute(['id'=> $get_id]);
    
    $articles = $articles->fetchAll();
    $lienaltimg = "https://images.pexels.com/photos/411195/pexels-photo-411195.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";

    

} else {
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main>

    <div class ="container_test">
    
        <ul class="recent_posts">
            <?php if(isset($e)) {echo $e;} ?>
            <?php foreach ($articles as $a):  ?>
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
						</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class='boutons_pages'>
        <?php if ($currentPage > 1): ?>
            <a href="categorie.php?id=<?= $get_id ?>&page=<?= $currentPage -1 ?>" class="boutons_pages_btn">Page précédente</a>
        <?php endif ?>	
        <?php if ($currentPage < $pages): ?>
            <a href="categorie.php?id=<?= $get_id ?>&page=<?= $currentPage +1 ?>" class="boutons_pages_btn">Page suivante</a>
        <?php endif ?>	

    </div>

</main>

<?php include ('template/footer.php'); ?>

</html>