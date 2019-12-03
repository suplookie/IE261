<html>
<head>
    <style>
        button, input[type=submit], input[type=reset]{
            width: 90px;
            height: 25px;
            margin: 5px;
            left: 8px;
            position: relative;
            background-color: white;
            border: 1px solid black;
            border-radius: 5px;
            color:black;
        }
        button:hover, input[type=submit]:hover, input[type=reset]:hover{
            color:white;
            background-color: black;
        }
    </style>
</head>
<?php

//$servername = "110.76.66.224";
$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";
session_start();

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

if (!isset($_SESSION['studNum']))
    echo "<h4>please Sign In</h4>";
else {
    $tuteeCheck = $conn -> query("select * from match.tutee where stunum = ". $_SESSION['studNum']);
    if ($tuteeCheck -> num_rows > 0) {
        echo "<FORM METHOD=\"post\" ACTION=\"match.php\">";

        $selection = "select * from match.open_class where idopen_class not in 
                        (select classId from match.tutoring_match)";
        //모든 오픈클래스가 아닌, tutoring match에 없는 클래스만 가져오는거로 바꾸기
        $result = $conn -> query($selection);
        echo "<h4>Select class you want. If not, add to your wishlist</h4>";
        if ($result -> num_rows > 0) {
            echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
            echo "<TR><TD></TD></TD><TD>Course</TD><TD>Professor</TD><TD>TutorNum</TD><TD>Tutor Name</TD><TD>Tutor Department</TD><TD>Price</TD></TR>";
            while ($now = $result -> fetch_assoc()) {
                $classid = $now["idopen_class"];
                $courseCon = $conn -> query("select * from match.kaistcourses where idkaistCourses=".$now["courseId"]);
                $course = $courseCon -> fetch_assoc();
                $tutorCon = $conn -> query("select * from match.kaist_stu where stu_num=". $now["tutorNum"]);
                $tutor = $tutorCon ->fetch_assoc();
                $link = "tutorInfo.php?tutor=". $tutor["stu_num"]. "&courseId=".$now["courseId"];
                echo "<TR><TD><input type='radio' name='class' value=". $classid. "></TD>";
                echo "<TD>". $course["course"]. "</TD>";
                echo "<TD>". $course["prof"]. "</TD>";
                echo "<TD> <a href = '". $link. "' target='_blank'>". $tutor["stu_num"]. "</a></TD>";
                echo "<TD>". $tutor["name"]. "</TD>";
                echo "<TD>". $tutor["department"]. "</TD>";
                echo "<TD>". $now["price"]. "</TD>";
                echo "</TR>";
            }
            echo "</TABLE>";
        }
        else {
            echo "<h1>Warning: NO CLASS OPENED</h1>";
        }
        echo "<p><INPUT type=\"submit\" value=\"Submit\"> &nbsp;";
        echo "<button type=\"button\" onclick=\"location.href ='mywish.php' \"> Add wishlist </button></p>";
        echo "</FORM>";
    }
    else
        echo "Only tutee can select class";

}
$conn -> close();
?>

</html>