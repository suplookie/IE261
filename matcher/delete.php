<html>
<head>
    <style>
        button, input[type=submit], input[type=reset]{
            width: 130px;
            height: 40px;
            font-size: 18px;
            margin: 30px;
            left: 8px;
            position: relative;
            background-color: white;
            border: 2px solid black;
            border-radius: 5px;
            color:black;
            font-weight: bold;
        }
        button:hover, input[type=submit]:hover, input[type=reset]:hover{
            color:white;
            background-color: black;
        }
        #please{
            text-align: center;
            margin-top: 3em;
            font-size: 3em;
            font-weight: bold;
        }
    </style>
</head>
<?php
echo "<div id='please' align='center'>Deleted</div>";
$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";


$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$studentnumber = $_SESSION['studNum'];

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

function checktutortutee($x, $y) {
    $tutorcheck = $y -> query("select * from match.tutor where stuNum = '$x' limit 1;");
    if ($tutorcheck -> num_rows > 0) {
        return 0;
    }
    $tuteecheck = $y -> query("select * from match.tutee where stunum = '$x' limit 1;");
    if ($tuteecheck -> num_rows > 0) {
        return 1;
    }
    return 2;
}

if (checktutortutee($studentnumber, $conn) == 0) {
    $deletion = "Delete from match.open_class where idopen_class = $_POST[class];";
    mysqli_query($conn, $deletion);
    echo "<p align='center'><br><button type='button' onclick=\"location.href ='wishlist.php' \">Go Back</button></p>";
}
else if (checktutortutee($studentnumber, $conn) == 1) {
    $deletion = "Delete from match.wishlist where idwishlist = $_POST[class];";
    mysqli_query($conn, $deletion);
    echo "<p align='center'><br><button type='button' onclick=\"location.href ='wishlist.php' \">Go Back</button></p>";
}


$conn->close();
?>
</html>
