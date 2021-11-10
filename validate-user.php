<?php
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
  $query->bindValue(':verification_key', $_GET['key']);
  $query->execute();
  $data = $query->fetch();


  if( $_GET["key"] != $data["verification_key"] ){echo "mmm... suspicious (keys don't match)";
    exit();
  }

$name = $_GET['name'];


}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}

// echo $json_data->verification_key; // json
// echo $json_data["verification_key"];
//  Update the verified to 1 if match


// $data["verified"] = 1; // Update command
/*
UPDATE users SET verified = 1 WHERE verified_key = "1222"
*/
// TODO: Say Congrats to the user
// file_put_contents("data.json", json_encode($data, JSON_PRETTY_PRINT));
echo "CONGRATS $name ... your account is verified";
?>