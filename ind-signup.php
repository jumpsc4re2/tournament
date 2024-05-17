<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>user-login</title>
</head>
<body>

<style>
    .login-container {
      max-width: 400px;
      margin: auto;
      margin-top: 100px;
    }
    h2{
        padding-top:10px
    }
    </style>

    <div class="container">
    <div class="login-container">
    
        <h2 class="text-center mb-4">sign up as user</h2>
        <form action='ind-signup.php' method='POST'>
        <div class="form-group">
            <label for="name">name:</label>
            <input type="text" class="form-control" id="name" name='name' placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name='email' placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name='password' placeholder="Enter password">
        </div><br>
        <div class="form-group form-check">
        </div>
        <center>
            <h6>sign up as a <a href="team-signup.php">team </a></h6>
            <h6>log in as a <a href="ind-login.php"> user </a>, <a href="team-login.php">team</a> or <a href="admin-login.php">admin</a></h6>
            
        <button type="submit" class="btn btn-primary btn-block">Sign up</button></center><br>
        </form>
    </div>
    </div>

</body>
</html>
<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

// ------
$check_email_query = "SELECT * FROM individuals WHERE email = '$email'";
    $email_result = $conn->query($check_email_query);

    $check_name_query = "SELECT * FROM individuals WHERE name = '$name'";
    $name_result = $conn->query($check_name_query);

    if ($email_result->num_rows > 0) {
        echo "<center>User with this email already exists</center>";
    } elseif ($name_result->num_rows > 0) {
        echo "<center>User with this name already exists</center>";
    } else {
        $sql = "INSERT INTO individuals (name, email, password) VALUES ('$name', '$email', '$password')"; 

        if ($conn->query($sql) === TRUE) { 
            header('Location: ind-login.php'); 
            exit; 
        } else { 
            echo "Error: " . $sql . "<br>" . $conn->error; 
        } 
    }
}
// ------



?>