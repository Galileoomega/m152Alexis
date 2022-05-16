<?php include "layout/navbar.php"; 

require_once "models/post.php";

try
{
	$posts = getAllPosts();
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

?>


<img class="profile-picture" src="assets/cat-weird-weird.gif" alt="">
<h1>Welcome !</h1>

<?php 
	foreach($posts as $post) :
?>
<div class="card">
	<?php 
		foreach(getMediaWithPostId($post["idPost"]) as $media) :
	?>
	<img src="uploads/<?= $media["nomMedia"] ?>" alt="">
	<?php endforeach; ?>
	<?= $post["commentaire"] ?>
</div>
<?php endforeach; ?>

<?php include "layout/footer.php"; ?>