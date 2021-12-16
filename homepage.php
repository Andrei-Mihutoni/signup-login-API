<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../css/homepage.css">
</head>
<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
// $_title = 'Welcome';
// require_once(__DIR__ . '/components/header.php');
?>

<body>

    <main>
        <header>
            <nav>
                <a href="logout.php">Logout</a>
            </nav>
            <h1>
                <?php
                echo 'Welcome ', $_SESSION['first_name'];
                ?>
            </h1>
            <a href="upload-item.php">Upload item</a>
            <a href="user-profile.php">Profile</a>
            <a href="update-user.php">Update Profile</a>
        </header>

        <?php
        require_once(__DIR__ . '/globals/globals.php');
        // Connect to DB
        $db = _db();
        try {

            // Get data in the DB
            $query = $db->prepare('SELECT * FROM items');
            $query->execute();
            $itemsData = $query->fetchAll();

            // SUCCESS
            // $response = ["info" => "Account updated"];
            // echo json_encode($response);
        } catch (Exception $ex) {
            http_response_code(500);
            echo 'System under maintainance';
            echo $ex;
            exit();
        }
        ?>

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


