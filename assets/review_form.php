<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "review_input";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "INSERT INTO reviews (CustomerName, ProductName, ReviewTitle, Review)
    VALUES ('".$_POST["customer_name"]."', '".$_POST["product"]."','".$_POST["title"]."', '".$_POST["review"]."')";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();

    ?>