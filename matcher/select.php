<html>
<head>
    <style>
        table{
            alignment: center;
            font-size: 20px;
            margin-top: 2em;
            border-collapse: separate;
            border: 2px solid black;
            border-radius: 20px;
            border-spacing: 5px 20px;
            font-weight: bold;
            width: max-content;
        }
        td{
            text-align: center;
        }
        button, input[type=submit], input[type=reset]{
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
        #select{
            text-align: center;
            margin-top: 2em;
            font-size: 1em;
            font-weight: bold;
        }
    </style>
</head>
<?php

//$servername = "110.76.66.224";
session_start();
$servername = $_SESSION["ip"];
$username = "test";
$password = "1234";
$dbname = "match";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

if (!isset($_SESSION['studNum'])){
    echo "<div id='please' align='center'>Please Sign In</div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button></p>";
}
else {
    $tuteeCheck = $conn -> query("select * from match.tutee where stunum = ". $_SESSION['studNum']);
    if ($tuteeCheck -> num_rows > 0) {
        echo "<FORM METHOD=\"post\" ACTION=\"match.php\">";

        $selection = "select * from match.open_class where idopen_class not in 
                        (select classId from match.tutoring_match)";
        //모든 오픈클래스가 아닌, tutoring match에 없는 클래스만 가져오는거로 바꾸기
        $result = $conn -> query($selection);
        echo "<div id='select' align='center'>Select class you want. If not, add to your wishlist</div>";
        if ($result -> num_rows > 0) {
            echo "<TABLE border=\"0\" width=\"400\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
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
            echo "<div id='please' align='center'>Warning: NO CLASS OPENED</div>";
        }
        echo "<p align='center'><INPUT type=\"submit\" value=\"Submit\"> &nbsp;";
        echo "<button type=\"button\" onclick=\"location.href ='mywish.php' \"> Add Wishlist </button></p>";
        echo "</FORM>";
    }
    else
        echo "<div id='please' align='center'>Only tutee can select class</div>";

}
$conn -> close();
?>

</html>