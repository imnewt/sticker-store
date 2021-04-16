<?php 
    require_once("header.php");
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
 
    $dataPoints = array(
        array("label"=> "Education", "y"=> 1),
        array("label"=> "Entertainment", "y"=> 2),
        array("label"=> "Lifestyle", "y"=> 3),
        array("label"=> "Business", "y"=> 4),
        array("label"=> "Music & Audio", "y"=> 5),
        array("label"=> "Personalization", "y"=> 6),
        array("label"=> "Tools", "y"=> 7),
        array("label"=> "Books & Reference", "y"=> 8),
        array("label"=> "Travel & Local", "y"=> 8),
        array("label"=> "Puzzle", "y"=> 8)
    );
    require_once("./config/db.class.php");
    $db = new Db();
    $sql = "SELECT ProductID,SUM(Quantity) AS Total FROM orderdetail GROUP BY ProductID";
    $result = $db->select_to_array($sql);
    $data = array();
    foreach ($result as $item){
        $pID = $item["ProductID"];
        $getProduct = "SELECT * FROM product WHERE ProductID='$pID'";
        $resultGetProduct = $db->select_to_array($getProduct);
        foreach ($resultGetProduct as $i){
            $pName = $i["ProductName"];
        }
        
        array_push($data,array("label" => $pName, "y" => $item["Total"]));
        
    }
 ?>
    <script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
            text: "The Best Seller"
        },
        axisY: {
            title: "Amount"
        },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    }
    </script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>