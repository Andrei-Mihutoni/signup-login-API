<?php
$_title = 'Signup';
require_once('components/header.php');
?>
    <h1>Signup</h1>
    <form id="form-sign-up" onsubmit="return false">
<input name="name" type="text" placeholder="name"></input>
<input name="lastName" type="text" placeholder="last name"></input>
<input name="email" type="text" placeholder="email"></input>
<button onclick="signUp()">Signup</button>
</form>

<script>
  async function signUp(){
    let conn = await fetch("api-signup.php", {
      method : "POST",
      body : new FormData(document.querySelector("#form-sign-up"))
    })
    let response = await conn.json()
    console.log(response)
  }
</script>



    <?php
require_once('components/footer.php');

    ?>
