<body>
  <main>
    <fieldset id="form-group" class="form-fieldset">
      <!-- <form onsubmit="validate(upload_item); return false"> -->
        <h3>Upload a new item</h3>
      <form id="upload-item-form" onsubmit="return false">
      <div id="response"></div>
        <div class="form-input-name-group">
          <label for="item_name">Item name</label>
          <input name="item_name" type="text" data-validate="str" data-min="2" data-max="20" required>
        </div>
        <div class="form-input-name-group">
          <label for="item_description">Description</label>
          <textarea id="item_description" name="item_description" rows="4" cols="50" required>
          </textarea>
        </div>
        <div class="form-input-name-group">
          <label for="item_price">Price</label>
          <input name="item_price" type="text" data-validate="int" data-min="1" data-max="6" required>
        </div>
        <div class="form-input-name-group">
          <label for="item_image">Item image:</label>
          <input type="file" id="item_image" name="item_image" accept="image/png, image/jpeg, image/webp" required>
        </div>
        <button id="upload-item-btn" onclick="upload_item()">Upload item</button>

      </form>
    </fieldset>
  </main>

  <script src="./scripts/validator.js"></script>
  <script>
    async function upload_item() {
      try {
        const form = event.target.form
        let conn = await fetch("../apis/api-upload-item.php", {
          method: "POST",
          body: new FormData(form)
        })
        let response = await conn.json()
        console.log(response)
        document.querySelector("#response").textContent = response.info;
        if(conn.status == 200){
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      } catch (err) {
        console.error(err);
        // alert("Please fill in all the item details");
      }
    };
  </script>
</body>

</html>