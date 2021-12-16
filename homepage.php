<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
$_title = 'Amazon';
require_once(__DIR__ . '/components/header.php');
echo '<h1> Welcome </h1> ', $_SESSION['first_name'];
?>

<body>
    <main>
        <?php require_once(__DIR__ . '/globals/fetch-items.php'); ?>

        <div class="row">
            <?php foreach ($itemsData as $item) : ?>
                <div id="items-container">
                    <article id="item-card">
                        <a class="item-link" href="item.php?id=<?= $item['item_id'] ?>&name=<?= $item['item_name'] ?>">
                            <img class="item-image" src="media/items_images/<?= $item['item_image_name']; ?>" alt="item image">
                            <h3><?= ($item['item_name']); ?></h3>
                            <!-- <h4><?= ($item['item_description']); ?></h4> -->
                            <h4><?= ($item['item_price']); ?> dkk</h4>
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