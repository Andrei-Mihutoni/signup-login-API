<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
$_title = 'Vendor shop';
require_once(__DIR__ . '/components/header.php');
?>

<?php
// include(__DIR__.'/globals/tsv-parser.php');
// require_once(__DIR__.'/globals/tsv-parser.php');
$vendorData = json_decode(file_get_contents("txt-files/vendor-shop.txt"), true);
?>
<button onclick="runTsv()" onsubmit="">Refresh vendor items</button>
<div class="row">
    <?php foreach ($vendorData as $item) : ?>
        <div id="items-container">
            <article id="item-card">
                <a class="item-link" href="">
                    <img class="item-image" src='https://coderspage.com/2021-F-Web-Dev-Images/<?= $item["image"]; ?>' alt="item image">
                    <h3><?= $item['tittle_en'] ?></h3>
                    <!-- <h4><?= ($item['description']); ?></h4> -->
                    <h4><?= ($item['price']); ?> dkk</h4>
                </a>
            </article>
        </div>
    <?php endforeach; ?>
</div>




<script>
    async function runTsv() {
        let conn = await fetch("../globals/tsv-parser.php", {
            method: "POST",
            body: new FormData()
        })
        let response = await conn.json();
        location.reload();
    }
</script>
</body>

</html>