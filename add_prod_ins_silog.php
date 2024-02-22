<?php
include_once("connection.php");

if(isset($_POST['add-product'])){
    //Variables
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price']; 
    $prod_type = $_POST['food'];

    //for image
    $prod_img_name = $_FILES['prod_img']['name'];
    $prod_temp_img_name = $_FILES['prod_img']['tmp_name'];
    $prod_img_size = $_FILES['prod_img']['size'];

    $prod_img_dir = "images/product/";
    $prod_imgExt = strtolower(pathinfo($prod_img_name, PATHINFO_EXTENSION));
    $prod_valid_ext = array('jpeg', 'jpg', 'png', 'gif', 'jfif');
    $prod_newname = rand(1000,1000000000) . "." . $prod_imgExt;
    $prod_fpath = $prod_img_dir . $prod_newname;

    // Check if the product already exists
    $checkProductNameQuery = $conn->prepare("SELECT COUNT(*) FROM products WHERE prod_name = :pname");
    $checkProductNameQuery->bindParam(':pname', $prod_name);
    $checkProductNameQuery->execute();
    $ProductnameCount = $checkProductNameQuery->fetchColumn();


    if($ProductnameCount > 0){
        echo "<script>alert('Product name already exists. Please check carefully.')</script>";
        echo "<script>window.open('silog_s.php','_self')</script>";
    } else {

        $arr1 = array(":pname", ":pprice", ":pfood", ":pimg", ":ploc");
        $arr2 = array($prod_name, $prod_price, $prod_type, $prod_newname, $prod_fpath);

        //image validation
        if(in_array($prod_imgExt, $prod_valid_ext)){
            if ($prod_img_size < 5000000){
                move_uploaded_file($prod_temp_img_name, $prod_img_dir. $prod_newname);

                $query = $conn->prepare("INSERT INTO products (prod_name, prod_price, prod_type, prod_pic, prod_loc) VALUES (:pname, :pprice, :pfood, :pimg, :ploc)");
                
                for ($x = 0; $x < count($arr1); $x++) {
                    $query->bindParam($arr1[$x], $arr2[$x]);
                }

                $query->execute();
                
                echo "<script>alert('Ang galing love you. Pumasok!')</script>";
                echo "<script>window.open('silog_s.php','_self')</script>";
            } else {
                echo "<script>alert('Invalid filesize. The maximum filesie=ze is 5mb.')</script>";
                echo "<script>window.open('silog_s.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid filetype. Please use jpeg, jpg, png, and gif.')</script>";
            echo "<script>window.open('silog_s.php','_self')</script>";
        }
        
    }
}

?>




