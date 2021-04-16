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
    require_once("./entities/user.class.php");
    require_once("./config/db.class.php");
    $prod = User::list_customer();
    if($prod){
        echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>CustomerID</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Amount of billing</th>
                    <th>Total Payment</th>
                    <th>ACTION</th>
                </tr>";
        foreach($prod as $item){
            $total =0;
            $count = 0;
            $Cname = $item['CustomerName'];
            $db = new Db();
            $sql = "SELECT * FROM orderproduct WHERE ShipName='$Cname'";
            $result = $db->select_to_array($sql);
            foreach($result as $i){
                $total += $i["TotalBilling"];
                $count++;
            }
            echo "
                <tr>
                    <td>".$item['CustomerID']."</td>
                    <td>".$item['CustomerName']."</td>
                    <td>".$item['CAddress']."</td>
                    <td>".$item['Phone']."</td>
                    <td>".$count."</td>
                    <td>".$total."</td>
                    <td>
                        <a href='productController.php?action=deletecustomer&id=".$item["CustomerID"]."'>DELETE</a>
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