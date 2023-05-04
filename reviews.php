<?php
session_start();
print_r($_SESSION);

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "sportsking"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(!empty(isset($_POST["customer_id"])) && !empty(isset($_POST["product"])) && !empty(isset($_POST["rating"])) && !empty(isset($_POST["title"])) && !empty(isset($_POST["review"]))) {

$customer_id = $_POST["customer_id"];
$product = $_POST["product"];
$rating = $_POST['rating'];
$title = $_POST["title"];
$review = $_POST["review"];

if(isset($_SESSION['EMAIL']) && ($_SESSION['USER_ID'])) {

$sql = "INSERT INTO reviews (CustomerID, ProductID, Rating, ReviewTitle, ReviewDescription)
VALUES ('$customer_id', '$product', '$rating', '$title', '$review')";

if ($conn->query($sql) === TRUE) {
  $msg = "Review Successfully Submitted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
} else {
  echo  '<div style="padding: 20px 20px;border: 1px solid red;border-radius:20px;background:red;color:white;">
         <h1 class="text-center"> Please Login to Write A Product Review</h1>
          </div>';
}
} else {
  echo "Please fill in all fields";
}
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsKing Mens</title>
    <link rel="stylesheet" href="assets/index_style_reviews.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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
        <div class="navbar-nav">
        <a class="nav-link" href="index.php">
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
      <h1>Reviews</h1>
      <h3>Don't take our word for it, read our customer reviews</h3>
    </div>

    <h2 class="text-center" style="font-size:28px;margin-bottom:20px;">Bought a Product From Sportsking? Leave us a review below!</h2>

    <div id="review_form" class="container" style="background:#f2f2f2;">
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      
          <input type="hidden" id="customer_id" name="customer_id" value= "<?php echo isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : ''; ?>">
      
          <?php 
          $sql1 = "SELECT ProductID, ProductName FROM products";
          $res = mysqli_query($conn, $sql1);
          echo '<label for="product">Product </label>
          <select id="product" name="product">';
          while($row = mysqli_fetch_assoc($res)) {
            echo "<option value='" . $row["ProductID"] . "'>" . $row["ProductName"] . "</option>\n";
          }
          echo '</select>'; ?>

          <label for="rating">Rating:</label>
          <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" required>

          <label for="title">Review Title</label>
          <input type="text" id="title" name="title" placeholder="Review Title..." required>
      
          <label for="review">Subject</label>
          <textarea id="review" name="review" placeholder="Enter Review..." style="height:200px; margin-bottom: 20px;" required></textarea>

      
          <input style="margin-bottom:20px;" type="submit" value="Submit Review" >

          <div id="wrong-details" style="border: 1px solid green; border-radius:20px; background-color:green; color: white; display: <?php echo (!empty($msg)) ? "block" : "none"; ?>;" class="text-center">
          <?php if (!empty($msg)) {
            echo $msg;
            } ?>
         </div>
      
        </form>
      </div>
      <section>
  <div class="container py-5">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10 col-xl-8 text-center">
        <h3 class="fw-bold mb-4">Sportsking Customer Reviews</h3>
        <p class="mb-4 pb-2 mb-md-5 pb-md-0">Don't take our word for it, read the customer reviews for our range of products below:</p>
      </div>
    </div>

    <?php
    $sql2 = "SELECT * FROM reviews";
    $result = mysqli_query($conn, $sql2);

    echo '<div class="row text-center d-flex justify-content-center">';
    while ($review_card = mysqli_fetch_assoc($result)) {
      echo '<div class="col-md-4 mb-4 mb-md-0 flex-fill">
              <div style="background:#b3f0ff;margin-bottom:20px;" class="card">
                <div class="card-body py-4 mt-2">
                  <div class="d-flex justify-content-center mb-4">
                    <img src="assets/photos/user_profile.jpg" class="rounded-circle shadow-1-strong" width="100" height="100" />
                  </div>
                  <h5 class="font-weight-bold">';
      $sql3 = "SELECT FirstName, LastName FROM customers WHERE CustomerID = " . $review_card['CustomerID'];
      $resu = mysqli_query($conn, $sql3);
      while ($cname = mysqli_fetch_assoc($resu)) {
        echo $cname['FirstName'] . ' ' . $cname['LastName'];
      }
      echo '</h5>
            <h6 class="font-weight-bold my-3"> Rating: ' . $review_card['Rating'] . ' out of 5 stars</h6>
            <h6 class="font-weight-bold my-3">' . $review_card['ReviewTitle'] . '</h6>
            <p class="mb-2">
              <h6 class="font-weight-bold my-3">' . $review_card['ReviewDescription'] . '</h6>
            </p>
          </div>
        </div>
      </div>';
    }
    echo '</div>';
    mysqli_close($conn);
    ?>
  </div>
</section>

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

    </body>
</html> 