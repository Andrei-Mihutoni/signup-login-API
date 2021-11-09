<?php

define('_PASSW0RD_REQUIRED', 1);
define('_PASSW0RD_MIN_LEN', 6);
define('_PASSW0RD_MAX_LEN', 20);


// ##############################
function _res( $status=200, $message=[] ){
  http_response_code($status); 
  header('Content-Type: application/json'); 
  echo json_encode($message); 
  exit();
}


// ##############################
try{
  function _db(){
    $database_user_name = 'root';
    $database_pasword = '';
    $database_connection = 'mysql:host=localhost; dbname=company; charset=utf8mb4';
  
    $database_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    return new PDO( $database_connection, $database_user_name, $database_pasword, $database_options ); 
  }
}catch( PDOException $e){
  http_response_code(500);
  header('Content-Type: application/json');
  echo '{"info":"uppps... cannot connect to db"}';
  exit();
}  

