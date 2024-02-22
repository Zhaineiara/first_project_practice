
<form action="add_prod_ins_seller.php" method="post" enctype="multipart/form-data">
    <div id="add-product_modal" class="add_product">
        <div class="modal-content">
            <div class="modal-left">
                <img id="panda" src="images/panda3.jpg" alt="Panda">
            </div>

            <div class="modal-right">
                <span id="x-button3" class="close-button">&times;</span>
                <div id="add_prod-title">PRODUCT</div>
                                
                <div class="description">Name</div>
                <div class="input-container">
                    <input type="text" placeholder="Enter name" name="prod_name" id ="name_product" required>
                </div>

                <div class="description">Price</div>
                <div class="input-container">
                    <input type="number" placeholder="Enter price" name="prod_price" id ="price_product" required>
                </div>

                <div class="description">Type</div>
                <div class="input-container">
                    <input type="radio" id="meal" name="food" class="radio_btn" value="Silog Meal" required>
                    <label for="meal" id="meals" class="type_button">Silog Meal</label>

                    <input type="radio" id="snack" name="food" class="radio_btn" value="Snack" required>
                    <label for="snack" id="snack" class="type_button">Snack</label>

                    <input type="radio" id="drink" name="food" class="radio_btn" value="Drink" required>
                    <label for="drink" id="drink" class="type_button">Drink</label>

                    <input type="radio" id="additional" name="food" class="radio_btn" value="Additional" required>
                    <label for="additional" id="additional" class="type_button">Additional</label>
                </div>

                <div class="description">Image</div>
                <div class="input-container">
                    <input type='file' id="img" name= "prod_img" accept= image/* style="display:none" class="input_box" required/>
                    <label for="img" id="img_button">Choose Image</label>
                </div>

                <input type="submit" name="add-product" class="add-product-button" value="Add Product">
            </div>                
        </div>
    </div>
</form>
