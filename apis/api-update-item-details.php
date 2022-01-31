<?php
require_once(__DIR__ . '/../globals/globals.php');
session_start();
// echo $_GET['img_name'];

// // for frontend
$itemID = $_SESSION['itemID'];
$itemImageName = $_SESSION['img_name'];

// for Postman testing
// $itemID = $_GET['id'];
// $itemImageName = $_GET['img_name'];


// Validate the item details
if(!isset($_POST['item_name'])) {send_400('item_name required');};
if(!isset($_POST['item_description'])) {send_400('item_description required');};
if(!isset($_POST['item_price'])) {send_400('item_price required');};
if(!isset($_FILES['item_image'])) {send_400('item_image required');};

if(strlen($_POST['item_name']) < _ITEM_NAME_MIN_LEN){ send_400('item_name min must be '._ITEM_NAME_MIN_LEN.' characters'); };
if(strlen($_POST['item_name']) > _ITEM_NAME_MAX_LEN){ send_400('item_name max must be '._ITEM_NAME_MAX_LEN.' characters'); };
if(strlen($_POST['item_description']) < _ITEM_DESCRIPTION_MIN_LEN){ send_400('item_description must be min '._ITEM_DESCRIPTION_MIN_LEN.' characters');};
if(strlen($_POST['item_description']) > _ITEM_DESCRIPTION_MAX_LEN){ send_400('item_description must be max '._ITEM_DESCRIPTION_MAX_LEN.' characters'); };
if(strlen($_POST['item_price']) < _ITEM_PRICE_MIN_LEN){ send_400('item_price must be min '._ITEM_PRICE_MIN_LEN.' characters'); };
if(strlen($_POST['item_price']) > _ITEM_PRICE_MAX_LEN){ send_400('item_price must be max '._ITEM_PRICE_MAX_LEN.' characters'); };

// Validate image extension
$extension = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
$allowedExtensions = ['png', 'gif', 'jpg', 'jpeg','webp'];
if(!in_array($extension, $allowedExtensions )){
  trigger_error('image must be ' .implode(', ', $allowedExtensions));
};  

// Validate image size
if ($_FILES['item_image']['size'] < _ITEM_IMAGE_MIN_SIZE){ send_400( 'item_image size is to small. Minumum size: '. _ITEM_IMAGE_MIN_SIZE / 1000000 . 'mb'); };
if ($_FILES['item_image']['size'] > _ITEM_IMAGE_MAX_SIZE){ send_400( 'item_image size is to big. Maximum size: '. _ITEM_IMAGE_MAX_SIZE / 1000000  . 'mb'); };

// unique name for the image  
$uniqueImageName = bin2hex((random_bytes(16)));   // 32 characters
$uniqueImageName .= ".".$extension;



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
  $response = ["info" => "Item successfuly uploaded"];
  echo json_encode($response);

  // Deleting the old item image
  $imagePathToBeDeleted = 'C:/xampp/htdocs/media/items_images/'.$itemImageName;
  
  //fot Postman testing
  // $imagePathToBeDeleted = 'C:/xampp/htdocs/media/items_images/'.$_GET['img_name'];

  unlink($imagePathToBeDeleted);
  
}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance '.__LINE__;
  exit();
}


// function to manage responding in case of an error
function send_400($error_message)
{
  header('Content-Type: application/json');
  http_response_code(400);
  $response = ["info" => $error_message];
  echo json_encode($response);
  exit();
}
