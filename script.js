

async function login() {
    const form = event.target.form;
    console.log(form)
    let conn = await fetch("api-login.php", {
        method: "POST",
        body: new FormData(form)
    })
    let res = await conn.json();
    console.log(res);
    if (conn.ok) {
        location.href = "user.php"

    }
}
