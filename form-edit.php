<?php 
    require_once("./entities/product.class.php");
    require_once("./entities/category.class.php");
?>
<?php 
    if(!isset($_GET["ProductID"])){
        header('Location: not_found.php');
    }
    else{
        $id = $_GET["ProductID"];
        @$prod = reset(Product::get_product($id));
    }
?>
<?php 
    echo '<form action="productController.php?action=edit&ProductID='.$_GET["ProductID"].'"  method="post" class="form-style-7" enctype="multipart/form-data" >';
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<h1>EDIT PRODUCT</h1>
    <ul>
        <li>
            <label>Product Name</label>
            <input type="text" name="txtName" maxlength="100" placeholder="<?php echo $prod["ProductName"] ?>" value="<?php echo isset($_POST["txtName"]) ? $_POST["txtName"] : $prod["ProductName"]; ?>">
        </li>
        <li>
            <label>Quantity</label>
            <input type="text" name="txtQuantity" maxlength="100" placeholder="<?php echo $prod["Quantity"]; ?> " value="<?php echo isset($_POST["txtQuantity"]) ? $_POST["txtQuantity"] : $prod["Quantity"]; ?>">
        </li>
        <li>
            <label>Price</label>
            <input type="text" name="txtPrice" maxlength="100" placeholder="<?php echo $prod["Price"];?> " value="<?php echo isset($_POST["txtPrice"]) ? $_POST["txtPrice"] : $prod["Price"]; ?>">
        </li>
        <li>
            <label>Type</label>
            <select style="color:#75787e" name="txtCateID" placeholder="<?php echo $prod["CateID"]; ?> " value="<?php echo isset($_POST["txtCateID"]) ? $_POST["txtCateID"] : $prod["CateID"]; ?>">
                <option value="<?php echo $prod["CateID"]; ?>" selected>Choose category ...</option>
                <?php 
                    $cates = Category::list_category();
                    foreach ($cates as $item){
                        echo "<option value=".$item["CateID"].">".$item["CategoryName"]."</option>";
                    }
                ?>
            </select>
        </li>
        <!-- <li>
            <label>Picture</label>
            <input type="file"  id="txtpic" name="txtpic" accept=".PNG,.GIF,.JPG">
            <span>Picture</span>
        </li> -->
        <li>
            <label>Description</label>
            <input type="text" name="txtdesc" maxlength="100" placeholder="<?php echo $prod["Descriptions"];?> " value="<?php echo isset($_POST["txtdesc"]) ? $_POST["txtdesc"] : $prod["Descriptions"]; ?>"/>
        </li>
        <?php 
            if(isset($_GET["inserted"])){
                echo "<script type='text/javascript'>alert('Sucessfull!')</script>";
            }
        ?>
        <li>
            <input type="submit" name="btnsubmit" class="btn btn-primary" value="Edit" >
        </li>
    </ul>
</form>
<style>
body {
  background: #EEE;
  text-align: 'center';
  
}

.form-style-7{
	max-width:800px;
	margin:50px auto;
	background:#fff;
	border-radius:2px;
	padding:20px;
	font-family: Georgia, "Times New Roman", Times, serif;
    border-radius: 30px
}
.form-style-7 h1{
	display: block;
	text-align: center;
	padding: 0;
	margin: 0px 0px 20px 0px;
	color: #5C5C5C;
	font-size:x-large;
}
.form-style-7 ul{
	list-style:none;
	padding:0;
	margin:0;	
}
.form-style-7 li{
	display: block;
	padding: 9px;
	border:1px solid #DDDDDD;
	margin-bottom: 30px;
	border-radius: 3px;
}
.form-style-7 li:last-child{
	border:none;
	margin-bottom: 0px;
	text-align: center;
}
.form-style-7 li > label{
	display: block;
	float: left;
	margin-top: -22px;
	background: #FFFFFF;
	height: 20px;
	padding: 2px 5px 2px 5px;
	color: #B9B9B9;
	font-size: 14px;
	overflow: hidden;
	font-family: Arial, Helvetica, sans-serif;
}
.form-style-7 input[type="text"],
.form-style-7 input[type="number"],
.form-style-7 textarea,
.form-style-7 select 
{
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	width: 100%;
	display: block;
	outline: none;
	border: none;
	height: 25px;
	line-height: 25px;
	font-size: 16px;
	padding: 0;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-7 input[type="text"]:focus,
.form-style-7 textarea:focus,
.form-style-7 select:focus 
{
}
.form-style-7 li > span{
	background: #F3F3F3;
	display: block;
	padding: 3px;
	margin: 0 -9px -9px -9px;
	text-align: center;
	color: #C0C0C0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.form-style-7 textarea{
	resize:none;
}
</style>