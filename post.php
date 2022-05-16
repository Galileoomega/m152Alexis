<?php

require_once "models/post.php";

// Initialisation des variables
$commentaire = "";
$file = "";

if (filter_has_var(INPUT_POST,'submit')) {

    // récupération des données provenant des données saisies par l'utilisateur    
    $commentaire = trim(filter_input(INPUT_POST,'commentaire',FILTER_SANITIZE_STRING));
    $file = trim(filter_input(INPUT_POST,'file',FILTER_SANITIZE_STRING));
    $idPost = filter_input(INPUT_POST, 'idPost', FILTER_VALIDATE_INT);

    $idPost = addPost($commentaire);

    //Sauvegarde les fichiers et les place dans un autre dossier
    $uploads_dir = './uploads';
    foreach ($_FILES["file"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            if($_FILES["file"]["type"][$key] == 'image/jpeg' || $_FILES["file"]["type"][$key] == 'image/png') {
                $tmp_name = $_FILES["file"]["tmp_name"][$key];
                $name = basename($_FILES["file"]["name"][$key]);
                $name = uniqid() . $name;

                $mediaId = addMedia($idPost, $name, $_FILES["file"]["type"][$key]);

                // Ajouer un media dans la base de données
                if(null !== $mediaId) {
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                }
                else {
                    // Si le ficher na pas pu etre uploader dans la base de données
                }
                
            } else {
                $message = "Le type de fichier n'est pas supporté !";
            }
        }    
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