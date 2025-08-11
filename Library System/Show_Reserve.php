<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Books</title>
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
    $Username = $_SESSION["Username"];
    $Author = array();
    $BookTitle = array();
    $ISBN = array();
    $reservedDate = array();
    $Edition = array();
    $Year = array();
    $Category = array();
    $x = 0;
    $count = 0;
    $Position = $conn -> real_escape_string($_GET['Position']);
    $New_Position = $Position + 5;
    $sql = "SELECT ISBN, ReservedDate FROM Reservations WHERE Username = '$Username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc())
        {
            $ISBN[$x] = $row["ISBN"];
            $ReservedDate[$x] = $row["ReservedDate"];

            $sql2 = "SELECT BookTitle, Author, Edition, Year, CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE ISBN = '$ISBN[$x]'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc())
                {
                        $BookTitle[$x] = $row2['BookTitle'];
                        $Author[$x] = $row2['Author'];
                        $Edition[$x] = $row2['Edition'];
                        $Year[$x] = $row2['Year'];
                        $Category[$x] = $row2['CategoryDescription'];
                        $x = $x + 1;
                }
            }
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

        <div class = "display_box">
        <table style = "border: 1px solid black;">
            <tr>
                <th>ISBN</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Year</th>
                <th>Category</th>
                <th>Reserved Date</th>
                <th>Unreserve</th>
            </tr>

        <?php
        for($Position = $Position; $Position < $New_Position && $Position < count($ISBN); $Position++)
        {
            echo ('<tr><td>');
            echo $ISBN[$Position];
            echo ("</td><td>");
            echo $BookTitle[$Position];
            echo ("</td><td>");
            echo $Author[$Position];
            echo ("</td><td>");
            echo  $Edition[$Position];
            echo ("</td><td>");
            echo  $Year[$Position];
            echo ("</td><td>");
            echo  $Category[$Position];
            echo ("</td><td>");
            echo  $ReservedDate[$Position];
            echo ("</td><td>");
            echo ('<a href="Unreserve.php?ISBN='.htmlentities($ISBN[$Position]).'">Unreserve</a>');
            echo ("</td></tr>");
            $count = $count + 1;
        }
        echo "</table>";
        echo "</div>";

    
        if($Position > 5)
        {
            echo ('<a class = "page" href="Show_Reserve.php?Position='.htmlentities($Position-($count + 5)).'">Previous Page</a>');
        } 
        else
        {
            echo ('<a class = "page">Previous Page</a>');
        }

        if($Position < count($ISBN))
        {
            echo ('<a class = "page" href="Show_Reserve.php?Position='.htmlentities($Position).'">Next Page</a>');
        }
        else
        {
            echo ('<a class = "page">Next page</a>');
        }
    }
    else
    {
        echo '<div class = "display_box">';
        echo "You have no books reserved";
        echo '</div>';
    }
    $conn->close();



?>


    <footer style="position: fixed; bottom: 0;">
            <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>




<?php } ?>
</body>
</html>