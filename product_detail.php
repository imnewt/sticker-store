<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Detail</title>
    <style>
        .backgroundColor{
            background-color: #8fd6e1;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="padding-top:75px">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
    <a href="index.php"><img id="logo" src="./images/logo.png" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shopping_cart.php">Cart</a>
          </li>          
          <?php 
            @session_start();
            if(isset($_SESSION["user"])){
                echo "<li class='nav-item'>
                <a class='nav-link' href=#>".$_SESSION['user']."</a>
              </li>";
              echo "<li class='nav-item'>
              <a class='nav-link' href='logout.php'>Log Out</a>
            </li>";
            }
            else{
                
            }
        ?>
        <?php 
            @session_start();
            if(isset($_SESSION["customer"])!=""){
                echo "<li class='nav-item'>
                <a class='nav-link' href=#>".$_SESSION['customer']."</a>
              </li>";
              echo "<li class='nav-item'>
              <a class='nav-link' href='logout.php'>Log Out</a>
            </li>";
            }
            else{
                echo "<li class='nav-item'>
                <a class='nav-link' href='customerLogin.php'>Login</a>
              </li>";
            }
        ?>
        </ul>
      </div>
    </div>
  </nav>
<?php 
    require_once("./entities/product.class.php");
    require_once("./entities/category.class.php");
?>
<?php 
    if(!isset($_GET["ProductID"])){
        header('Location: not_found.php');
    }
    else{
        $id = $_GET["ProductID"];
        @$prod = reset(Product::get_product($id));
    }
    $cates = Category::list_category();
?>
<div class="container text-center">
  <div class="row">
    <div class="col-sm-3 panel panel-danger">
      <h3 class="panel-heading">Categories</h3>
      <div class="list-group">
      <?php
        foreach ($cates as $item) {
          echo "<li class='list-group-item'><a href=index.php?cateid=" . $item["CateID"] . ">" . $item["CategoryName"] . "</a></li>";
        }
        ?>
      </div>
    </div>
    <div class="col-sm-9 panel panel-info ">
      <h3 class="panel-heading backgroundColor">Details</h3>
      <div class="row">
        <div class="col-sm-6">
          <img src="<?php echo $prod["Picture"]; ?>" alt="Image" style="width: 100%" class="img-responsive" />
        </div>
        <div class="col-sm-6">
          <div style="padding-left: 10px">
            <h3 class="text-info">
              <?php echo $prod["ProductName"]; ?>
            </h3>
            <p>
              Price: $<?php echo $prod["Price"]; ?>
            </p>
            <p>
              Desciption: <?php echo $prod["Descriptions"]; ?>
            </p>
            </div>

            <p class="mt-3">
              <?php 
                echo "<a href='shopping_cart.php?ProductID=".$_GET["ProductID"]."' class='card-link btn btn-primary'>Add to cart</a>";
              ?>
            </p>
          </div>
        </div>
      </div>
    <!-- Load Facebook SDK for JavaScript -->
    <?php
        $url_get = "https://graph.facebook.com/v10.0/103212561902133_".$prod["URL"]."/comments?limit=1000&filter=toplevel&access_token=EAApXgnMdgNgBAEbahRyYYVz74H0LFKrckG9fZBwh3o9s2IL9ZA6JFnG3gwejXtvBiHZAlmWibvZA03KnXI3mcAQ39vXqx2GPGDjfF5MoLVPhkL9z6STvviNAT0sZC6cydLfU0lR8zCbFgl1n8TXPVXj1VZCJ39zCocgATnpA9h8sHwvw6Cbvr3mbegkARwBAsZD";
        $c = curl_init($url_get);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $json_string = curl_exec($c);
        $array = json_decode($json_string, true);
        $array_data = $array['data'];
        //$array_information_user = $array[''] 
        $array_key = array_keys($array_data);
        $count = count($array_data);
        //echo $array_data;
        echo 'Total: ' . $count . ' comments.<br>';
        //echo $json_string;
        for ($i=0; $i<$count; $i++) {
            $key = $array_key[$i];
            $crawl = $array_data[$key];
            //echo 'ID: ' . $crawl['id'] . '<br>';
            $date = substr($crawl['created_time'], 0, -14);
            $time = substr($crawl['created_time'], 11, -5);
            if(isset($crawl['from']['name'])){
              $nameU = $crawl['from']['name'];
            }
            else{
              $nameU = "Anonymous";
            }
            echo '<div class="container wrapper">
            <div class="row">
                <div class="col-8">
                    <div class="card card-white post">
                        <div class="post-heading">
                            <div class="float-left image">
                                <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
                            </div>
                            <div class="float-left meta">
                                <div class="title h5">
                                    <a href="#"><b>'. $nameU.'</b></a>
                                    ' . $crawl['message'] . '
                                </div>
                                <h6 class="text-muted time">created at '. $time." ". $date.'</h6>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
        }
      ?>
      <style>
          .wrapper{
            margin-top : 15px;
          }
          .meta{
            padding : 10px
          }
          .comment{
          }
      </style>
    </div>
  </div>
</div>
</div>
  <footer class="py-5 bg-dark margin">
    <div class="container ">
      <p class="m-0 text-center text-white">Copyright &copy; Narutobaco 2021</p>
    </div>
    <!-- /.container -->
  </footer>
</body>
</html>
<style>
.margin{
  margin-top: 50px
}
  #demo {
    display: grid;
    grid-template-columns: auto auto;
    grid-gap: 10px;
    font-family: arial, sans-serif;
  }
  .pdt {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 10px;
  }
  .pname {
    font-weight: bold;
    font-size: 1.3em;
  }
  .pprice, .prate {
    color: #777;
  }
  .pstar img {
    width: 30px;
    cursor: pointer;
  }
</style>
<script>  
  var stars = {
  init : function () {
    for (let docket of document.getElementsByClassName("pstar")) {
      for (let star of docket.getElementsByTagName("img")) {
        star.addEventListener("mouseover", stars.hover);
        star.addEventListener("click", stars.click);
      }
    }
  },

  hover : function () {
    let all = this.parentElement.getElementsByTagName("img"),
        set = this.dataset.set,
        i = 1;
    for (let star of all) {
      star.src = i<=set ? "./uploads/star.png" : "./uploads/star-blank.png";
      i++;
    }
  },
  
  click : function () {
    document.getElementById("ninPdt").value = this.parentElement.dataset.pid;
    document.getElementById("ninStar").value = this.dataset.set;
    document.getElementById("ninForm").submit();
  }
};
window.addEventListener("DOMContentLoaded", stars.init);
</script>