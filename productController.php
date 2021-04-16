<?php 
    $server = "localhost";
    $user = "root";
    // $pass = "BAtrieu281";
    $pass = "BAtrieu281";
    $db = "stickerstoree";
    $connection = new mysqli($server,$user,$pass,$db);
    $db = mysqli_connect($server,$user,$pass,$db);
    if($connection->connect_error){
        die("ERR!");
    }
    $rootURL = "productController.php?action";
    $action = $_REQUEST['action'];
    if(!isset($action)){
        die("Invalid Request!");
    }
    switch ($action) {
        case 'delete':
            Delete_Product();
            break;
        case 'edit':
            Edit_Product();
            break;
        case 'deletecustomer':
            Delete_Customer();
            break;
        case 'editcategory':
            Edit_Category();
            break;
        case 'deletecategory':
            Delete_Category();
            break;
            
        case 'editStatus':
            Edit_Status();
            break;
        default:
            break;
    }
    function Delete_Product(){
        global $connection,$rootURL;
        $id = intval($_GET['id']);
        $sql = "DELETE FROM product WHERE ProductID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i",$id); //string double
        if($stmt->execute()){
            //DanhSachSanPham();
            header("Location: home-admin.php");
        }
        else{
            echo "ERROR!";
        }
        $connection->close();
    }
    function Delete_Customer(){
        global $connection,$rootURL;
        $id = intval($_GET['id']);
        $sql = "DELETE FROM customer WHERE CustomerID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i",$id); //string double
        if($stmt->execute()){
            //DanhSachSanPham();
            header("Location: user-management.php");
        }
        else{
            echo "ERROR!";
        }
        $connection->close();
    }
    function Delete_Category(){
        global $connection,$rootURL;
        $id = intval($_GET['id']);
        $sql = "DELETE FROM category WHERE CateID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i",$id); //string double
        if($stmt->execute()){
            //DanhSachSanPham();
            header("Location: category-management.php");
        }
        else{
            echo "ERROR!";
        }
        $connection->close();
    }
    function Edit_Product(){
         global $db,$connection,$rootURL;
         $id = $_GET['ProductID'];
         $productName = $_POST["txtName"];
         $cateID = $_POST["txtCateID"];
         $price = $_POST["txtPrice"];
         $quantity = $_POST["txtQuantity"];
         $description = $_POST["txtdesc"];
        //  $picture = $_FILES["txtpic"];

        //  $file_temp = $this->picture['tmp_name'];
        //  $user_file = $this->picture['name'];
        //  $timestamp = date("Y").date("m").date("d").date("h").date("i").date("s");
        //  $filepath = "uploads/".$timestamp.$user_file;
        // if(move_uploaded_file($file_temp, $filepath) == false){
        //     return false;
        // }
            mysqli_query($db,"UPDATE product SET ProductName= '$productName', CateID = '$cateID', Price ='$price', Quantity='$quantity', Descriptions= '$description' WHERE ProductID=$id");
       
        header("Location: home-admin.php");
    }
    function Edit_Category(){
        global $db,$connection,$rootURL;
        $id = $_GET['CateID'];
        $Name = $_POST["txtName"];
        $description = $_POST["txtdsc"];
           mysqli_query($db,"UPDATE category SET CategoryName= '$Name', Descriptions= '$description' WHERE CateID=$id");
      
       header("Location: category-management.php");
   }
   function Edit_Status(){
    global $db,$connection,$rootURL;
    $id = $_GET['OrderID'];
    $StatusID = $_POST["txtStatusID"];
    mysqli_query($db,"UPDATE orderproduct SET StatusID= '$StatusID' WHERE OrderID=$id");
  
   header("Location: billing-management.php");
}
?>