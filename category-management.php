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
    $db = new Db();
    $sql = "SELECT * FROM category";
    $result = $db->select_to_array($sql);
    echo "<div class='table-container'> <table border=1 style='width:100%'>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>ACTION</th>
                </tr>";
    foreach ($result as $item){
        echo "
        <tr>
            <td>".$item['CateID']."</td>
            <td>".$item['CategoryName']."</td>
            <td>".$item['Descriptions']."</td>
            <td>
                <a href='category-form-edit.php?id=".$item['CateID']."'>EDIT</a>
                <span>/</span>
                <a href='productController.php?action=deletecategory&id=".$item["CateID"]."'>DELETE</a>
            </td>
        </tr> ";
    }
    echo "</table></div>";
  ?>
  <a href="add-category.php" class="btn btn-primary mt-3 ml-3">Add new</a>
  <style>
  td, th {
    text-align: center;
    padding: 0.5em;
  }
</style>
</body>
</html>