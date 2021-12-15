<?php

define('_PASSW0RD_REQUIRED', 1);
define('_PASSW0RD_MIN_LEN', 6);
define('_PASSW0RD_MAX_LEN', 20);
define('_ITEM_NAME_MIN_LEN', 2);
define('_ITEM_NAME_MAX_LEN', 20);
define('_ITEM_DESCRIPTION_MIN_LEN', 5);
define('_ITEM_DESCRIPTION_MAX_LEN', 500);
define('_ITEM_PRICE_MIN_LEN', 1);
define('_ITEM_PRICE_MAX_LEN', 6);
define('_ITEM_IMAGE_MIN_SIZE', 1024);   // 1kb
define('_ITEM_IMAGE_MAX_SIZE', 5242881); // 5mb 


// ##############################
function _res($status = 200, $message = [])
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($message);
  exit();
}


// ###########   DB connection ###################
try {
  function _db()
  {
    $database_user_name = 'root';
    $database_pasword = '';
    $database_connection = 'mysql:host=localhost; dbname=company; charset=utf8mb4';

    $database_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    return new PDO($database_connection, $database_user_name, $database_pasword, $database_options);
  }
} catch (PDOException $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo '{"info":"uppps... cannot connect to db"}';
  exit();
}
