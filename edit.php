<?php
include "config.php";

$id=$_GET['id'];

$result=mysqli_query($conn,"SELECT * FROM posts WHERE id='$id'");
$row=mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$caption=$_POST['caption'];

mysqli_query($conn,"UPDATE posts SET caption='$caption' WHERE id='$id'");

header("Location: dashboard.php");

}
?>

<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<h2>Edit Memory</h2>

<form method="POST">

<input type="text" name="caption" value="<?php echo $row['caption']; ?>">

<button name="update">Update</button>

</form>

</div>

</body>
</html>