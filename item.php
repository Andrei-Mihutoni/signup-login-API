<?php
$_title = 'Item';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/globals/globals.php');


if (!isset($_GET['id'])) {
    echo "this article is missing. Please go back and try another one";
    exit();
} else {
    $_SESSION['itemID'] = $_GET['id'];
    $_SESSION['img_name'] = $_GET['img_name'];
    // echo $_SESSION['img_name'];

    // Connect to DB
    $db = _db();
    try {
        // Get data in the DB
        $query = $db->prepare('SELECT * FROM items WHERE item_id = :item_id ');
        $query->bindValue(':item_id', $_GET['id']);
        $query->execute();
        $itemData = $query->fetchAll();

        // SUCCESS
        // echo json_encode($itemData);

        $response = ["info" => "Item refreshed"];
        // echo json_encode($response);
    } catch (Exception $ex) {
        http_response_code(500);
        echo 'System under maintainance';
        echo $ex;
        exit();
    }
}
?>

<div class="row">
    <?php foreach ($itemData as $item) : ?>
        <div id="items-container">
                    <article id="item-card">
                        <div class="item-link" href="item.php?id=<?= $item['item_id'] ?>&name=<?= $item['item_name'] ?>">
                            <img class="item-image" src="media/items_images/<?= $item['item_image_name']; ?>" alt="item image">
                            <div class="item-details">
                            <h3><?= ($item['item_name']); ?></h3>
                            <!-- <h4><?= ($item['item_description']); ?></h4> -->
                            <h4><?= ($item['item_price']); ?> dkk</h4>
                            </div>
                        </div>
                    </article>
                </div>
    <?php endforeach; ?>
</div>


<main>
    <fieldset id="form-group" class="form-fieldset">
        <form id="upload-item-form" onsubmit="validate(update_item_details); return false"><strong>Fill up all the fields to update the item</strong>
      <div id="response"></div> 
        <div class="form-input-name-group">
                <label for="item_name">New name</label>
                <input name="item_name" type="text" data-validate="str" data-min="2" data-max="20" placeholder="min 2, max 20 characters" required>
            </div>
            <div class="form-input-name-group">
                <label for="item_description">New description</label>
                <textarea id="item_description" name="item_description" data-validate="str" rows="4" cols="50" data-min="5" data-max="500" placeholder="min 5, max 500 characters" required>
          </textarea>
            </div>
            <div class="form-input-name-group">
                <label for="item_price">New price</label>
                <input name="item_price" type="text" data-validate="str" data-min="1" data-max="6" pattern="[0-9]+" placeholder="min 1, max 6 digits" required>
            </div>
            <div class="form-input-name-group">
                <label for="item_image">New Item image:</label>
                <input type="file" id="item_image" name="item_image" accept="image/png, image/jpeg, image/webp" required>
            </div>

            <button id="upload-item-btn" onclick="update_item_details()">Update item details</button>

        </form>
    </fieldset>

    <script src="./scripts/validator.js"></script>
    <script>
        async function update_item_details() {
            try {
                const form = event.target.form
                let conn = await fetch("../apis/api-update-item-details.php", {
                    method: "POST",
                    body: new FormData(form)
                })
                let response = await conn.json()
                console.log(response)
                document.querySelector("#response").textContent = response.info;
                if(conn.status == 200){
          setTimeout(() => {
            // location.reload();
            location.href="homepage.php";
          }, 500);
        }
            
            } catch (err) {
                console.error(err);
                // alert("Please fill in all the item details");
            }
        };
    </script>


</main>