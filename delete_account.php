<?php 
session_start();
print_r($_SESSION);

$conn = mysqli_connect("localhost", "root", "", "sportsking");
$user_id = $_SESSION['USER_ID'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsKing Home</title>
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
          <a class="navbar-brand" href="#">
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
            </ul>
          </div>
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

      <div style="margin-bottom:20px" id="opening-header" class="jumbotron">
      <h1>Account Deletion</h1>
      </div>

      <div class="container text-center">
      <img  style="margin-bottom:20px;" src="assets/Sports-World.png" width= "900" height="180">
        <h1>We're sorry that you want to delete your Sportsking Account!</h1>
        <h4 style ="margin-bottom:20px;">Click the button below to deactivate your Sportsking Account</h4>

        <form action= "<?php echo $_SERVER['PHP_SELF'];?>" METHOD="post">
        <button type="submit" name="delete_account" style=" font-size:34px;border: 1px solid green;background-color: green; color: white; border-radius: 5px;">Deactivate Account</button>
        </form>

        <?php 
    if(isset($_POST['delete_account'])) {
        $sql = "DELETE FROM orderproduct WHERE OrderID IN (SELECT OrderID FROM orders WHERE CustomerID = $user_id);";
        $result = mysqli_query($conn, $sql);
        $sql = "DELETE FROM orders WHERE CustomerID = $user_id;";
        $result = mysqli_query($conn, $sql);
        $sql = "DELETE FROM customers WHERE CustomerID = $user_id;";
        $result = mysqli_query($conn, $sql);
        
        $msg = "Account Successfully Deleted";
        echo '<div id="success-message" class="text-center" style="width:50%; font-size: 30px; margin: 20px auto; border: 1px solid green; border-radius:20px; background-color:green; color: white; display: <?php echo (!empty($msg)) ? "block" : "none"; ?>';
        if (!empty($msg)) {
            echo $msg;
        } 
        echo '</div>';
    } else {
        echo "Error occured:" . mysqli_error($conn);
    }
    ?>
    </div>

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
          <?php if(isset($_SESSION['EMAIL'])) {
            echo '<li><a href="delete_account.php">Delete Account</a></li>';
          }
          ?>
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

