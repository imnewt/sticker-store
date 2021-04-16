<?php 
    session_start();
    if(isset($_SESSION['customer'])!=""){
        header("Location: index.php");
    }
    require_once("./entities/user.class.php");

    if(isset($_POST["btn-signup"])){
        $u_name = $_POST['txtname'];
        $u_pass = $_POST['txtpass'];
        $u_address = $_POST['txtaddress'];
        $u_phone = $_POST['txtphonenumber'];
        $account = new User($u_name, $u_pass, $u_address,$u_phone ) ;
        $result = $account->save();
        if(!$result){
            echo '<script>alert("Something Wrong here!")</script>';
        }
        else{
            $_SESSION["customer"] = $u_name;
            header("Location: index.php");
        }
        
    }
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="main d-flex align-items-center mt-5" style="flex-direction:column">
         <h2>Register</h2>
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
               <form method="post" > 
                  <div class="form-group">
                     <label>User Name</label>
                     <input required name="txtname" type="text" class="form-control" >
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input required name="txtpass" type="password" class="form-control" >
                  </div>
                  <div class="form-group">
                     <label>Address</label>
                     <input required name="txtaddress" type="text" class="form-control" >
                  </div>
                  <div class="form-group">
                     <label>Phone Number</label>
                     <input required name="txtphonenumber" type="text" class="form-control" >
                  </div>
                  <input type="submit" name="btn-signup" value="Sign Up" class="btn btn-primary"/>
               </form>
            </div>
         </div>
   </div>