<?php
$_title = 'Login';
require_once(__DIR__.'/components/header.php');




//  Verify the key (must be 32 characters)
if( ! isset($_GET['key']) ){echo "mmm... suspicious (key is missing)";
  exit();
}
if(strlen($_GET['key']) != 32){echo "mmm... suspicious (key is not 32 chars)";
  exit();
}

// Connect to the db
// $data = json_decode(file_get_contents("data.json"), true);

$db = require_once(__DIR__.'/globals/db.php');
try{
  // select the verification_key from db
  $query = $db->prepare('SELECT * FROM users WHERE verification_key = :verification_key');
  $query->bindValue('verification_key', $_GET['key'] );
  $query->execute();
  $data = $query->fetch();
    // echo json_encode($data)."  on line ".__LINE__." ///  ";

  if( $_GET["key"] != $data["verification_key"] ){echo "mmm... suspicious (keys don't match)";
    exit();
  }

}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}


//  Update the verified to 1 if match
try{
  $query = $db->prepare(' UPDATE users SET verified = 1  WHERE verification_key = :verification_key');
  $query->bindValue(':verification_key', $_GET['key'] );
  $query->execute();
}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}

// Reseting the verification key
try{
  $query = $db->prepare(' UPDATE users SET verification_key = :verification_key2  WHERE verification_key = :verification_key');
  $query->bindValue(':verification_key', $_GET['key'] );
  $verification_key = bin2hex(random_bytes(16));
  $query->bindValue(':verification_key2', $verification_key);
  $query->execute();
  $data = $query->fetch();
  // echo json_encode($data);
}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}





// Verification success. Say Congrats to the user and give a link to the log in page
$name = $_GET['name'];
echo "<div id='center-flex-row'><h2>CONGRATS $name ... your email is now verified.</h2>
<h2> <a href='http://localhost/login.php'> 
Click here to log in. 
</a></div>";
