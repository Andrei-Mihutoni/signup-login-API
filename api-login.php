<?php

require_once('globals.php');

// Validate the email
if( ! isset($_POST['email'] )) { _res(400, ['info' => 'email required']); };
if( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {_res(400, ['info'=>'email is invalid', 'error on line'=>__LINE__]);};


// Validate the password
// if( ! isset($_POST['password'] )) { _res(400, ['info' => 'password required']); };
// if ( strlen($_POST['password']) < _PASSW0RD_MIN_LEN ) { _res(400, ['info' => 'password too short. Password length shoud be minimum '._PASSW0RD_MIN_LEN.' charachetrs']); };
// if ( strlen($_POST['password']) > _PASSW0RD_MAX_LEN ) { _res(400, ['info' => 'password too long.  Password length shoud be Maximum '._PASSW0RD_MAX_LEN.' charachetrs']); };




try{
    $db = _db();
  }catch(Exception $ex){
    _res(500, ['info'=>'system under maintainance', 'error line'=>__LINE__]);
  }
  
  
  try{
    $q = $db->prepare('SELECT * FROM users WHERE email = :email ');
    $q->bindValue(':email', $_POST['email']);
    $q->execute();
    $row = $q->fetch();
    // var_dump($row);
    // print_r($row);
    // echo json_encode($row);
    var_export($row);
    if(!$row){ _res(400, ['info'=>'wrong credentials', 'error line'=>__LINE__]); }
  
    // Success
    session_start();
    $_SESSION['user_name'] = $row['user_name'];
    _res(200, ['info'=>'success login']);
  
  
  }catch(Exception $ex){
    _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
  }
  
  













// // connect to the db
// try{
// $db = _db();
// }catch(Exception $ex){
//     _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
// }

// try{
// $q = $db->prepare('SELECT * FROM users WHERE email = :email');
// $q->bindValue(':email', $_POST['email']);
// $q->execute();
// $row = $q->fetch();
// // var_dump($row); //see the data from the db
// // print_r($row);//see the data from the db
// // echo json_encode($row);//see the data from the db
// // var_export($row);//see the data from the db
// if(!$row){ _res[400, 'info'=>'wrong credential','error'=>__LINE__]};



// // Expected fake variables
// // $correct_email = 'a@a.com';
// // $correct_password = 'password';

// // if( $correct_email != $_POST['email'] || $correct_password != $_POST['password']){
// //     _res(400, ['info' =>'wrong credential']);
// // }


// //Success
// session_start();
// $_SESSION ['user_name'] = $row['user_name'];
// _res(200, ['info' => 'success login']); 

// }catch(Exception $ex){
//     _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
// }

