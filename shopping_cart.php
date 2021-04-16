<?php 
    require_once("./entities/product.class.php");
    require_once("./entities/category.class.php");
    
    $cates = Category::list_category();

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors','1');

    if(isset($_GET["ProductID"])){
        $pro_id = $_GET["ProductID"];

        $was_found = false;
        $i=0;
        if(!isset($_SESSION["cart_items"]) || count($_SESSION["cart_items"]) < 1){
            $_SESSION["cart_items"] = array(0 => array("pro_id" => $pro_id, "quantity" => 1));
        }
        else{
            foreach($_SESSION["cart_items"] as $item){
                $i++;
                while (list($key, $value) = each($item)) {
                    if ($key=="pro_id" && $value==$pro_id) {
                        array_splice($_SESSION["cart_items"], $i-1, 1, array(array("pro_id" => $pro_id,"quantity" =>
                        $item["quantity"]+1)) );
                        $was_found = true;
                    }
                }
            }
            if($was_found == false){
                array_push($_SESSION["cart_items"], array("pro_id" => $pro_id, "quantity" => 1));
            }
        }
        header("location: shopping_cart.php");
    }
?>
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
        <a href="index.php"><img id="logo" src="./images/logo.png" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shopping_cart.php">Cart</a>
            </li>          
            <?php 
                @session_start();
                if(isset($_SESSION["user"])){
                    echo "<li class='nav-item'>
                    <a class='nav-link' href=#>".$_SESSION['user']."</a>
                </li>";
                echo "<li class='nav-item'>
                <a class='nav-link' href='logout.php'>Log Out</a>
                </li>";
                }
                else{
                    
                }
            ?>
            <?php 
                @session_start();
                if(isset($_SESSION["customer"])!=""){
                    echo "<li class='nav-item'>
                    <a class='nav-link' href=#>".$_SESSION['customer']."</a>
                </li>";
                echo "<li class='nav-item'>
                <a class='nav-link' href='logout.php'>Log Out</a>
                </li>";
                }
                else{
                    echo "<li class='nav-item'>
                    <a class='nav-link' href='customerLogin.php'>Login</a>
                </li>";
                }
            ?>
            </ul>
        </div>
        </div>
    </nav>
    <div class="px-4 px-lg-0">
    <!-- For demo purpose -->
    <div class="container text-dark py-5 text-center">
      <h1 class="display-4">Shopping cart</h1>
    </div>
    <!-- End -->
  
    <div class="pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
  
            <!-- Shopping cart table -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Product</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Quantity</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Total</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase"><a href="clear_cart.php">X</a></div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    $total_money = 0;
                    $i = -1;
                    if(isset($_SESSION["cart_items"]) && count($_SESSION["cart_items"])>0){
                        foreach($_SESSION["cart_items"] as $item){
                            $i++;
                            $id = $item["pro_id"];
                            //echo $item["quantity"];
                            $product = Product::get_product($id);
                            $prod = reset($product);
                            $total_money += $item["quantity"]*$prod["Price"];

                            echo
                            "<tr>
                                <th scope='row' class='border-0'>
                                <div class='p-2'>
                                    <img src=".$prod["Picture"]." width='70' class='img-fluid rounded shadow-sm'>
                                    <div class='ml-3 d-inline-block align-middle'>
                                    <h5 class='mb-0'>".$prod["ProductName"]."</h5>
                                    </div>
                                </div>
                                </th>
                                <td class='border-0 align-middle'><strong>$".$prod["Price"]."</strong></td>
                                <td class='border-0 align-middle'><strong>".$item["quantity"]."</strong></td>
                                <td class='border-0 align-middle'><strong>$".$prod["Price"]*$item["quantity"]."</strong></td>
                                <td class='border-0 align-middle'></td>
                            </tr>";
                        }
                        }
                        else{
                            echo "<span style='
                            display: flex;
                            justify-content: center;
                            margin-bottom: 1rem;'>Have no item here!</span>";
                        }
                ?>
                </tbody>
              </table>
              <div class="d-flex justify-content-center m-3">
                <?php 
                  if(isset($_SESSION["cart_items"]) && count($_SESSION["cart_items"])>0){
                    echo '<a href="form-checkout.php" class="btn btn-dark rounded-pill py-2 btn-block w-50">Procceed to checkout</a>';
                  }
                ?>
                
              </div>
            </div>
            <!-- End -->
          </div>
        </div>
  
      </div>
    </div>
  </div>
</div>