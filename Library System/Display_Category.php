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
    require_once("Connect.php");
    $Category = $conn -> real_escape_string($_GET['Category']);
    $Position = $conn -> real_escape_string($_GET['Position']);
    $New_Position = $Position + 5;
    $BookTitle = array();
    $Author = array();
    $ISBN = array();
    $Reserved = array();
    $Edition = array();
    $Year = array();
    $Category_array = array();
    $x = 0;
    $count = 0;
    $sql = "SELECT ISBN, BookTitle,Author, Edition, Year, Reserved, CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID where CategoryCode = $Category + 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        //echo "<table border='1'>";
        while($row = $result->fetch_assoc()) 
        {
            $BookTitle[$x] = $row["BookTitle"];
            $Author[$x] = $row["Author"];
            $ISBN[$x] = $row["ISBN"];
            $Reserved[$x] = $row["Reserved"];
            $Edition[$x] = $row["Edition"];
            $Year[$x] = $row["Year"];
            $Category_array[$x] = $row["CategoryDescription"];
            $x = $x + 1;
        }
    }
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

    <?php

    if (count($BookTitle) > 0)
    {
        ?>

        <div class = "display_box" style = "margin-top: 3%;">
        <table style = "border: 1px solid black;">
            <tr>
                <th>ISBN </th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Year</th>
                <th>Category</th>
                <th>Reservable</th>
            </tr>

        <?php

        for($Position = $Position; $Position < $New_Position && $Position < count($Author); $Position++)
        {
            echo ('<tr><td>');
            echo $ISBN[$Position];
            echo ("</td><td>");
            echo $BookTitle[$Position];
            echo ("</td><td>");
            echo $Author[$Position];
            echo ("</td><td>");
            echo $Edition[$Position];
            echo ("</td><td>");
            echo $Year[$Position];
            echo ("</td><td>");
            echo $Category_array[$Position];
            echo ("</td><td>");


            if($Reserved[$Position] == "N")
            {
                
                echo ('<a href="Reserve.php?ISBN='.htmlentities($ISBN[$Position]).'">Reserve</a>'. "<br>");
                echo ("</td></tr>");
            }
            else
            {
                echo " Not Reservable <br> ";
                echo ("</td></tr>");
            }
            $count = $count + 1;
        }
        echo "</table>";
        echo "</div>";

        if($Position > 5)
        {
            echo ('<a class = "page" href="Display_Category.php?Position='.htmlentities($Position-($count + 5)).'&Category='.htmlentities($Category).'">Previous Page</a>'. " ");
        }
        else
        {
            echo ('<a class = "page">Previous Page</a>');
        }

        if($Position < count($Author))
        {
            echo ('<a class = "page" href="Display_Category.php?Position='.htmlentities($Position).'&Category='.htmlentities($Category).'">Next Page</a>'. " ");
        }
        else
        {
            echo ('<a class = "page">Next page</a>');
        }

    }
    else
    {
        echo '<div class = "display_box" style = "margin-bottom: 3%;">';
        echo "There are no books in this category";
        echo '</div>';
    }

    $conn->close();

}
?>

    <div>
    <a id = "InsideCategory" href="Category.php">
            <button style = "margin-top: 0px;" type = "button">
                Go back to search
        </button>
    </a>
    </div>

    <footer style="position: fixed; bottom: 0;">
            <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>

</body>
</html>