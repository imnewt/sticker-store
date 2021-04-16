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
    $prod = Product::list_product();
    if($prod){
        echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>";
        foreach($prod as $item){
            $cateID = $item['CateID'];
            $db = new Db();
            $sql = "SELECT * FROM category WHERE CateID='$cateID'";
            $result = $db->select_to_array($sql);
            foreach($result as $i){
                $categoryName = $i["CategoryName"];
            }
            echo "
                <tr>
                    <td style='text-align:center'>".$item['ProductID']."</td>
                    <td style='text-align:center'>".$item['ProductName']."</td>
                    <td style='text-align:center'>".$categoryName."</td>
                    <td style='width:700px'>".$item['Descriptions']."</td>
                    <td style='text-align:center'>".$item['Price']."</td>
                    <td style='text-align:center'>".$item['Quantity']."</td>
                    <td style='text-align:center'><img width='90px' height='90px' src='".$item['Picture']."' ></td>
                    <td style='text-align:center'>
                        <a href='form-edit.php?ProductID=".$item['ProductID']."'>EDIT</a>
                        <span>/</span>
                        <a href='productController.php?action=delete&id=".$item["ProductID"]."'>DELETE</a>
                    </td>
                </tr> ";
        }
        echo "</table></div>";
    }
    else{
        echo "NO DATA";
    }
?>
  <!-- Page Content -->
  
      <!-- /.col-lg-3 -->

<style>
  th {
    text-align:center;
  }
</style>
</body>
</html>
