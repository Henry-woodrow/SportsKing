      <?php
        session_start();
        print_r($_SESSION);

        $conn = mysqli_connect("localhost", "root", "", "sportsking");
        if(isset($_SESSION['EMAIL'])) {
        $user_id = $_SESSION['USER_ID'];
        }
      ?>

      <!doctype html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>SportsKing Mens</title>
          <link rel="stylesheet" href="assets/index_style.css">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
          <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
            #link {
              font-family:'Open Sans', sans-serif;
            }
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bebas+Neue&family=Iceland&family=Open+Sans:wght@300&display=swap');
            .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
          }

          .login-button {
            margin-top:-20px;
            display: inline-block;
            padding:20px 20px;
            width:30%;
            background-color: blue;
            color: white;
            text-decoration: none;
            font-size: 30px;
            border-radius: 5px;
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
              <a class="nav-link" href="basket.php">
                  <a class="nav-link" href="basket.php">BASKET</a>
                  </a>
                <?php 
                  if(isset($_SESSION['EMAIL'])) {
                    if (isset($_SESSION['EMAIL']) && (!$_SESSION['EMAIL'] == 'admin@sportsking.com')) {
                      echo '<li class="nav-item"><a class="nav-link" href="my_orders.php">MY ORDERS</a></li>';
                    }
                  }
                  if(isset($_SESSION['EMAIL'])) {
                    echo '<a class="nav-link" href="logout.php">LOGOUT</a>';
                  }
                  else {
                    echo '<a class="nav-link" href="login.php">LOGIN</a>';
                  } 
                ?>
                </div>
                </div>
                </nav>

      <?php
      if(isset($_POST['buy']) && !empty($_SESSION['basket'])) {
        $heading = 'Order Confirmation';
        } else {
          $heading = "Your Basket";
        }

        echo "<div id='opening-header' class='jumbotron'>
        <h1> $heading </h1>";
        echo '</div>';
      ?>



      <?php
      // User must be logged in 
      if(isset($_SESSION['EMAIL'])) {
        if(isset($_POST["add_to_basket"]))
        {
          //If user adds product to basket, its product id and quantity the user desires will be posted to the script
            $product_id = $_POST["product_id"];
            $quantity = $_POST['quantity'];
    
            // Query that will check the number of that product that is in stock
            $sql_check_stock = "SELECT Quantity FROM products WHERE ProductID = $product_id";
            $res_check_stock = mysqli_query($conn, $sql_check_stock);
            $row_check_stock = mysqli_fetch_assoc($res_check_stock);
            $available_stock = $row_check_stock['Quantity'];

            // If quantity desired by user is more than available stock we display this message 
            if ($quantity > $available_stock) {
                echo "<h1  class= 'text-center'style='border-radius:5px;margin:20px 20px;background-color:red;'> We only have $available_stock of Product $product_id left.</h1>";
            } else { 
                if(isset($_SESSION["basket"]))
                {
                    $basket_items = array_column($_SESSION["basket"], "product_id");
                    if(!in_array($_POST['product_id'], $basket_items))
                    {
                        $count = count($_SESSION["basket"]);
                        $item_array = array(
                            'product_id' => $_POST["product_id"],
                            'product_name' => $_POST['product_name'],
                            'product_price' => $_POST['product_price'],
                            'product_quantity' => $_POST['quantity'], 
                            'product_image' => $_POST['image']
                        );
                        $_SESSION["basket"][$count] = $item_array;
                    }
                    else
                    {
                        foreach($_SESSION['basket'] as $keys => $values) {
                            if($values['product_id'] == $_POST['product_id']) {
                                $_SESSION["basket"][$keys]['product_quantity'] += $_POST['quantity'];
                            }
                        }
                    }
                }
                else
                {
                    $item_array = array(
                        'product_id' => $_POST['product_id'],
                        'product_name' => $_POST['product_name'],
                        'product_price' => $_POST['product_price'],
                        'product_quantity' => $_POST['quantity'],
                        'product_image' => $_POST['image']
                    );
                    $_SESSION["basket"][0] = $item_array;
                }
            }
        }
    
        if(isset($_GET["action"])) {
            if($_GET["action"] == "delete") {
                if(isset($_SESSION["basket"])) {
                    foreach($_SESSION["basket"] as $keys => $values) {
                        if($values["product_id"] == $_GET["id"]) { 
                            unset($_SESSION["basket"][$keys]); 
                            echo '<script>alert("Item removed from cart")</script>';
                            echo '<script>window.location="mens.php"</script>';
                        }
                    }
                }
            }
        }
    } else {
        echo '<h1 style="color:white;margin: 20px 20px; border-radius:5px;background-color:red;border:1px solid red;padding:10px;" class="text-center">Please log in to add products to the basket</h1>';
        echo '<h4 class="text-center"> Continue to Login Below </h5>';
        echo '<div class="button-container">
          <a href="login.php" class="login-button">Login</a>
        </div>';
    }
      ?>
      <?php if(isset($_SESSION['EMAIL'])) { ?>  
      <div style="clear:both"></div>
      <br />
      <h2 id ="basket-heading" style= "margin: 0 20px; margin-bottom:20px;">Your Basket</h2>
      <div class="table-responsive" style= "margin: 0 20px;">
          <table id="basket-table" style ="border:2px solid black;" class="table table-bordered">
              <tr>
                  <th width="20%">Product Name</th>
                  <th width="20%">Product Quantity</th>
                  <th width="20%">Product Image</th>
                  <th width="10%">Price</th>
                  <th width="15%">Total</th>
                  <th width="5%">Action</th>
              </tr>
              <?php
              if(!empty($_SESSION["basket"])) {
                  $total = 0;
                  foreach($_SESSION["basket"] as $keys => $values) {
              ?>
              <tr>
                  <td><?php echo $values["product_name"]; ?></td>
                  <td><?php echo $values["product_quantity"]; ?></td>
                  <td><img style="margin: 0 55" src="<?php echo $values['product_image']; ?>" alt="<?php echo $values['product_name']; ?>" width="200" height="200" justify-content-center></td>
                  <td>£<?php echo $values["product_price"]; ?></td>
                  <td>£<?php echo number_format($values["product_quantity"] * $values["product_price"], 2);?></td>
                  <td>
                  <form action="basket.php?action=delete&id=<?php echo $values["product_id"]; ?>" method="post">
                    <button type="submit" class="btn btn-danger">
                      Remove
                    </button>
                  </form>
                  </td>
              </tr>
              <?php
                      $total = $total + ($values["product_quantity"] * $values["product_price"]);
                  }
              ?>
              <tr>
                  <td colspan="3" align="right">Total</td>
                  <td align="left">£<?php echo number_format($total, 2); ?></td>
                  <td></td>
              </tr>
              <?php
              }
              ?>
          </table>
      </div></div> </div><br />
      <?php } ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="customer_id" value="<?php echo $user_id ?>">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <?php if(isset($_SESSION['EMAIL'])) {?><button type="submit" name="buy" class="btn btn-primary" style="float:left; margin-bottom:20px;margin-left:20px;font-size:24px;">Buy Now</button><?php } ?>
      </form>

      <div id="order-success-msg"></div>

      <?php 
      // if buy button is clicked, the details of the order will be posted into the orders database. 
      if(isset($_POST['buy']) && !empty($_SESSION['basket'])) {
        echo '<script>document.querySelector("button[name=buy]").disabled = true;</script>';

        $customer_id = $_POST['customer_id'];
        $total = $_POST['total'];
        $date= date('Y-m-d H:i:s');
        



        $sql = "INSERT INTO orders(OrderDate, OrderTotal, CustomerID) VALUES ('$date', '$total', '$customer_id')";
        $res = mysqli_query($conn, $sql);

        if($res) {
          $sql = "SELECT LAST_INSERT_ID()";
          $res = mysqli_query($conn,$sql);
          $row = mysqli_fetch_assoc($res);
          $order_id = $row['LAST_INSERT_ID()'];
          echo '<script>
          document.querySelector("button[name=buy]").style.display = "none";
          document.querySelector("#basket-table").style.display = "none";
          document.querySelector("#basket-heading").style.display = "none";

        </script>';
        // If the order is placed successfully, a success message will be displayed to the user and details of the order will be shown back to them. 
          $msg = "Order placed successfully!";
          echo '<div id="success-message" class="text-center" style="width:50%; font-size: 30px; margin: 20px auto; border: 1px solid green; border-radius:20px; background-color:green; color: white; display: <?php echo (!empty($msg)) ? "block" : "none"; ?>';
          if (!empty($msg)) {
            echo $msg;
            } 
            echo '</div>';
            echo '<h1 class="text-center" style="margin-bottom:30px;"> Thank You For Shopping at Sportsking!</h1>';
      echo '<div style="margin: 0 20px; border: 2px solid black; padding: 10px;">';
      echo '<h1> Order Receipt </h1>';
      $sql = "SELECT * FROM orders WHERE OrderID = $order_id";
      $result = mysqli_query($conn, $sql);
      $order = mysqli_fetch_assoc($result);
      $order_date = $order['OrderDate'];
      echo "<h5> Order Number: $order_id </h5>";
      echo "<h5> Order Date : $order_date </h5>";
      $sql = "SELECT FirstName, LastName from customers WHERE CustomerID = $user_id";
      $result = mysqli_query($conn, $sql);
      $orderName = mysqli_fetch_assoc($result);
      $customerName = $orderName['FirstName'] . ' ' . $orderName['LastName'];
      echo "<h5> Customer Name: $customerName </h5>";
      echo "</div>";
      echo '<div class="table-responsive" style= "margin: 0 20px;">
      <table id="basket-table" style ="border:2px solid black;" class="table table-bordered">';
      echo '<tr>';
      echo '<th>Product Name</th>';
      echo '<th>Quantity</th>';
      echo '<th>Price</th>';
      echo '<th>Total Price</th>';
      echo '</tr>';


      $total_order_price = 0; 

      foreach($_SESSION['basket'] as $product) {
          $product_id = $product['product_id'];
          $quantity = $product['product_quantity'];
          $total_product_price = $product['product_price'] * $product['product_quantity'];
          $sql = "INSERT INTO orderproduct(OrderID, ProductID, Quantity, ProductTotal) VALUES ($order_id, $product_id, $quantity, $total_product_price)";
          $res = mysqli_query($conn, $sql);

          
          $sql = "SELECT * FROM orderproduct WHERE OrderID = $order_id AND ProductID = $product_id";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $quantity = $row['Quantity'];
          $product_total = $row['ProductTotal'];

          $sql = "SELECT * FROM products WHERE ProductID = $product_id";
          $product_result = mysqli_query($conn, $sql);
          $product = mysqli_fetch_assoc($product_result);

          
          $total_order_price += $product_total;

        
          echo '<tr>';
          echo '<td>'.$product['ProductName'].'</td>';
          echo '<td>'.$quantity.'</td>';
          echo '<td>£'.$product['Price'].'</td>';
          echo '<td>£'.$product_total.'</td>';
          echo '</tr>';
      }

      echo '</table>';
      echo '<div class="table table-bordered" style="margin-top: 20px; border: 2px solid black; padding: 10px;">';
      echo '<h4>Total Order Price: £' . $total_order_price . '</h4>';
      echo '</div>';
      echo '</div>';
      


        ?>

            <?php 
            // After each purchase, the product table in the database will updated with a new quantity of that product. 
            if(!$res) {
              echo "Error occured : " . mysqli_error($conn);
            }
          }

          foreach($_SESSION['basket'] as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['product_quantity'];
            $total_product_price = $product['product_price'] * $product['product_quantity'];
          

            $sql = "UPDATE products SET Quantity = Quantity - $quantity WHERE ProductID = $product_id";
            $res = mysqli_query($conn, $sql);
          
            if(!$res) {
              echo "Error occurred: " . mysqli_error($conn);
            }
          }
          
          $_SESSION['basket'] = array();
      }

      ?>

              <br>
              <br>
              <br>
              <br>
              <br>

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



        </body> </html>
      <?php

      //Debugging tools.Delete or uncomment as needed */
      //print_r($_SESSION). "<br>";
      "<br>";
      //echo var_dump($total) . "<br>";
      //echo var_dump($values["item_quantity"]) . "<br>";
      //echo var_dump($values["item_price"]) . "<br>";
      //get_defined_vars() gets all the defined variables including built-ins and custom variables (print_r to view them)}*/
      $total = get_defined_vars();


      //print_r($total);
      //Dumps the variable with its reference counts. This is useful when there are multiple paths to update a single reference.*/
      //debug_zval_dump ($total)

      ?>


