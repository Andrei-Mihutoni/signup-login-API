<?php
require_once(__DIR__.'/../globals.php');



$db = _api_db();

try{
  $item_id = bin2hex(random_bytes(16));
  $q = $db->prepare('DELETE FROM items WHERE item_id = :item_id');
  $q->bindValue(':item_id', $_POST['item_id']);
 
  $q->execute();
  // Success
//   echo $item_id;
  echo "Item deleted";
  // echo "Item created with id $item_id";
}catch(Exception $ex){
    echo $ex;
  http_response_code(500);
  echo 'System under maintainance '.__LINE__;
  exit();
}