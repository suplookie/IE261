<html>
<?php
echo "deleted<br>";
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
    echo "<br><button type='button' onclick=\"location.href ='http://localhost:81/matcher/wishlist.php' \">Go Back</button>";
}
else if (checktutortutee($studentnumber, $conn) == 1) {
    $deletion = "Delete from match.wishlist where idwishlist = $_POST[class];";
    mysqli_query($conn, $deletion);
    echo "<br><button type='button' onclick=\"location.href ='http://localhost:81/matcher/wishlist.php' \">Go Back</button>";
}


$conn->close();
?>
</html>
