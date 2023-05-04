<?php $msg = " " ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsKing Login</title>
    <link rel="stylesheet" href="assets/index_style_reviews.css">
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
          </ul>
        </div>
        <div class="navbar-nav">
          <a class="nav-link" href="basket.php">
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
    <h1>Login</h1>
    <h3>Login in to your Sportsking's account here and be a King!</h3>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php
            session_start();
            $conn = mysqli_connect("localhost", "root", "", "sportsking");
            $msg = ""; 
            // if the submit button the login form is clicked, the values entered into the fields will be placed into variables
            if(isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($conn, $_POST['email_address']);
                $password = mysqli_real_escape_string($conn,$_POST['password']);
                // Query that checks if there is a user with that email and password in the database. 
                $sql = mysqli_query($conn, "SELECT * FROM customers WHERE EmailAddress = '$email' && Passwd = '$password'");
                $num = mysqli_num_rows($sql);
                // If details are found, session variables are set and user is successfully logged in and taken to the mens page. 
                if($num > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $_SESSION['USER_ID'] = $row['CustomerID'];
                    $_SESSION['EMAIL'] = $row['EmailAddress'];
                    header("location:mens.php");
                } else {
                  // If no record is found of the email address and password which the user entered, an error message is displayed to them. 
                    $msg = "Invalid Email Address or Password!";
                }
            }
        ?>
        <!-- User will fill in this form to login -->
            <h2 class="text-center" style="margin-bottom:20px;">Please login to your Sportsking account below:</h2>
            <div id="review_form" class="container" style="background-color:#f2f2f2; width:50%">
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="email_address">Email Address</label>
                    <input type="text" id="email_address" name="email_address" placeholder="Email Address..." size="35" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password..." size="35" required/>

                    <input style="margin-bottom:20px" type="submit" name="submit" value="Login">
                    <!-- Format the error message -->
                    <div id="wrong-details" style="border: 1px solid red;border-radius:20px;background:red;color:white;display:<?php echo ($msg !== '') ? 'block' : 'none'; ?>;" class="text-center">
                    <?php
                        if (!empty($msg)) {
                            echo $msg;
                        }
                    ?>
                </div>
                </form>
            </div>
            <div class="text-center">
              <!-- Button that directs the user to the Create Account Page if they do not have an account  -->
                <h5> You don't have a Sportsking Account? </h5>
                <a href="create_account.php" class="btn btn-primary">Create an Account</a>
            </div>
        </div>
    </div>
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