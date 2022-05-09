<?php 

require_once 'dbconnection.php';

function getAllPosts() {
    $db = connectDb();
    $sql = "SELECT commentaire location "
            . "FROM post ";
    $request = $db->prepare($sql);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function addPost($commentaire, $images) {
    $db = connectDb();
    $sql = "INSERT INTO post(commentaire, images) "
		. "VALUES(:commentaire, :images)";
    $request = $db->prepare($sql);
    $request->execute(array(
		"commentaire" => $commentaire,
		"images" => $images
		));
    return $db->LastInsertID();
}

?>