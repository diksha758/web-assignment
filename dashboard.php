<?php
session_start();
include "config.php";



if(isset($_POST['comment_btn'])){

$post_id = $_POST['post_id'];
$comment = $_POST['comment'];
$username = $_SESSION['user'];

if($comment != ""){

$query = "INSERT INTO comments(post_id,username,comment)
VALUES('$post_id','$username','$comment')";

mysqli_query($conn,$query);

header("Location: dashboard.php");
exit();

}

}

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


if(isset($_POST['post'])){
    $caption = $_POST['caption'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if($caption=="" || $image==""){
        $error = "Please fill all fields";
    } else {
        $image = time() . "_" . $image; 
        move_uploaded_file($tmp,"uploads/".$image);

        $query = "INSERT INTO posts(caption,image,username) VALUES('$caption','$image','$username')";
        mysqli_query($conn,$query);

        header("Location: dashboard.php");
        exit();
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h2>Welcome <?php echo $username; ?></h2>

    
    <div class="nav">
        <a href="dashboard.php">Home</a> | 
        <a href="profile.php">My Account</a> | 
        <a href="logout.php">Logout</a>
    </div>
    <hr>

    
    <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>


    <h3>Post a Memory</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="caption" placeholder="Write a caption" required>
        <input type="file" name="image" required>
        <button name="post">Post</button>
    </form>
    

    <hr>


    <h3>Campus Memories</h3>
    <div class="memory-wall">
    <?php
    $result = mysqli_query($conn,"SELECT * FROM posts ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($result)){

        echo "<div class='post'>";
        echo "<h4>".$row['caption']."</h4>";
        echo "<div class='img-container'>";
        echo "<img src='uploads/".$row['image']."' alt='Memory'>";
        echo "</div>";
        echo "<p>Posted by ".$row['username']."</p>";
        
$post_id = $row['id'];


$comments = mysqli_query($conn, "SELECT * FROM comments WHERE post_id='$post_id'");

while($c = mysqli_fetch_assoc($comments)) {
    echo "<p class='comment'><b>".$c['username']."</b>: ".$c['comment']."</p>";
    
}  

        
        if($row['username'] == $username){
            echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
            echo "<a href='delete.php?id=".$row['id']."'>Delete</a>";
        }
        echo "</div>";
    }
    ?>
    </div>

</div>
</body>
</html>