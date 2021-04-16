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
    require_once("./entities/product.class.php");
    require_once("./config/db.class.php");
    $prod = Product::list_billing();
    if($prod){
        echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>ID</th>
                    <th>Order Date</th>
                    <th>Name Customer</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Total Billing</th>
                    <th>Status</th>
                    <th>ACTION</th>
                </tr>";
        foreach($prod as $item){
            $statusID = $item["StatusID"];
            $db = new Db();
            $sql = "SELECT * FROM status WHERE StatusID='$statusID'";
            $result = $db->select_to_array($sql);
            foreach($result as $i){
                $statusName = $i["StatusName"];
            }
            echo "
                <tr>
                    <td>".$item['OrderID']."</td>
                    <td>".$item['OrderDate']."</td>
                    <td>".$item['ShipName']."</td>
                    <td>".$item['ShipAddress']."</td>
                    <td>".$item['ShipPhone']."</td> 
                    <td>".$item['TotalBilling']."</td>
                    <td>".$statusName."</td>
                    <td>
                        <a href='billing-detail.php?id=".$item["OrderID"]."&stt=".$item["OrderID"]."'>Detail</a>
                    </td>
                </tr> ";
        }
        echo "</table></div>";
    }
    else{
        echo "NO DATA";
    }
  ?>
<style>
  td, th {
    text-align: center;
    padding: 0.5em;
  }
</style>
</body>
</html>