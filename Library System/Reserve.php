<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    session_start();
    if( !isset($_SESSION["Username"])) 
    {
        header("Location:Login.php");
    }
    else
    {
    require_once("Connect.php");
    $Username = $_SESSION["Username"];
    $ISBN = $conn -> real_escape_string($_GET['ISBN']);
    $date = date('Y-m-d');
    $success = FALSE;
    $Position = 0;

    $sql = "UPDATE Books Set Reserved = 'Y' WHERE ISBN = '$ISBN'";
    if ($conn->query($sql) === TRUE) {
        $success = TRUE;
    } 
    else 
    {
        echo "There was a problem reserving the book";

    }

    if ($success == TRUE)
    {
        $sql1 = "INSERT INTO Reservations (ISBN,Username,ReservedDate) VALUES ('$ISBN','$Username','$date')";
        if ($conn->query($sql1) === TRUE) {
            echo "Book was reserved Successfully";
            header("Location: Show_Reserve.php?Position=".htmlentities($Position));
        } 
        else 
        {
            echo "There was a problem reserving the book";
            $sql2 = "UPDATE Books Set Reserved = 'N' WHERE ISBN = '$ISBN'";
            $conn->query($sql2);
        }
    }

    $conn->close();

    }

?>

    
</body>
</html>
