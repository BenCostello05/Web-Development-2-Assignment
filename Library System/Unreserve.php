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
    $success = FALSE;
    $Position = 0;

    $sql = "UPDATE Books Set Reserved = 'N' WHERE ISBN = '$ISBN'";
    if ($conn->query($sql) === TRUE) {
        $success = TRUE;
    } 
    else 
    {
        echo "There was a problem unreserving the book";
    }

    if ($success == TRUE)
    {
        $sql1 = "DELETE FROM Reservations WHERE ISBN = '$ISBN'";
        if ($conn->query($sql1) === TRUE) {
            echo "Book was unreserved Successfully";
            header("Location: Show_Reserve.php?Position=".htmlentities($Position));
        } 
        else 
        {
            echo "There was a problem unreserving the book";
            $sql2 = "UPDATE Books Set Reserved = 'Y' WHERE ISBN = '$ISBN'";
            $conn->query($sql2);
        }
    }

    }

?>

    
</body>
</html>
