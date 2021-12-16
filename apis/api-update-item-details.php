<?php
require_once(__DIR__ . '/../globals/globals.php');
session_start();

// // for frontend
$itemID = $_SESSION['itemID'];

// for Postman testing
// $itemID = $_GET['id'];


// Validate the item details
if(!isset($_POST['item_name'])){ http_response_code(400); echo 'item_name required'; exit(); };
if(!isset($_POST['item_description'])){ http_response_code(400); echo 'item_description required'; exit(); };
if(!isset($_POST['item_price'])){ http_response_code(400); echo 'item_price required'; exit(); };
if(!isset($_FILES['item_image'])){ http_response_code(400); echo 'item_image required'; exit(); };

  // Validate image extension
$extension = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
$allowedExtensions = ['png', 'gif', 'jpg', 'jpeg','webp'];
if(!in_array($extension, $allowedExtensions )){
  trigger_error('image must be ' .implode(', ', $allowedExtensions));
};  

// Validate image size
if ($_FILES['item_image']['size'] < _ITEM_IMAGE_MIN_SIZE){ http_response_code(400); echo 'item_image size is to small. Minumum size: '. _ITEM_IMAGE_MIN_SIZE / 1000000 . 'mb'; exit(); };
if ($_FILES['item_image']['size'] > _ITEM_IMAGE_MAX_SIZE){ http_response_code(400); echo 'item_image size is to big. Maximum size: '. _ITEM_IMAGE_MAX_SIZE / 1000000  . 'mb'; exit(); };

// unique name for the image  
$uniqueImageName = bin2hex((random_bytes(16)));   // 32 characters
$uniqueImageName .= ".".$extension;


if(strlen($_POST['item_name']) < _ITEM_NAME_MIN_LEN){ http_response_code(400); echo 'item_name min '._ITEM_NAME_MIN_LEN.' characters'; exit(); };
if(strlen($_POST['item_name']) < _ITEM_NAME_MIN_LEN){ http_response_code(400); echo 'item_name min '._ITEM_NAME_MIN_LEN.' characters'; exit(); };
if(strlen($_POST['item_name']) > _ITEM_NAME_MAX_LEN){ http_response_code(400); echo 'item_name max '._ITEM_NAME_MAX_LEN.' characters'; exit(); };
if(strlen($_POST['item_description']) < _ITEM_DESCRIPTION_MIN_LEN){ http_response_code(400); echo 'item_description min '._ITEM_DESCRIPTION_MIN_LEN.' characters'; exit(); };
if(strlen($_POST['item_description']) > _ITEM_DESCRIPTION_MAX_LEN){ http_response_code(400); echo 'item_description max '._ITEM_DESCRIPTION_MAX_LEN.' characters'; exit(); };
if(strlen($_POST['item_price']) < _ITEM_PRICE_MIN_LEN){ http_response_code(400); echo 'item_price min '._ITEM_PRICE_MIN_LEN.' characters'; exit(); };
if(strlen($_POST['item_price']) > _ITEM_PRICE_MAX_LEN){ http_response_code(400); echo 'item_price min '._ITEM_PRICE_MAX_LEN.' characters'; exit(); };

// Connect to the database
$db = _db();

try{
  
  $q = $db->prepare(' UPDATE items SET item_name=:item_name, item_description=:item_description, item_price=:item_price, item_image_name=:item_image_name  WHERE item_id = :item_id');
  $q->bindValue(':item_id', $itemID);
  $q->bindValue(':item_name', $_POST['item_name']);
  $q->bindValue(':item_description', $_POST['item_description']);
  $q->bindValue(':item_price', $_POST['item_price']);
  $q->bindValue(':item_image_name', $uniqueImageName);
  $q->execute();

  // move the temporal image to the final destination
  $destinationFolder = __DIR__.'/../media/items_images/';
  $finalPath = $destinationFolder.$uniqueImageName;
  move_uploaded_file($_FILES['item_image']['tmp_name'], $finalPath);

  // Success
  $response = ["info" => "Item successfuly uploaded", "itemID" => $itemID];
  echo json_encode($response);
 
}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance '.__LINE__;
  exit();
}


