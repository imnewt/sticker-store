<?php 
  require_once("header.php")
?>
          <?php 
            session_start();
            if(!isset($_SESSION["user"])){
                header("Location: login.php");
              }
            if(isset($_SESSION["user"])!=""){
                echo "<li class='nav-item'>
                <a class='nav-link' href=#>".$_SESSION['user']."</a>
              </li>";
              echo "<li class='nav-item'>
              <a class='nav-link' href='logout.php'>Log Out</a>
            </li>";
            }
            else{
                echo "<li class='nav-item'>
                <a class='nav-link' href='login.php'>Login</a>
              </li>";
            }
        ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php 
    require "core.php";
    require_once "./config/db.class.php";
    $average = $_STARS->avg(); // AVERAGE RATINGS
    $ratings = $_STARS->get($uid);
    $db = new Db();
    $sql = "SELECT * FROM star_rating";
    $result = $db->select_to_array($sql);
    //$array = array();
    echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>Product Name</th>
                    <th>Customer Name</th>
                    <th>Rating</th>
                </tr>";
    foreach($result as $item){
        $cid = $item["user_id"];
        $getCustomer = "SELECT * FROM customer WHERE CustomerID='$cid'";
        $resultGetCustomer = $db->select_to_array($getCustomer);
        foreach ($resultGetCustomer as $i) {
            $cName = $i["CustomerName"];
        }
        $pid = $item["product_id"];
        //  echo $pid;
        $getProduct = "SELECT * FROM product WHERE ProductID='$pid'";
        $resultGetProduct = $db->select_to_array($getProduct);
        foreach ($resultGetProduct as $i) {
            $pName = $i["ProductName"];
        }
            echo "
            <tr>
                <td>".$pName."</td>
                <td>".$cName."</td>
                <td>".$item['rating']."</td>
            </tr> ";
    }
  ?>
  <style>
  td, th {
    text-align: center;
    padding: 0.5em;
  }
</style>