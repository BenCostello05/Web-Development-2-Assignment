<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="Search.css"> 
</head>

<body>
<?php 
    session_start();
    if( !isset($_SESSION["Username"])) 
    {
        header("Location:Login.php");
    }else{ 
        $Position = 0
?>


<header>
    <h1>Library System</h1>
</header>

<nav>
    <div class = "Options">
    <a class = "Options" href = "Search.php">Search</a>
    <?php
        echo ('<a class = "nav-item nav-link active" href="Show_Reserve.php?Position='.htmlentities($Position).'">Reserved Books</a>');
    ?>
    </div>
    <div class = "Text">
    <?php
        echo "Logged in as: " . $_SESSION["Username"];
    ?>
    </div>
    <div class = "Logout">
    <?php
        echo ('<a class = "nav-item nav-link active" href="Logout.php">Logout</a>');
    ?>
    </div>

</nav>

<section>
    <a class = "Selection" href="Category.php">
        <button type = "button">
            Search by <br>
            Category
        </button>
        <br></br>
    </a>

        <a class = "Selection" href="Search_Reserve.php">
            <button type = "button">
                Search by <br>
                Author <br> and/or <br> Book Title
        </button>
        <br></br>
    </a>
</section>

<footer>
    <p>©Created by Ben Costello. All Rights Reserved.</p>
</footer>


<?php $conn->close();} ?>



</body>
</html>