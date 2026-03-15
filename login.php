<?php
session_start();
include("config.php");

$error = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($username == "" || $password == ""){
        $error = "Please enter both username and password";
    } else {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn,$query);

        if($result && mysqli_num_rows($result) > 0){
            $_SESSION['username'] = $username;  
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h2>Login</h2>
    <?php if($error != "") { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

</div>
</body>
</html>