<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");
      }
    require_once "./entities/product.class.php";
    require_once "./entities/category.class.php";
    if(isset($_POST["btnsubmit"])){

        $productName = $_POST["txtName"];
        $cateID = $_POST["txtCateID"];
        $price = $_POST["txtPrice"];
        $quantity = $_POST["txtQuantity"];
        $description = $_POST["txtdesc"];
        $picture = $_FILES["txtpic"];
        
        $newProduct = new Product($productName, $cateID, $price, $quantity, $description, $picture);

        $result = $newProduct->save();
        if(!$result){
            header("Location: add_product.php?failure");
        }
        else{
            header("Location: home-admin.php");
        }
    }
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<form method="post" name="formAdd" onsubmit="return validateForm()" class="form-style-7" enctype="multipart/form-data" >
<h1>ADD NEW PRODUCT</h1>
    <ul>
        <li>
            <label>Product Name</label>
            <input  type="text" name="txtName" maxlength="100" value="<?php echo isset($_POST["txtName"]) ? $_POST["txtName"] : ""; ?> ">
        </li>
        <li>
            <label>Quantity</label>
            <input  type="text" name="txtQuantity" maxlength="100" value="<?php echo isset($_POST["txtQuantity"]) ? $_POST["txtQuantity"] : ""; ?> ">
        </li>
        <li>
            <label>Price</label>
            <input  type="text" name="txtPrice" maxlength="100" value="<?php echo isset($_POST["txtPrice"]) ? $_POST["txtPrice"] : ""; ?> ">
        </li>
        <li>
            <label>Type</label>
            <select style="color:#75787e" name="txtCateID" value="<?php echo isset($_POST["txtCateID"]) ? $_POST["txtCateID"] : ""; ?> ">
                <option value="" selected>Choose category ...</option>
                <?php 
                    $cates = Category::list_category();
                    foreach ($cates as $item){
                        echo "<option value=".$item["CateID"].">".$item["CategoryName"]."</option>";
                    }
                ?>
            </select>
        </li>
        <li>
            <label>Picture</label>
            <input  style="margin-left:-3rem;font-size: 0.8rem;color:#75787e" type="file"  id="txtpic" name="txtpic" accept=".PNG,.GIF,.JPG">
        </li>
        <li>
            <label>Description</label>
            <input  type="text" name="txtdesc" maxlength="100" value="<?php echo isset($_POST["txtdesc"]) ? $_POST["txtdesc"] : ""; ?> "/>
        </li>
        <?php 
            if(isset($_GET["inserted"])){
                echo "<script type='text/javascript'>alert('Sucessfull!')</script>";
                hear("Location: home-admin.php");
            }
            if(isset($_GET["failure"])){
                echo "<script type='text/javascript'>alert('Wrong!')</script>";
            }
        ?>
        <li>
            <input type="submit" name="btnsubmit" class="btn btn-primary" value="Add" >
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
	border-radius:10px;
	padding:20px;
	font-family: Georgia, "Times New Roman", Times, serif;
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
</body>
</html>