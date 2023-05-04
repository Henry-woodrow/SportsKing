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
    <title>SportsKing Mens</title>
    <link rel="stylesheet" href="assets/index_style_reviews.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
      #link {
        font-family:'Open Sans', sans-serif;
      }
      @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bebas+Neue&family=Iceland&family=Open+Sans:wght@300&display=swap');

      table {
        margin-left: auto;
        margin-right: auto;
      }

      th {
        border:1px solid black;
        padding:8px;
      }

      td {
        border:1px solid black; padding:8px;
      }
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
            <?php if(isset($_SESSION['EMAIL'])) {
          if($_SESSION['EMAIL'] === 'admin@sportsking.com') {
            echo '<li class="nav-item"><a class="nav-link" href="search_customers.php">SEARCH CUSTOMERS</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="stock_levels.php">STOCK LEVELS</a></li>';

          }
        }
        ?>
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

    <?php
    // if the user is logged in as an admin display the form to find customer details. 
    if(isset($_SESSION['EMAIL']) && $_SESSION['EMAIL'] == 'admin@sportsking.com') {

     echo '<div id="opening-header" class="jumbotron">
      <h1>Customer Search</h1>
    </div>';


    echo '<div style="margin: 20px;">
    <h2>Search Sportsking Customer</h2>
    <form method="post" action="">
        <label for="search_customer_id">Enter Customer ID:</label>
        <input type="text" name="search_customer_id" id="search_customer_id">
        <br>
        <label for="search_last_name">Enter Last Name:</label>
        <input type="text" name="search_last_name" id="search_last_name">
        <br>
        <button type="submit" name="search_customer_btn">Search</button>
    </form>
</div>';

// if the search_customer button is clicked, the data in the fields posted into variables. 
if(isset($_POST['search_customer_btn'])) {
    $search_customer_id = $_POST['search_customer_id'];
    $search_last_name = $_POST['search_last_name'];
    // Queries to find a customer 
    if(!empty($search_customer_id)) {
        $sql = "SELECT * FROM customers WHERE CustomerID = $search_customer_id AND Admin is NULL";
    } elseif (!empty($search_last_name)) {
        $sql = "SELECT * FROM customers WHERE LastName = '$search_last_name' AND Admin is NULL";
    } else { // if fields are empty display all customers
        $sql = "SELECT * FROM customers WHERE Admin is NULL";
    }
    $result = mysqli_query($conn, $sql);

    // Records retrieved will be shown in a table format showing all their information when they signed up with Sportsking  
    if(mysqli_num_rows($result) > 0) {

        echo "<table style='margin-bottom:20px;border-collapse: collapse; width:80%;'>";
        echo "<tr><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>Contact Number</th><th>Email Address</th><th>Address</th><th>City</th><th>Postcode</th><th>Country</th> <th>Password</th> <th>Card Number</th><th>CVV</th><th>Delete Account</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["CustomerID"] . "</td>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["LastName"] . "</td>";
            echo "<td>" . $row["ContactNumber"] . "</td>";
            echo "<td>" . $row["EmailAddress"] . "</td>";
            echo "<td>" . $row["Address"] . "</td>";
            echo "<td>" . $row["City"] . "</td>";
            echo "<td>" . $row["Postcode"] . "</td>";
            echo "<td>" . $row["Country"] . "</td>";
            echo "<td>" . $row["Passwd"] . "</td>";
            echo "<td>" . $row["CardNumber"] . "</td>";
            echo "<td>" . $row["CVV"] . "</td>";
            echo "<td><form method='post'><input type='hidden' name='delete_id' value='" . $row["CustomerID"] . "'><button type='submit' style='border-radius:5px;background-color: red; color: white; border: none; padding: 8px 16px;'>Delete</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
      // if no customer records are found display this message 
        if (!empty($search_customer_id)) {
            echo "<h2 class='text-center'> No Customer records found for Customer ID: $search_customer_id </h2>";
        } else 
        if (!empty($search_last_name)) {
            echo "<h2 class='text-center'> No Customer records found for Last Name: $search_last_name </h2>";
        }
      }
    } elseif (isset($_POST['delete_id'])) { // if user clicks the delete button for a customer in a table, these queries will remove the customer from the database. 
      $delete_id = $_POST['delete_id'];
      $sql = "DELETE FROM orderproduct WHERE OrderID IN (SELECT OrderID FROM orders WHERE CustomerID = $delete_id);";
      $result = mysqli_query($conn, $sql);
      $sql = "DELETE FROM orders WHERE CustomerID = $delete_id;";
      $result = mysqli_query($conn, $sql);
      $sql = "DELETE FROM customers WHERE CustomerID = $delete_id;";
      $result = mysqli_query($conn, $sql);
      
      // If deleted successfully, this message will appear. 
      if ($result) {
          $msg = "Account Successfully Deleted";
      } else {
          $msg = "Error occured:" . mysqli_error($conn);
      }
  
      echo '<div id="success-message" class="text-center" style="width:50%; font-size: 30px; margin: 20px auto; border: 1px solid green; border-radius:20px; background-color:green; color: white; display: <?php echo (!empty($msg)) ? "block" : "none"; ?>';
      if (!empty($msg)) {
          echo $msg;
      } 
      echo '</div>';
  } 
} else {
  echo '<h1 class="text-center"> Content Cannot Be Shown</h1>';
}
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