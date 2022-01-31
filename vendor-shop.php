<?php
$_title = 'Vendor shop';
require_once(__DIR__ . '/components/header.php');
?>
<?php
$vendorData = json_decode(file_get_contents("txt-files/vendor-shop.txt"), true);
?>
<main>
    <button id="refresh-vendor" onclick="runTsv()" onsubmit="">Refresh vendor items</button>
    <div class="row">
        <?php foreach ($vendorData as $item) : ?>
            <div id="items-container">
                <article id="item-card">
                    <a class="item-link" href="">
                        <img class="item-image" src='https://coderspage.com/2021-F-Web-Dev-Images/<?= $item["image"]; ?>' alt="item image">
                        <div class="item-details">
                        <h3><?= $item['tittle_en'] ?></h3>
                        <!-- <h4><?= $item['description_en']; ?></h4> -->
                        <h4><span class="price-span"><?= ($item['price']); ?> dkk</span></h4>
                        </div>
                    </a>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</main>

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