<html>
<head>
    <style>
        button{
            width: 130px;
            height: 40px;
            font-size: 18px;
            margin: 10px;
            left: 8px;
            position: relative;
            background-color: white;
            border: 2px solid black;
            border-radius: 5px;
            color:black;
            font-weight: bold;
        }
        button:hover{
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
session_start();
$servername = $_SESSION["ip"];
$username = "test";
$password = "1234";
$dbname = "match";
$conn = new mysqli($servername, $username, $password, $dbname);
$studentnumber = $_SESSION['studNum'];
if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}
$courseconnect = $conn->query("select * from match.kaistcourses where idkaistCourses='$_POST[id]';");
$course1 = $courseconnect->fetch_assoc();
$insertion = "insert into match.wishlist(priceUpper, TuteeNum, courseId) values ($_POST[priceUpper], $studentnumber, $course1[idkaistCourses]);";
mysqli_query($conn, $insertion);
echo "<div id='please' align='center'>Successfully Added</div>";
echo "<p align='center'><button type='button' onclick=\"location.href ='wishlist.php' \">Go Back</button></p>";
$conn->close();
?>
</html>