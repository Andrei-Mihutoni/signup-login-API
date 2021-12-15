<?php
$_title = 'Upload Item';
require_once(__DIR__ . '/components/header.php');
?>

<body>
  <fieldset id="form-group" class="form-fieldset">
    <!-- <form onsubmit="validate(upload_item); return false"> -->
    <form onsubmit="return false">
      <div class="form-input-name-group">
        <label for="item_name">Item name</label>
        <input name="item_name" type="text" data-validate="str" data-min="2" data-max="20">
      </div>
      <div class="form-input-name-group">
        <label for="item_description">Description</label>
        <textarea id="item_description" name="item_description" rows="4" cols="50">
          </textarea>
      </div>
      <div class="form-input-name-group">
        <label for="item_price">Price</label>
        <input name="item_price" type="text" data-validate="int" data-min="1" data-max="6">
      </div>
      <div class="form-input-name-group">
        <label for="item_image">Item image:</label>
        <input type="file" id="item_image" name="item_image" accept="image/png, image/jpeg, image/webp">
      </div>






      <button id="upload-item-btn" onclick="upload_item()">Upload item</button>

    </form>
  </fieldset>
  <div id="items"></div>
  <script src="validator.js"></script>
  <script>
    async function upload_item() {
      try {
        const form = event.target.form
        // console.log(form)
        let conn = await fetch("../apis/api-upload-item.php", {
          method: "POST",
          body: new FormData(form)
        })
        let response = await conn.json()
        // console.log(response)
        // document.querySelector("#response").textContent = response.info;
      } catch (err) {
        console.error(err);
        alert("System under maintainance");
      }
    };



    // async function upload_item() {
    //   const form = event.target
    //   const item_name = _one("input[name='item_name']", form).value
    //   const conn = await fetch("apis/api-upload-item", {
    //     method: "POST",
    //     body: new FormData(form)
    //   })
    //   const res = await conn.text()
    //   console.log(res)
    //   if (conn.ok) {
    //     _one("#items").insertAdjacentHTML('afterbegin', `
    //     <div class="item">
    //       <div>${res}</div>
    //       <div>${item_name}</div>
    //       <button id="deleteBTN" onclick="deleteItem()" >🗑️</button>
    //     </div>`)
    //   }
    //   _one("input[name='item_name']", form).value = "";

    //   // _one("#deleteBTN").addEventListener('click', deleteItem);
    //   // function deleteItem(e){
    //   //     console.log("delete");
    //   //     let item = e.target.parentNode;
    //   //     item.remove();

    //   // }
    // }
  </script>
</body>

</html>