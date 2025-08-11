<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Search.css"> 
</head>
<body>

    <header>
        <h1>Library System</h1>
    </header>

    <nav>
    <div class="Options">
    <a class = "Options" href = "Search.php">Search </a>
    <?php
        echo ('<a class = "nav-item nav-link active" href="Show_Reserve.php?Position='.htmlentities($Position).'">Reserved Books</a>');
    ?>
    </div>
    <div id = "message_login_register">
    <?php
        echo "Please log in to access the system";
    ?>
    </div>
    <div class = "Logout">
    <?php
        echo "Not logged in";
    ?>
    </div>

    </nav>

    <section class = "Login_Search_Register_box">
        <p> Login Page </p>
        <p> Please login to start </p>
        <form method="post">
        <p>Username:
        <input type="text" name="Username" required></p>
        <p>Password:
        <input type="Password" name="Password" required></p>
        <p><input type="submit" name = "Login" value="Login"/></p>
        </form>
    </section>
    
    <div class = "Login_Search_Register_box">
        <p>Have not registered before?</p>
        <a id = "Inside_Login_Register_button" href="Registration.php">
            <button type = "button">
                Register
            </button>
        </a>
    </div>
    <pre> 
        <?php
            session_start();
            unset($_SESSION["Username"]);
            if (isset($_POST["Login"]))
            {
                require_once("Connect.php");
                $sql = "SELECT Username, Password FROM Users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if ($row["Username"] == $_POST['Username'] && $row["Password"] == $_POST['Password']) 
                    {
                        $_SESSION["Username"] = htmlentities($_POST["Username"]);
                        $_SESSION["success"] = "Logged in";
                        header("Location: Search.php");
                        return;
                    }
                    else if (empty($_POST['Username']) == FALSE && empty($_POST['Password']) == FALSE) 
                    {
                        $_SESSION["error"] = "Incorrect Password or Username";
                        header("Location: Login.php");
                    }
                    else{
                        $_SESSION["error"] = "Missing information";
                        header("Location: login.php");
                    }
                 }
                }
            
                $conn->close();
            }

        ?>
    </pre>


    <?php
        if (isset($_SESSION["error"]))
        {
            echo "Error: ". $_SESSION["error"];
            unset($_SESSION["error"]);
        }
    ?>



    <footer>
        <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>



</body>
</html>