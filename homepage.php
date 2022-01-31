<?php
$_title = 'Amazon';
require_once(__DIR__ . '/components/header.php');
?>

<body>
    <main>
        <?php require_once(__DIR__ . '/globals/fetch-items.php'); ?>

        <div class="row">
            <?php foreach ($itemsData as $item) : ?>
                <div id="items-container">
                    <article id="item-card">
                        <a class="item-link" href="item.php?id=<?= $item['item_id'] ?>&name=<?= $item['item_name'] ?>&img_name=<?= $item['item_image_name']?>">
                            <img class="item-image" src="media/items_images/<?= $item['item_image_name']; ?>" alt="item image">
                            <div class="item-details">
                            <h3><?= ($item['item_name']); ?></h3>
                            <h4><?= ($item['item_description']); ?></h4>
                            <h4><span class="price-span"><?= ($item['item_price']); ?> dkk</span></h4>
                            </div>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        require_once(__DIR__ . '/upload-item.php');
        ?>
    </main>
</body>

</html>