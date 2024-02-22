<?php
include_once("connection.php");

if(isset($_GET["id"])){
    $id = $_GET["id"];
} else {
    echo "mali"; 
    exit;
}

$sql = "SELECT * FROM products WHERE id = :cid";
$SelectStatement = $conn->prepare($sql);
$SelectStatement->execute([':cid' => $id]);
$User = $SelectStatement->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['prod_name'])){
    // Variables
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price']; 
    $prod_type = $_POST['food'];

    // For image
    $prod_img_name = $_FILES['prod_img']['name'];
    $prod_temp_img_name = $_FILES['prod_img']['tmp_name'];
    $prod_img_size = $_FILES['prod_img']['size'];

    $prod_img_dir = "images/product/";
    $prod_imgExt = strtolower(pathinfo($prod_img_name, PATHINFO_EXTENSION));
    $prod_valid_ext = array('jpeg', 'jpg', 'png', 'gif', 'jfif');
    $prod_newname = rand(1000,1000000000) . "." . $prod_imgExt;
    $prod_fpath = $prod_img_dir . $prod_newname;

    // Check if the product already exists
    $checkProductNameQuery = $conn->prepare("SELECT COUNT(*) FROM products WHERE prod_name = :pname AND id != :cid");
    $checkProductNameQuery->bindParam(':pname', $prod_name);
    $checkProductNameQuery->bindParam(':cid', $id);
    $checkProductNameQuery->execute();
    $ProductnameCount = $checkProductNameQuery->fetchColumn();

    if($ProductnameCount > 0){
        echo "<script>alert('Product name already exists. Please check carefully.')</script>";
        echo "<script>window.open('seller.php','_self')</script>";
    } else {
        // Image validation
        if(in_array($prod_imgExt, $prod_valid_ext)){
            if ($prod_img_size < 5000000){
                move_uploaded_file($prod_temp_img_name, $prod_img_dir . $prod_newname);

                // Use UPDATE statement to update the fields
                $updateQuery = $conn->prepare("UPDATE products SET prod_name = :pname, prod_price = :pprice, prod_type = :pfood, prod_pic = :pimg, prod_loc = :ploc WHERE id = :cid");

                // Bind parameters
                $updateQuery->bindParam(':pname', $prod_name);
                $updateQuery->bindParam(':pprice', $prod_price);
                $updateQuery->bindParam(':pfood', $prod_type);
                $updateQuery->bindParam(':pimg', $prod_newname);
                $updateQuery->bindParam(':ploc', $prod_fpath);
                $updateQuery->bindParam(':cid', $id);

                // Execute the update query
                $updateQuery->execute();

                echo "<script>alert('Product updated successfully.')</script>";
                echo "<script>window.open('seller.php','_self')</script>";
            } else {
                echo "<script>alert('Invalid filesize. The maximum filesize is 5mb.')</script>";
                echo "<script>window.open('seller.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid filetype. Please use jpeg, jpg, png, and gif.')</script>";
            echo "<script>window.open('seller.php','_self')</script>";
        }
    }
}
?>



<link rel="stylesheet" href="design/edit_product.css" />

<form method="post" enctype="multipart/form-data">
    <div id="edit-product_modal" class="edit_product">
        <div class="modal-content">
            <div class="modal-left">
                <img id="panda" src="images/panda3.jpg" alt="Panda">
            </div>

            <div class="modal-right">
                <span id="x-button4" class="close-button">&times;</span>
                <div id="edit_prod-title">EDIT PRODUCT</div>

                <div class="description">Name</div>
                <div class="input-container">
                    <input value="<?php echo $User[0]->prod_name; ?>" type="text" placeholder="Enter name" name="prod_name" id="name_product" required>
                </div>

                <div class="description">Price</div>
                <div class="input-container">
                    <input value="<?php echo $User[0]->prod_price; ?>" type="number" placeholder="Enter price" name="prod_price" id="price_product" required>
                </div>

                <div class="description">Type</div>
                <div class="input-container">
                    <input type="radio" id="meal" name="food" class="radio_btn" value="Silog Meal" <?php echo ($User[0]->prod_type == 'Silog Meal') ? 'checked' : ''; ?> required>
                    <label for="meal" id="meals" class="type_button">Silog Meal</label> 
                    
                    <input type="radio" id="snack" name="food" class="radio_btn" value="Snack" <?php echo ($User[0]->prod_type == 'Snack') ? 'checked' : ''; ?> required>
                    <label for="snack" id="snack" class="type_button">Snack</label>

                    <input type="radio" id="drink" name="food" class="radio_btn" value="Drink" <?php echo ($User[0]->prod_type == 'Drink') ? 'checked' : ''; ?> required>
                    <label for="drink" id="drink" class="type_button">Drink</label>

                    <input type="radio" id="additional" name="food" class="radio_btn" value="Additional" <?php echo ($User[0]->prod_type == 'Additional') ? 'checked' : ''; ?> required>
                    <label for="additional" id="additional" class="type_button">Additional</label>
                </div>

                <div class="description">Image</div>
                <div class="input-container">
                    <img id="prod_img" src="<?php echo $User[0]->prod_loc; ?>" alt="Current Image" height="80" />
                    <input type='file' id="img" name="prod_img" accept="image/*" style="display:none" class="input_box" required/>
                    <label for="img" id="img_button">Choose Image</label>

                </div>

                <input type="submit" name="edit-product" class="edit-product-button" value="Edit Product">
            </div>
        </div>
    </div>
</form>


<script>
        console.log("Script is running");
        var closeModalButton4 = document.getElementById("x-button4");
        closeModalButton4.addEventListener("click", function() {
        window.location.href = "seller.php";
        });
</script>