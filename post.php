<?php

// Initialisation des variables
$commentaire = "";
$file = "";

if (filter_has_var(INPUT_POST,'submit')) {
    
    // Dossier temporaire
    $uploads_dir = './uploads';
    foreach ($_FILES["file"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["file"]["tmp_name"][$key];
            $name = basename($_FILES["file"]["name"][$key]);
            $name = uniqid() . $name;
    
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
        }
    }

    // récupération des données provenant des données saisies par l'utilisateur    
    $commentaire = trim(filter_input(INPUT_POST,'commentaire',FILTER_SANITIZE_STRING));
    $file = trim(filter_input(INPUT_POST,'file',FILTER_SANITIZE_STRING));

          
    $idPost = filter_input(INPUT_POST, 'idPost', FILTER_VALIDATE_INT);
    if ($idPost === false) {
       $idPost = null;
    }
        
   
    // vérification des données saisies
    if (empty($commentaire))
        $errors['commentaire'] = "Message missing";
    if (empty($file))
        $file = "";
        
    // si il n'y a pas d'erreur dans les données saisies
    if (empty($errors)) {
        $idPost = addPost($commentaire, $file);
        header("location:?action=index");
        exit;
    }
}

include "layout/navbar.php";

?>

<div class="post-container">
    <div class="post-wrapper">
        <h1>Nouveau post</h1>
        <form method="post" action="post.php" enctype="multipart/form-data">
            <textarea placeholder="Ecrivez votre message ici..." name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
            <input name="file[]" type="file" multiple accept="image/*">

            <input type="submit" name="submit">
        </form>
    </div>
</div>

<?php include "layout/footer.php"; ?>