<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Narutobaco</title>
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="css/login.css" rel="stylesheet">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
   <div class="sidenav">
      <div class="login-main-text">
         <h2>Narutobaco<br> Login Page</h2>
         <p>Sign in to get access to customize our products.</p>
      </div>
   </div>
   <?php 
      $host = "localhost";
      $userHost = "root";
      $passHost = "BAtrieu281";
      $db = "stickerstoree"; 
      session_start();
      $conn = new mysqli($host, $userHost, $passHost, $db);
      if(isset($_POST['btnsubmit'])){
          global $conn;
          $tennguoidung = $_POST['username'];
          $matkhau = $_POST['password'];
          $sql = "SELECT * FROM customer WHERE CustomerPassword = ? AND CustomerName = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ss", $matkhau, $tennguoidung);
          $stmt->execute();
          $result = $stmt->get_result();
          while($item = $result->fetch_assoc()){
            $uid = $item["CustomerID"];
            
         }
          if($result->num_rows > 0){
            $_SESSION["customer"] = $tennguoidung;
            $_SESSION["customerID"] = $uid;
            header("Location: index.php");
              

          }
          else{
              $message = "wrong answer";
              echo "<script type='text/javascript'>alert('$message');</script>";
              //header("Location: ../login.php");
              
          }
          $conn->close();
      }
   ?>
   <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
               <form method="post" > 
                  <div class="form-group">
                     <label>User Name</label>
                     <input required name="username" type="text" class="form-control" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ""; ?>">
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input required name="password" type="password" class="form-control" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ""; ?>">
                  </div>
                  <input type="submit" name="btnsubmit" value="Login" class="btn btn-primary"/>
                  <a href="customerRegister.php" class="btn btn-secondary">Register</a>
               </form>
               
            </div>
         </div>
   </div>
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
