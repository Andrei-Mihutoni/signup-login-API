<?php
$_title = 'Reset pasword';
require_once(__DIR__ . '/components/header.php');
?>

<body>
  <!-- ######### TO DO - frontend validation -->

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

          <!-- <label for="password">Password</label>
        <input name="password" type="password" placeholder="password" required> -->

          <button id="signup-btn" class="yellow-btn nav-action-button" onclick="pwd_reset_send_email()">Continue</button>
        </form>

        <div class="a-row">
          Already have an account?
          <a class="a-link-emphasis" href="login.php">
            Log In
          </a> or <a class="a-link-emphasis" href="signup.php">
            Sign up
          </a>

      </fieldset>
    </section>
  </main>







  <script>
    async function pwd_reset_send_email() {
      const form = event.target.form
      let conn = await fetch("apis/api-pwd-reset-send-email.php", {
        method: "POST",
        body: new FormData(form)
      })
      let response = await conn.json()
      console.log(response)
      document.querySelector("#response").textContent = response.info;

      if (conn.ok) {
        document.querySelector("#response").textContent = response.info;
      }
    };
  </script>
</body>

</html>