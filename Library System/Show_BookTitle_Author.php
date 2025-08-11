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

    $Search_BookTitle = $conn -> real_escape_string($_GET['Title']);
    $Search_Author = $conn -> real_escape_string($_GET['Author']);
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
    $y = 0;
    $count = 0;
    $found = FALSE;


    if (!empty($Title) && !empty($Author))
    {

        $sql = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE BookTitle = '$Search_BookTitle' AND Author = '$Search_Author'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $BookTitle[$x] = $row["BookTitle"];
                $Author[$x] = $row["Author"];
                $ISBN[$x] = $row["ISBN"];
                $Reserved[$x] = $row["Reserved"];
                $Edition[$x] = $row["Edition"];
                $Year[$x] = $row["Year"];
                $Category_array[$x] = $row["CategoryDescription"];
                $found = True;
                $x = $x + 1;
            }
        }


        if ($found == FALSE)
        {
            
            $sql2 = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE BookTitle like '%$Search_BookTitle%' AND Author like '%$Search_Author%'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0)
            {
                while($row2 = $result2->fetch_assoc())
                {
                    $BookTitle[$x] = $row2["BookTitle"];
                    $Author[$x] = $row2["Author"];
                    $ISBN[$x] = $row2["ISBN"];
                    $Reserved[$x] = $row2["Reserved"];
                    $Edition[$x] = $row2["Edition"];
                    $Year[$x] = $row2["Year"];
                    $Category_array[$x] = $row2["CategoryDescription"];
                    $y = $y + 1;
                    $x = $x + 1;
                    $found = True;

                }
            }
        }


    }
    elseif (empty($Title) && !empty($Author))
    {

        $sql = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE Author = '$Search_Author'";
        $result = $conn->query($sql);
        echo"Results: <br>";
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $BookTitle[$x] = $row["BookTitle"];
                $Author[$x] = $row["Author"];
                $ISBN[$x] = $row["ISBN"];
                $Reserved[$x] = $row["Reserved"];
                $Edition[$x] = $row["Edition"];
                $Year[$x] = $row["Year"];
                $Category_array[$x] = $row["CategoryDescription"];
                $found = True;
                $x = $x + 1;
            }
        }
        
        if ($found == FALSE)
        {
            
            $sql2 = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE Author like '%$Search_Author%'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0)
            {
                while($row2 = $result2->fetch_assoc())
                {
                    $BookTitle[$x] = $row2["BookTitle"];
                    $Author[$x] = $row2["Author"];
                    $ISBN[$x] = $row2["ISBN"];
                    $Reserved[$x] = $row2["Reserved"];
                    $Edition[$x] = $row2["Edition"];
                    $Year[$x] = $row2["Year"];
                    $Category_array[$x] = $row2["CategoryDescription"];
                    $x = $x + 1;
                    $found = True;
                }
            }
        }
    
    }
    else
    {
        $sql = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE BookTitle = '$Search_BookTitle'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $BookTitle[$x] = $row["BookTitle"];
                $Author[$x] = $row["Author"];
                $ISBN[$x] = $row["ISBN"];
                $Reserved[$x] = $row["Reserved"];
                $Edition[$x] = $row["Edition"];
                $Year[$x] = $row["Year"];
                $Category_array[$x] = $row["CategoryDescription"];
                $found = True;
                $x = $x + 1;
            }
        }
        
        if ($found == FALSE)
        {
            
            $sql2 = "SELECT ISBN,BookTitle,Author,Edition,Year,Reserved,CategoryDescription FROM Books join Category ON Books.CategoryCode = Category.CategoryID WHERE BookTitle like '%$Search_BookTitle%'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) 
            {
                while($row2 = $result2->fetch_assoc())
                {
                    $BookTitle[$x] = $row2["BookTitle"];
                    $Author[$x] = $row2["Author"];
                    $ISBN[$x] = $row2["ISBN"];
                    $Reserved[$x] = $row2["Reserved"];
                    $Edition[$x] = $row2["Edition"];
                    $Year[$x] = $row2["Year"];
                    $Category_array[$x] = $row2["CategoryDescription"];
                    $x = $x + 1;
                    $found = True;
                }
            }
        } 
    }

    if ($found == FALSE)
    {
        echo '<div class = "display_box" style = "margin-bottom: 3%;">';
        echo"No Results found";
        echo '</div>';
    }
    else
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
        for($Position = $Position; $Position < $New_Position && $Position < count($BookTitle); $Position++)
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
            echo ('<a href="Show_BookTitle_Author.php?Position='.htmlentities($Position-($count + 5)).'&Title='.htmlentities($Search_BookTitle).'&Author='.htmlentities($Search_Author).'">Previous Page</a>'. " ");
        }
        else
        {
            echo ('<a class = "page">Previous Page</a>');
        }

        if($Position < count($BookTitle))
        {
            echo ('<a href="Show_BookTitle_Author.php?Position='.htmlentities($Position).'&Title='.htmlentities($Search_BookTitle).'&Author='.htmlentities($Search_Author).'">Next Page</a>'. " ");
        }
        else
        {
            echo ('<a class = "page">Next page</a>');
        }

    }
        $conn->close();
    }
    
?>
    
    <div>
    <a id = "InsideTitleAuthor" href="Search_Reserve.php">
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