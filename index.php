<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Narutobaco</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="index.php"><img id="logo" src="./images/logo.png" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shopping_cart.php">Cart</a>
          </li>          
          <?php 
            session_start();
            if(isset($_SESSION["user"]) || isset($_SESSION["customer"])){
                echo "<li class='nav-item'>
                      <a class='nav-link' href=#>".$_SESSION['user']."</a>
                    </li>
                    <li class='nav-item'>
                      <a class='nav-link' href=#>".$_SESSION['customer']."</a>
                    </li>
              ";
              echo "<li class='nav-item'>
              <a class='nav-link' href='logout.php'>Log Out</a>
            </li>";
            }
            else{
                echo "
              <li class='nav-item'>
                <a class='nav-link' href='customerLogin.php'>Login</a>
              </li>";
            }
        ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <h1 class="my-4">Danh Mục</h1>
          <div class="mb-4 d-flex flex-row">
            <input id="searchbar" placeholder='Type something here...' type='text'/>
            <button onclick='search()' class="btn btn-primary ml-2">Search</button>
          </div>
        <div class="list-group">
          <?php 
            require_once("./entities/product.class.php");
            require_once("./entities/category.class.php");
            if (!isset($_GET["cateid"]) && !isset($_GET["keyword"])){
              $prod = Product::list_product();
            }
            else {
              if (isset($_GET["cateid"])) {
                $cateid = $_GET["cateid"];
                $prod = Product::list_product_by_cateid($cateid);
              }
              if (isset($_GET["keyword"])){
                $keyword = $_GET["keyword"];
                $prod = Product::list_product_by_keyword($keyword);
              }
            }
            $cates = Category::list_category();
            foreach ($cates as $item){
              echo "<a href='index.php?cateid=".$item['CateID']."' class='list-group-item'>".$item["CategoryName"]."</a>";
            }
          ?>
        </div>
      </div>
      <script>
          function search() {
            let text = document.getElementById("searchbar").value;
            window.location.replace(`http://localhost:81/DoAnCC/index.php?keyword=${text}`);
          }
      </script>

      <div class="col-lg-9">
        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="https://theme.hstatic.net/1000090040/1000663762/14/slide2.png?v=1326" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./images/banner1.png" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./images/banner2.png" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">
        <?php
          foreach($prod as $item){
            echo "
            <div class='col-lg-4 col-md-6 mb-4'>
          <div class='card h-100'>
            <a href='product_detail.php?ProductID=".$item["ProductID"]."'><img class='card-img-top' src='".$item['Picture']."' alt=''></a>
            <div class='card-body'>
              <h4 class='card-title'>
                <a href='#'>".$item['ProductName']."</a>
              </h4>
              <h5>$".$item['Price']."</h5>
              <div class='card-body' style='padding: 0.5rem 0.5rem 0.5rem 0;'>
                <a href='product_detail.php?ProductID=".$item['ProductID']."' class='card-link btn btn-secondary'>Detail</a>
                <a href='shopping_cart.php?ProductID=".$item['ProductID']."' class='card-link btn btn-primary'>Add to cart</a>
              </div>
            </div>
          </div>
        </div>
            ";
          }
        ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
  <div class="container">
    <div class="mapouter">
      <div class="gmap_canvas">
        <iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=1200&amp;height=400&amp;hl=en&amp;q=HUTECH&amp;t=h&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        <a href="https://www.embedmymap.com/">Embed My Map</a>
      </div>
      
        <p class="m-0 text-center text-white">Copyright &copy; Narutobaco 2021</p>
      </div>
        <style>
        .mapouter{
          position:relative;
          text-align:right;
          width:1200px;
          height:400px;
          }
        .gmap_canvas {
          overflow:hidden;
          background:none!important;
          width:1200px;
          height:400px;
          }
        .gmap_iframe {
          width:1200px!important;
          height:400px!important;
          }
        </style>
      </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
