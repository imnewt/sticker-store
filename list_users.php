<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .footer{
            margin-bottom: 20px;
            margin-left: 600px
        }
        
    </style>
</head>
<body>
    <?php 
        require_once("./entities/product.class.php");
        include_once("header.php");

         $prod = Product::list_users();
        foreach($prod as $item){
            // echo "<p class=`tilte`>Name: ".$item["ProductName"]."</p>";
            // echo "<img src=".$item["Picture"].">";
        //     echo '<div class="card footer" style="width: 18rem;">
        //     <img class="card-img-top" src='.$item["Picture"].'>
        //     <div class="card-body">
        //       <h5 class="card-title">'.$item["ProductName"].'</h5>
        //       <p class="card-text">'.$item["Descriptions"].'</p>
        //     </div>
        //     <ul class="list-group list-group-flush">
        //       <li class="list-group-item">Price: '.$item["Price"].'</li>
        //       <li class="list-group-item">Quatity: '.$item["Quantity"].'</li>
        //     </ul>
        //     <div class="card-body">
        //       <a href="#" class="card-link">Buy Now</a>
        //       <a href="#" class="card-link">Add to cart</a>
        //     </div>
        //   </div>';
        echo "name: ". $item["UserName"];
        echo "Pass: ". $item["Password"];
        }
        include_once("footer.php");
    ?>    
</body>
</html>