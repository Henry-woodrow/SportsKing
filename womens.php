<?php 
session_start();
print_r($_SESSION);

$conn = mysqli_connect("localhost", "root", "", "sportsking");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsKing Women</title>
    <link rel="stylesheet" href="assets/index_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
      #link {
        font-family:'Open Sans', sans-serif;
      }
      @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bebas+Neue&family=Iceland&family=Open+Sans:wght@300&display=swap');
      </style>      
  </head>
  <body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="assets/Sports-World.png" alt="Logo" width="140" height="50" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="mens.php">MENS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="womens.php">WOMENS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="kids.php">KIDS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="accesories.php">ACCESSORIES</a>
            </li>
            <?php
            if(isset($_SESSION['EMAIL'])) {
              if ($_SESSION['EMAIL'] === 'admin@sportsking.com') {
                echo '<li class="nav-item"><a class="nav-link" href="search_customers.php">SEARCH CUSTOMERS</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="stock_levels.php">STOCK LEVELS</a></li>';
              } else {
                echo '<li class="nav-item"><a class="nav-link" href="my_orders.php">MY ORDERS</a></li>';
              }
            }
            ?>
          </ul>
        </div>
        <div class="navbar-nav">
        <a class="nav-link" href="#">
            <a class="nav-link" href="basket.php">BASKET</a>
          </a>
          <?php if(isset($_SESSION['EMAIL'])) {
            if($_SESSION['EMAIL']) {
          echo '<a class="nav-link" href="logout.php">LOGOUT</a>';}}
          else {
           echo '<a class="nav-link" href="login.php">LOGIN</a>';
          } ?>
        </div>
      </div>
    </nav>

    <div id="opening-header" class="jumbotron">
      <h1>Women's Fashion</h1>
      <h3>Shop the latest in Women's fashion with a variety of top brands like Adidas, Calvin Klein and EA7</h3>
    </div>

    <div class="container mt-5">
      <div class="row">

      <?php $sql = "SELECT * FROM products WHERE ProductID BETWEEN 225 AND 240";
				$res = mysqli_query($conn, $sql);
				if(mysqli_num_rows($res) > 0)
				{
					while($row = mysqli_fetch_array($res))
					{?>
              <div class="col-md-3">
               <div class="card">
                <a href="#" >
                <img src="assets/photos/womens/<?php echo $row['image'];?>" class="card-img-top img1" alt="Product 1 image">
                 </a>
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['ProductName']?></h5>
            <div class='wrapper text-center'>
              <form action="basket.php" method="post">
              <div class="btn-group btn-group-sm mb-3">
              <?php if($row['Quantity'] <= 0) {?>
                <h3> Out of Stock </h3>
                <?php } else { ?>
              <label for="quantity" style="font-weight:700;font-size: 20px; margin-right: 20px;">Quantity:</label>
              <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" required style="width: 60px; font-size: 16px;"/>
              <?php } ?>
              </div>
              </div>
              <div class="d-flex justify-content-between align-items-center" style="margin-top:1px;">
              <?php if($row['Quantity'] <= 0) {?>
                <p class="mb-1">£<?php echo $row['Price']?></p>
                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']?>" />
                <input type="hidden" name="product_name" value="<?php echo $row['ProductName']?>" />
                <button type="button" class="btn btn-secondary disabled">Add to Cart</button>
                <?php } else { ?>
                <p class="mb-1">£<?php echo $row['Price']?></p>
                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']?>" />
                <input type="hidden" name="product_name" value="<?php echo $row['ProductName']?>" />
                <input type="hidden" name="product_price" value="<?php echo $row['Price']?>" />
                <input type="hidden" name="image" value="<?php echo 'assets/photos/womens/'.$row['image']?>" />
                <button type="submit" name="add_to_basket" class="btn btn-primary">Add to Cart</button>
              <?php } ?>
              </form>   
              </div>
          </div>
        </div>
      </div>

     

  <?php
          }};
  ?>

<footer class="bg-light pt-5 pb-3">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-4 mb-3">
        <h5 class="mb-3" style="font-size: 16px;">Contact Us</h5>
        <img style="width:50%; margin-bottom:5px;" src="assets/Sports-World.png">
        <p style="font-size: 16px;margin-bottom:0px;">Address: 243 Upper Street, Islington<br>London, United Kingdom N1 1RU</p>
        <p style="font-size: 16px;">Phone: 020-56415816<br>Email: sportskingenquiries@gmail.com</p>
      </div>
      <div class="col-md-6 col-lg-4 mb-3">
        <h5 class="mb-3">Explore</h5>
        <ul class="list-unstyled">
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About Us</a></li>
          <li><a href="mens.php">Mens</a></li>
          <li><a href="womens.php">Womens</a></li>
          <li><a href="kids.php">Kids</a></li>
          <li><a href="accesories.php">Accessories</a></li>
          <li><a href="reviews.php">Product Reviews</a></li>
        </ul>
      </div>
      <div class="col-md-6 col-lg-4 mb-3">
        <h5 class="mb-3">Connect With Us</h5>
        <ul class="list-unstyled">
        <div class="social-media">
        <a style="font-size:56px;" href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
        <a style="font-size:56px;margin-left:15px;" href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
        <a style="font-size:56px;margin-left:15px;" href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
        </div>
        </ul>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12 text-center">
        <p class="mb-0">&copy; 2023 Sportsking Retail Company Limited. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>


    
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>