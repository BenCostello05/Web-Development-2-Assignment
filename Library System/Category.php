<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search By Category</title>
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
        require_once("Connect.php");
        $categories = array();
        $x = 0;
        $sql = "SELECT CategoryDescription FROM Category";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc())
            {
                $categories[$x] = $row["CategoryDescription"];
                $x += 1;
            }
        }

        if (isset($_POST['Search']))
        {
            if (isset($_POST["Category"]) !== FALSE && $_POST["Category"] != 9)
            {
                header("Location: Display_Category.php?Category=".htmlentities($_POST["Category"])."&Position=".htmlentities($Position));
            }
        }

        $conn->close();
    ?>

    <div>
    <form id = "Search_Category" method="post">
        <label for="category">Which Category do you want to search by: <br>
        <select id = "Menu" name="Category">
            <option value="9">-- Please Select -- </option>
            <?php
                foreach ($categories as $k => $v)
                {
                    echo "<option value=$k>$v</option>";
                }
            ?>
        </select> 
        <br>
        <input type="submit" name = "Search" value="Search"/>
    </form>
    </div>

    <div>
    <a id = "InsideCategory" href="Search_Reserve.php">
            <button type = "button">
                Search by Author and/or Book Title
        </button>
    </a>
    </div>
    

    <footer>
        <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>
    
    <?php } ?>





</body>
</html>