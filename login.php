<?php
$_title = 'Login';
require_once(__DIR__ . '/components/header.php');
?>

<body>
  <!-- <h1>Login</h1>
    <form onsubmit="return false">
    <input name="email" type="text" placeholder="email">
    <input name="password" type="password" placeholder="password">
    <button onclick="login()">Login</button>
    </form> -->

  <main id="login-main">
    <section id="form-section" class="form-section">
      <div class="logo"></div>

      <fieldset id="form-group" class="form-fieldset">
        <form id="form-login" class="form-group" onsubmit="return false">
          <p id="after-validation-p"></p>
          <h1>Log-in</h1>
          <div id="response"></div>
          <label for="email">Email</label>
          <input name="email" type="text" placeholder="" required></input>

          <label for="password">Password</label>
          <input name="password" type="password" placeholder="password" required>

          <button id="signup-btn" class="yellow-btn" onclick="login()">Continue</button>
        </form>

        <div id="legalTextRow" class="a-row">
          By creating an account, you agree to Amazon's <a href="/gp/help/customer/display.html/ref=ap_register_notification_condition_of_use?ie=UTF8&amp;nodeId=508088">Conditions of Use</a> and <a href="/gp/help/customer/display.html/ref=ap_register_notification_privacy_notice?ie=UTF8&amp;nodeId=468496">Privacy Notice</a>.
        </div>



        <div class="a-row">
          Don't have an account?
          <a class="a-link-emphasis" href="signup.php">
            Sign up
          </a>

          <div class="a-row">
            Forgot your password?
            <a class="a-link-emphasis" href="pwd_reset_send_email.php">
              Click here
            </a>
          </div>
      </fieldset>

    </section>



  </main>







  <script>
    async function login() {
      const form = event.target.form
      // console.log(form)
      let conn = await fetch("../apis/api-login.php", {
        method: "POST",
        body: new FormData(form)
      })
      let response = await conn.json()
      console.log(response)
      document.querySelector("#response").textContent = response.info;

      if (conn.ok) {
        location.href = "products.php"
      }
    };
  </script>
</body>

</html>