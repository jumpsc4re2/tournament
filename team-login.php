<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>team-login</title>
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
    
        <h2 class="text-center mb-4">Log in as team</h2>
        <form action='team-login.php' method='POST'>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name='email' placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name='password' placeholder="password">
        </div><br>
        <div class="form-group form-check">
        </div>
        <center>     
        <h6>login as a <a href="ind-login.php">user</a> or <a href="admin-login.php">admin</a></h6>
        <h6>sign up as a <a href="ind-signup.php">user</a> or <a href="team-signup.php">team</a></h6>
        <button type="submit" class="btn btn-primary btn-block">Log in</button></center><br>
        </form>
    </div>
    </div>

</body>
</html>
<?php
include 'config.php';

$teamid = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT id FROM teams WHERE email = ? AND password = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $stmt->bind_result($teamid);
            if ($stmt->fetch()) {
                header("location: team-home.php?id=$teamid");
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}