<?php 
    require_once("./entities/product.class.php");
    require_once("./entities/category.class.php");
    require_once("./entities/user.class.php");
    require_once("./config/db.class.php");

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors',0);
?>
<?php 
    global $total_money;
    if(isset($_SESSION["customer"])){
        $name = $_SESSION["customer"];
        $cus = reset(User::get_customer($name));
        $Cname = $cus["CustomerName"];
        $Caddress = $cus["CAddress"];
        $Cphone = $cus["Phone"];
        //echo $Caddress;
    }
    if(isset($_POST["btnsubmit"])){
        $customerName = $_POST["txtCustomerName"] ;
        $customerAddress = $_POST["txtCustomerAddress"] ;
        $customerPhoneNumber = $_POST["txtCustomerPhoneNumber"] ;
    if( strcmp($customerName, "") || strcmp($customerAddress, "") || strcmp($customerPhoneNumber, "")){
        echo '<script type="text/javascript">alert("Something blank here!")</script>';
    }
        $total = $_SESSION["totalbilling"];
        $time = date("d")."/".date("m")."/".date("Y");  
        $db = new Db();
        
        $sql = "INSERT INTO orderproduct ( OrderDate, ShipName, ShipAddress, ShipPhone, TotalBilling, StatusID) VALUES 
        ('$time','$customerName','$customerAddress','$customerPhoneNumber','$total','1')";
        $db->query_execute($sql);

        $sql_get_OrdeID ="SELECT * FROM orderproduct ORDER BY OrderID DESC LIMIT 1;";
        $result = $db->select_to_array($sql_get_OrdeID);
        foreach ($result as $item){
            //echo $item["OrderID"];
            $orderID = $item["OrderID"];
        }
        foreach($_SESSION["cart_items"] as $item){
            global $orderID;
            $id = $item["pro_id"];
            $quantity = $item["quantity"];
            // $product = Product::get_product($id);
            // $prod = reset($product);
            //echo $item["quantity"];
            $sql = "INSERT INTO orderdetail (OrderID ,ProductID, Quantity) VALUES 
            ('$orderID','$id','$quantity')";

            $db->query_execute($sql);

        }
        session_start();
        unset($_SESSION["cart_items"]);
        header("Location: index.php");

    }
    global $Cname, $Caddress,$Cphone;
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<form action="" class="form-style-7" method="post">
<ul>
        <li>
            <label>Your Name</label>
            <input required type="text" name="txtCustomerName" maxlength="100" value="<?php echo isset($_POST["txtCustomerName"]) ? $_POST["txtCustomerName"] : isset($Cname)? $Cname: ""; ?> ">
        </li>
        <li>
            <label>Your Address</label>
            <input required type="text" name="txtCustomerAddress" maxlength="100" value="<?php echo isset($_POST["txtCustomerAddress"]) ? $_POST["txtCustomerAddress"] : isset($Caddress)? $Caddress: ""; ?> ">
        </li>
        <li>
            <label>Your Phone Number</label>
            <input required type="text" name="txtCustomerPhoneNumber" maxlength="100" value="<?php echo isset($_POST["txtCustomerPhoneNumber"]) ? $_POST["txtCustomerPhoneNumber"] : isset($Cphone)? $Cphone: ""; ?> ">
        </li>
        <li>
            <label>Your Billing</label>
        <table class="table table-condensed" style="margin-bottom: 0!important;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total_money = 0;
                    if(isset($_SESSION["cart_items"]) && count($_SESSION["cart_items"])>0){
                        foreach($_SESSION["cart_items"] as $item){
                            $id = $item["pro_id"];
                            //echo $item["quantity"];
                            $product = Product::get_product($id);
                            $prod = reset($product);
                            $total_money += $item["quantity"]*$prod["Price"];
                            echo 
                            "<tr>
                                <td>".$prod["ProductName"]."</td>
                                <td><img style='width:90px; height:80px' src=".$prod["Picture"]."></td>
                                <td>".$item["quantity"]."</td>
                                <td>$".$prod["Price"]."</td>
                                <td>$".$prod["Price"]*$item["quantity"]."</td>
                            </tr>";
                        }
                            echo 
                            "<tr>
                                <td colspan=5>
                                    <p class='text-right text-danger'><b>Grandtotal:</b> $".$total_money."</p>
                                </td>
                            </tr>";
                            session_start();
                            $_SESSION["totalbilling"] = $total_money;
                        }
                        else{
                            echo "Have no item here !";
                        }
                ?>
            </tbody>
        </table>
        </li>
        <?php 
            if(isset($_GET["inserted"])){
                echo "<script type='text/javascript'>alert('Successful!')</script>";
                //header("Location: index.php");
            }
        ?>
        <li>
            <input type="submit" class="btn btn-primary" name="btnsubmit" value="Confirm" >
        </li>
        <li>
            <div id="response"></div>
            <div id="paypal-button"></div>
            <script src="https://www.paypalobjects.com/api/checkout.js"></script>
            <?php 
                echo "
                    <script type='text/javascript'>
                    paypal.Button.render({
                    // Configure environment
                    env: 'sandbox',
                    client: {
                    sandbox: 'Aeqmo7gwlkLXctEwJpuSlqjPOpEWpr-wyJ24lmuhzvlhjrT8b25q1GhDG5LuHKhCjiUx2xcR3FeJydBT'
                    },
                    // Set up a payment
                    payment: function(data, actions) {
                        return actions.payment.create({
                            transactions: [{
                              amount: {
                                total: '".$total_money."',
                                currency: 'USD'
                              },
                              item_list: {
                                items: [ "; ?>
                        <?php 
                                foreach($_SESSION["cart_items"] as $i){
                                    //echo $item["quantity"];
                                    $idproduct = $item["pro_id"];
                                    $product = Product::get_product($idproduct);
                                    $prods = reset($product);
                                    echo "
                                    {   name: '".$prods["ProductName"]."',
                                        description: '".$prods["ProductName"]."',
                                        quantity: '".$i["quantity"]."',
                                        price: '".$prods["Price"]."',
                                        currency: 'USD'
                                      },
                                    ";
                                }
                        ?>
                        <?php 
                        echo"
                                ],
                              }
                            }],
                            note_to_payer: 'Contact us for any questions on your order.'
                          });
                    },
                    // Execute the payment
                    onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function() {
                        document.getElementById('response').style.display = 'inline-block';
                        document.getElementById('response').innerHTML = 'Thank you for making the payment!';
                        location.replace('clear_cart.php?clearall=1')
                    });
                    },

                    //
                }, '#paypal-button'); 
                
                </script>

                ";
            ?>
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
	padding:20px;
	font-family: Georgia, "Times New Roman", Times, serif;
    border-radius: 10px
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
	background: #FFF;
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
/* .form-style-7 input[type="submit"]{
	background: #2471FF;
	border: none;
	padding: 10px 20px 10px 20px;
	border-bottom: 3px solid #5994FF;
	border-radius: 3px;
	color: #D2E2FF;
} */
/* .form-style-7 input[type="submit"]:hover{
	background: #6B9FFF;
	color:#fff;
} */
</style>