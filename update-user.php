<?php
$_title = 'Signup';
require_once(__DIR__ . '/components/header.php');
session_start();
?>

<main id="update-main" class="update-main">
    <section id="form-section" class="form-section">
        <div class="logo">
            <!-- <img id="amazon-logo"src="media/amazon_logo.png" alt="amazon logo"> -->
        </div>

        <fieldset id="form-group" class="form-fieldset">
            <form id="form-sign-up" class="form-group" onsubmit="return false">
                <h1>Update user profile</h1>
                <div id="response"></div>
                <label for="first_name">First name: <?= ($_SESSION['first_name']) ?></label>
                <h6>new first name:</h6>
                <input name="first_name" type="text" placeholder="at least 2 characters" minlength="2" maxlength="30" required></input>

                <label for="last_name">Last name: <?= ($_SESSION['last_name']) ?></label>
                <h6>new last name:</h6>
                <input name="last_name" type="text" placeholder="at least 2 characters" minlength="2" maxlength="30" required></input>

                <label for="phone_number">Phone number: <?= ($_SESSION['phone_number']) ?></label>
                <h6>new phone number:</h6>
                <input name="phone_number" type="tel" placeholder="danish phone number, 8 numbers" required></input>

                <label for="email">Email: <?= ($_SESSION['email']) ?></label>
                <h6>new email:</h6>
                <input name="email" type="email" placeholder="" pattern=""></input>

                <!-- <label for="password">Password</label>
                <input name="password" type="password" minlength="6" maxlength="20" placeholder="At least 6 characters"></input>

                <label for="re-password">Re-enter password</label>
                <input name="re-password" type="password" minlength="6" maxlength="20" placeholder=""></input> -->

                <button id="signup-btn" class="yellow-btn" onclick="updateProfile()">Update</button>
            </form>





            <div class="a-row">
                For password reset
                <a class="a-link-emphasis" href="pwd_reset_send_email.php"> Click here </a>
            </div>
        </fieldset>

    </section>



</main>


<script>
    async function updateProfile() {
        let conn = await fetch("../apis/api-update-user.php", {
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