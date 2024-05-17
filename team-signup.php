<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>team-signup</title>
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
    
        <h2 class="text-center mb-4">sign up as team</h2>
        <form action='team-signup.php' method='POST'>
        <div class="form-group">
            <label for="name">Team name:</label>
            <input type="text" class="form-control" id="name" name='name' placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name='email' placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name='password' placeholder="password">
        </div><br>
        <div class="form-group">
            <label for="memeber1">memeber1:</label>
            <input type="text" class="form-control" id="memeber1" name='member1' placeholder="memeber1">
        </div><br>
        <div class="form-group">
            <label for="memeber2">memeber2:</label>
            <input type="text" class="form-control" id="memeber2" name='member2' placeholder="memeber2">
        </div><br>
        <div class="form-group">
            <label for="memeber3">memeber3:</label>
            <input type="text" class="form-control" id="memeber3" name='member3' placeholder="memeber3">
        </div><br>
        <div class="form-group">
            <label for="memeber4">memeber4:</label>
            <input type="text" class="form-control" id="memeber4" name='member4' placeholder="memeber4">
        </div><br>
        <div class="form-group">
            <label for="memeber5">memeber5:</label>
            <input type="text" class="form-control" id="memeber5" name='member5' placeholder="memeber5">
        </div><br>
        <div class="form-group form-check">
        </div>
        <center>

            <h6>sign up as a <a href="ind-signup.php">user</a></h6>
            <h6>log in as a <a href="ind-login.php">user</a>, <a href="team-login.php">team</a> or <a href="admin-login.php">admin</a></h6>
        <button type="submit" class="btn btn-primary btn-block">sign up</button></center><br>
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
    $member1 = $_POST['member1'];
    $member2 = $_POST['member2'];
    $member3 = $_POST['member3'];
    $member4 = $_POST['member4'];
    $member5 = $_POST['member5'];
    $check_email_query = "SELECT * FROM teams WHERE email = '$email'";
    $email_result = $conn->query($check_email_query);

    $check_name_query = "SELECT * FROM teams WHERE team_name = '$name'";
    $name_result = $conn->query($check_name_query);

    if ($email_result->num_rows > 0) {
        echo "<center>team with this email already exists</center>";
    } elseif ($name_result->num_rows > 0) {
        echo "<center>team with this name already exists</center>";
    } else {
        $sql = "INSERT INTO teams (team_name, email, password,member1,member2,member3,member4,member5) VALUES ('$name', '$email', '$password','$member1','$member2','$member3','$member4','$member5' )"; 

        if ($conn->query($sql) === TRUE) { 
                header('Location: team-login.php'); 
            exit; 
        } else { 
            echo "Error: " . $sql . "<br>" . $conn->error; 
        } 
    }
}
// ------