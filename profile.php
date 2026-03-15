<?php
session_start();
include "config.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h2>My Memories</h2>
<div class="nav">
    <a href="dashboard.php">Home</a> | 
    <a href="logout.php">Logout</a>
</div>
<hr>

<div class="memory-wall">
<?php
$result = mysqli_query($conn,"SELECT * FROM posts WHERE username='$username' ORDER BY id DESC");
while($row = mysqli_fetch_assoc($result)){
    echo "<div class='post'>";
    echo "<h4>".$row['caption']."</h4>";
    echo "<div class='img-container'>";
    echo "<img src='uploads/".$row['image']."' alt='Memory'>";
    echo "</div>";
    echo "<p>Posted by ".$row['username']."</p>";
    echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
    echo "<a href='delete.php?id=".$row['id']."'>Delete</a>";
    echo "</div>";
}
?>
</div>

</div>
</body>
</html>