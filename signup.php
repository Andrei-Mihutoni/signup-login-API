<?php
$_title = 'Signup';
require_once(__DIR__ . '/components/header.php');
?>

<main id="signup-main" class="signup-main">
  <section id="form-section" class="form-section">
    <div class="logo">
      <!-- <img id="amazon-logo"src="media/amazon_logo.png" alt="amazon logo"> -->
    </div>

    <fieldset id="form-group" class="form-fieldset">
      <form id="form-sign-up" class="form-group" onsubmit="return false">
        <h1>Create account</h1>
        <div id="response"></div>
        <label for="first_name">First name</label>
        <input name="first_name" type="text" placeholder="at least 2 characters" required></input>

        <label for="last_name">Last name</label>
        <input name="last_name" type="text" placeholder="at least 2 characters" required></input>

        <label for="phone_number">Phone number</label>
        <input name="phone_number" type="tel" placeholder="danish phone number, 8 numbers" required></input>

        <label for="email">Email</label>

        <input name="email" type="email" placeholder="" pattern=""></input>

        <label for="password">Password</label>
        <input name="password" type="text" placeholder="At least 6 characters"></input>

        <label for="re-password">Re-enter password</label>
        <input name="re-password" type="text" placeholder=""></input>

        <button id="signup-btn" class="yellow-btn" onclick="signUp()">Create your Amazon account</button>
      </form>

      <div id="legalTextRow" class="a-row">
        By creating an account, you agree to Amazon's <a href="/gp/help/customer/display.html/ref=ap_register_notification_condition_of_use?ie=UTF8&amp;nodeId=508088">Conditions of Use</a> and <a href="/gp/help/customer/display.html/ref=ap_register_notification_privacy_notice?ie=UTF8&amp;nodeId=468496">Privacy Notice</a>.
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
  async function signUp() {
    let conn = await fetch("../apis/api-signup.php", {
      method: "POST",
      body: new FormData(document.querySelector("#form-sign-up"))
    })
    let response = await conn.json();
    console.log(response);
    document.querySelector("#response").textContent = response.info;
  }
</script>



<?php
require_once(__DIR__ . '/components/footer.php');

?>