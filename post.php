<?php

require_once "models/post.php";
require_once "models/dbconnection.php";

// Initialisation des variables
$commentaire = "";
$file = "";

if (filter_has_var(INPUT_POST,'submit')) {

    // récupération des données provenant des données saisies par l'utilisateur    
    $commentaire = trim(filter_input(INPUT_POST,'commentaire',FILTER_SANITIZE_STRING));
    $file = trim(filter_input(INPUT_POST,'file',FILTER_SANITIZE_STRING));
    $idPost = filter_input(INPUT_POST, 'idPost', FILTER_VALIDATE_INT);

    try {
        // First of all, let's begin a transaction
        $validRequest = false;
        $db = connectDB();
        $db->beginTransaction();
        
        $idPost = addPost($commentaire);
    
        //Sauvegarde les fichiers et les place dans un autre dossier
        $uploads_dir = './uploads';
        foreach ($_FILES["file"]["error"] as $key => $error) {
            echo $error;
            if ($error === UPLOAD_ERR_OK) {
                $mediaType = explode("/", $_FILES["file"]["type"][$key])[0];
                if($mediaType == 'image' || $mediaType == 'video' || $mediaType == 'audio') {
                    $tmp_name = $_FILES["file"]["tmp_name"][$key];
                    $name = basename($_FILES["file"]["name"][$key]);
                    $name = uniqid() . $name;
                    
                    // Ajouer un media dans la base de données
                    $mediaId = addMedia($idPost, $name, $_FILES["file"]["type"][$key]);
    
                    // INSERT
                    if($mediaId) {
                        if(move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
                            $validRequest = true;
                        }
                        else {
                            // Erreur lors de la sauvegarde
                            $message = "Erreur lors de la sauvegarde dans le serveur.";
                            $validRequest = false;
                        }
                    }
                    else {
                        // Si le ficher na pas pu etre uploader dans la base de données
                    }
                    
                } else {
                    $message = "Le type de fichier n'est pas supporté !";
                    $validRequest = false;
                }
            }
        }
        
        // If we arrive here, it means that no exception was thrown
        // i.e. no query has failed, and we can commit the transaction
        $db->commit();

        if($validRequest) {
            header("LOCATION: index.php");
        }
    } catch (\Throwable $e) {
        // An exception has been thrown
        // We must rollback the transaction
        $db->rollback();
        throw $e; // but the error must be handled anyway
    }
}

include "layout/navbar.php";

?>

<div class="post-container">
    <div class="post-wrapper">
        <h1>Nouveau post</h1>
        <form method="post" action="post.php" enctype="multipart/form-data">
            <textarea placeholder="Ecrivez votre message ici..." name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
            <input name="file[]" type="file" multiple accept="image/*, video/*, audio/*">

            <input type="submit" name="submit">
        </form>
    </div>
</div>

<?php include "layout/footer.php"; ?>