<html>
<?php

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


$courseconnect = $conn->query("select * from match.kaistcourses where course='$_POST[course]' and prof='$_POST[prof]';");
$course1 = $courseconnect->fetch_assoc();
$insertion = "insert into match.wishlist(priceUpper, TuteeNum, courseId) values ($_POST[priceUpper], $studentnumber, $course1[idkaistCourses]);";
mysqli_query($conn, $insertion);
echo "Successfully Added";
echo "<br><button type='button' onclick=\"location.href ='http://localhost:81/matcher/wishlist.php' \">Go Back</button>";

$conn->close();
?>
</html>