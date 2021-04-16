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
    require_once("./config/db.class.php");
    if(!isset($_GET["id"])){
        header('Location: not_found.php');
    }
    else{
        $id = $_GET["id"];
        $orderID = $_GET["stt"];
        $db = new Db();
        $sql = "SELECT * FROM orderdetail WHERE OrderID='$id'";
        $detailProduct = $db->select_to_array($sql);
        if($detailProduct)
        {
            echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>Billing Detail ID</th>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>";
            foreach($detailProduct as $item){
                $id = $item["ProductID"];
                $sql = "SELECT * FROM product WHERE ProductID='$id'";
                $lstProductName = $db->select_to_array($sql);
                foreach($lstProductName as $i){
                    $productName = $i["ProductName"];
                }
                echo  "<tr>
                        <td>".$item['OrderDetailID']."</td>
                        <td>".$item['OrderID']."</td>
                        <td>".$productName."</td>
                        <td>".$item['Quantity']."</td>
                    </tr> ";
            }
            echo "</table></div>";
            $sql = "SELECT * FROM orderproduct WHERE OrderID='$orderID'";
            $lstStatus = $db->select_to_array($sql);
            $prod = reset($lstStatus);
        }
        else{
            echo "NO DATA";
        }
    }
?>
  <?php 
      echo '<form action="productController.php?action=editStatus&OrderID='.$_GET["stt"].'"  method="post" class="form-style-7" >';
  ?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <label class="mt-3 ml-2">Status:</label>
    <select name="txtStatusID" value="<?php echo isset($_POST["txtStatusID"]) ? $_POST["txtStatusID"] : ""; ?>">
        <option value="<?php echo $prod["StatusID"]; ?>" selected>Choose status</option>
        <?php 
            $sql = "SELECT * FROM status";  
            $stt = $db->select_to_array($sql);
            foreach ($stt as $item){
                echo "<option value=".$item["StatusID"].">".$item["StatusName"]."</option>";
            }
        ?>
    </select>
    <input type="submit" name="btnsubmit" class="btn btn-primary" value="Change" >
  </form>
<style>
th,td {
  text-align:center;
}
</style>
</body>
</html>