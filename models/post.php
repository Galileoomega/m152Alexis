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

function addPost($commentaire) {
  echo $commentaire;
  $db = connectDb();
  $sql = "INSERT INTO post(commentaire) "
  . "VALUES(:commentaire)";
  $request = $db->prepare($sql);
  $request->execute(array(
  "commentaire" => $commentaire
  ));
  return $db->LastInsertID();
}

function addMedia($idPost, $name, $type) {
  $db = connectDb();
  $sql = "INSERT INTO media(idPost, nomMedia, typeMedia) "
  . "VALUES(:idPost, :name, :type)";
  $request = $db->prepare($sql);
  $request->execute(array(
    "idPost" => $idPost,
    "name" => $name,
    "type" => $type
  ));
  return $db->LastInsertID();
}

?>