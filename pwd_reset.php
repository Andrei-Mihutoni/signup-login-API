<?php
$_title = 'Reset pasword';
require_once(__DIR__ . '/components/header.php');
?>


<?php

//  Verify the key (must be 32 characters)
if (!isset($_GET['pwd_reset_key'])) {
  echo "mmm... suspicious (key is missing)";
  exit();
}
if (strlen($_GET['pwd_reset_key']) != 32) {
  echo "mmm... suspicious (key is not 32 chars)";
  exit();
}

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





/// ######   TO DO 

// Connect to DB
$db = _db();

try {
  // Checks the password from DB against the one from the mail
  $query = $db->prepare(' SELECT * FROM users');
  $query->execute();
  $row = $query->fetch();
  // echo json_encode($row['pwd_reset_key']);
  // echo json_encode($_GET['pwd_reset_key']);
  if ($row['pwd_reset_key'] !== $_GET['pwd_reset_key']) {
    echo "mmm... it looks like you are tring to reset your password from an old email.  If you still need to reset your password, <a href='http://localhost/pwd_reset_send_email.php'> 
    Click here. 
    </a>";
    exit();
  };
} catch (Exception $ex) {
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}



?>



<body>


  <main id="login-main">
    <section id="form-section" class="form-section">
      <div class="logo"></div>
      <fieldset id="form-group" class="form-fieldset">
        <form id="form-login" class="form-group" onsubmit="return false">
          <p id="after-validation-p"></p>
          <h1>Password reset</h1>
          <div id="response"></div>
          <label for="email">Email</label>
          <input name="email" type="text" placeholder="" required></input>


          <label for="password">New password</label>
          <input name="password" type="text" placeholder="At least 6 characters"></input>

          <label for="re-password">Re-enter new password</label>
          <input name="re-password" type="text" placeholder=""></input>

          <!-- <label for="password">Password</label>
        <input name="password" type="password" placeholder="password" required> -->

          <button id="signup-btn" class="yellow-btn nav-action-button" onclick="reset_pwd()">Continue</button>
        </form>





        <div class="a-row">
          Dont't have an account?
          <a class="a-link-emphasis" href="signup.php">
            Sign-up
          </a>

        </div>
        <div class="a-row">
          Already have an account?
          <a class="a-link-emphasis" href="login.php">
            Login
          </a>
        </div>
      </fieldset>

    </section>



  </main>







  <script>
    async function reset_pwd() {
      const form = event.target.form
      let conn = await fetch("apis/api-pwd-reset.php", {
        method: "POST",
        body: new FormData(form)
      })
      let response = await conn.json()
      console.log(response)
      document.querySelector("#response").textContent = response.info;
      if (conn.ok) {
        setTimeout(() => {
          {
            location.href = "login.php"
          }

        }, 5000);

      }
    };
  </script>
</body>

</html>