<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Search.css"> 

    
</head>
<body>

    <?php
        session_start();
        if( !isset($_SESSION["Username"])) 
        {
            header("Location:Login.php");
        }else{

            $Position = 0;
    ?>

    <header>
        <h1>Library System</h1>
    </header>

    <nav>
    <div class = "Options">
    <a class = "Options" href = "Search.php">Search </a>
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

    <div class = "Login_Search_Register_box"> 
        <p>Search for a book </p>
        <form method="post">
        <p>Book Title:
        <input type="text" name="Title"></p>
        <p id = "padding_and_or"> and/or </p>
        <p>Author:
        <input type="text" name="Author"></p>
        <p><input type="submit" name = "Search" value="Search"/></p>
        </form>
    </div>

    <div>
        <a id = "InsideTitleAuthor" href="Category.php">
            <button type = "button">
                Search by Category
            </button>
        </a>
    </div>

    <?php
        if (isset($_POST['Search']))
        {
            require_once("Connect.php");
            if(empty($_POST["Title"]) && empty($_POST["Author"]))
            {
                header("Location: Search_Reserve.php");
            }
            else
            {
                header("Location: Show_BookTitle_Author.php?Title=".htmlentities($_POST["Title"])."&Author=".htmlentities($_POST["Author"])."&Position=".htmlentities($Position));
            }
            
            $conn->close();
        }

    ?>

    <footer>
        <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>
    
    <?php } ?>
</body>
</html>