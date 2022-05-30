<?php 

require_once 'dbconnection.php';

function getAllPosts() {
  $db = connectDb();
  $sql = "SELECT idPost, commentaire FROM post ORDER BY creationDate DESC";
  $request = $db->prepare($sql);
  $request->execute();
  return $request->fetchAll(PDO::FETCH_ASSOC);
}

function getMediaWithPostId($postId) {
  $id = (int)$postId;
  $db = connectDb();
  $sql = "SELECT * FROM media WHERE idPost=" . $id;
  $request = $db->prepare($sql);
  $request->execute();
  return $request->fetchAll(PDO::FETCH_ASSOC);
}

function addPost($commentaire) {
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