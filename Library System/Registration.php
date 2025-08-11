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

    <?php
        if (isset($_POST['submit'])){
            require_once "Connect.php";
            $exists = FALSE;
            if (empty($_POST['Username']) == FALSE && empty($_POST['Password']) == FALSE && empty($_POST['ConfirmPassword']) == FALSE && empty($_POST['Firstname']) == FALSE  && empty($_POST['Surname']) == FALSE && empty($_POST['Address1']) == FALSE && empty($_POST['Address2']) == FALSE && empty($_POST['City']) == FALSE && empty($_POST['Telephone']) == FALSE && empty($_POST['Mobile']) == FALSE)
            {
                if (strlen($_POST['Mobile']) == 10)
                {
                    if(strlen($_POST['Password']) == 6) 
                    {
                        if ($_POST['Password'] == $_POST['ConfirmPassword']) 
                        {   
                            $sql = "SELECT Username FROM Users";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                            // output data of each row
                                while($row = $result->fetch_assoc()) 
                                {
                                    if ($row["Username"] == $_POST['Username']) 
                                    {
                                        echo '<div class = "Login_Search_Register_box">';
                                        echo "Username already exists";
                                        echo '</div>';
                                        $exists = TRUE;
                                        break;
                                    }
                                }
                            }
                            if ($exists == FALSE)
                            {
                                $n = $conn -> real_escape_string(htmlentities($_POST['Username']));
                                $p = $conn -> real_escape_string(htmltentities($_POST['Password']));
                                $fn = $conn -> real_escape_string(htmltentities($_POST['Firstname']));
                                $sn = $conn -> real_escape_string(htmltentities($_POST['Surname']));
                                $a1 = $conn -> real_escape_string(htmltentities($_POST['Address1']));
                                $a2 = $conn -> real_escape_string(htmltentities($_POST['Address2']));
                                $c = $conn -> real_escape_string(htmltentities($_POST['City']));
                                $t = $conn -> real_escape_string(htmltentities($_POST['Telephone']));
                                $m = $conn -> real_escape_string(htmltentities($_POST['Mobile']));
                                $sql = "INSERT INTO Users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2,City, Telephone, Mobile ) VALUES ('$n', '$p', '$fn', '$sn', '$a1','$a2','$c','$t','$m')";
                                if ($conn->query($sql) === TRUE) {
                                    echo '<div class = "Login_Search_Register_box">';
                                    echo "Registration Successful";
                                    $_POST["Username"] = "";
                                    $_POST["Firstname"] = "";
                                    $_POST["Surname"] = "";
                                    $_POST["Address1"] = "";
                                    $_POST["Address2"] = "";
                                    $_POST["City"] = "";
                                    $_POST["Telephone"] = "";
                                    $_POST["Mobile"] = "";
                                    echo '</div>';
                                } else {
                                    echo '<div class = "Login_Search_Register_box">';
                                    echo "Error: " . $sql . "<br>" . $conn->error; 
                                    echo '</div>';
                                }
                            }
                        }
                        else
                        {
                            echo '<div class = "Login_Search_Register_box">';
                            echo "Passwords do not match";
                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo '<div class = "Login_Search_Register_box">';
                        echo "Password is not 6 characters in length";
                        echo '</div>';
                    }
                }
                else
                {
                    echo '<div class = "Login_Search_Register_box">';
                    echo "Mobile Phone number is not 10 characters in length";
                    echo '</div>';
                }
            } 
            else
            {
                echo '<div class = "Login_Search_Register_box">';
                echo "All fields were not filled in";
                echo '</div>';
            }

            $conn->close();    
        }
    ?>



    <section class = "Login_Search_Register_box">
        <p> Registration Page </p>
        <form method="post">
        <p>Username:
        <input type="text" name="Username" value=<?php echo htmlentities($_POST["Username"])?>></p>
        <p>Password:
        <input type="Password" name="Password" required></p>
        <p>Confirm Password:
        <input type="Password" name="ConfirmPassword" required></p>
        <p>First Name:
        <input type="text" name="Firstname" value=<?php echo htmlentities($_POST["Firstname"])?>></p>
        <p>Last Name:
        <input type="text" name="Surname" value=<?php echo htmlentities($_POST["Surname"])?>></p>
        <p>Address Line 1:
        <input type="text" name="Address1" value=<?php echo htmlentities($_POST["Address1"])?>></p>
        <p>Address Line 2:
        <input type="text" name="Address2" value=<?php echo htmlentities($_POST["Address2"])?>></p>
        <p>City:
        <input type="text" name="City" value=<?php echo htmlentities($_POST["City"])?>></p>
        <p>Telephone:
        <input type="tel" name="Telephone" value=<?php echo htmlentities($_POST["Telephone"])?>></p>
        <p>Mobile Number:
        <input type="numeric" name="Mobile" value=<?php echo htmlentites($_POST["Mobile"])?>></p>
        <p><input type="submit" name="submit" value="Register"/></p>
        </form>
    </section>

    <div class = "Login_Search_Register_box" style = "margin-bottom: 70px;">    
        <p>Click here to go back to login</p>
        <a id = "Inside_Login_Register_button" href="Login.php">
            <button type = "button">
                Login
            </button>
        </a>
    </div>


    <footer>
        <p>©Created by Ben Costello. All Rights Reserved.</p>
    </footer>


    
</body>
</html>