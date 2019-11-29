<?php

$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "match";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

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
        echo "<TR><TD><input type='radio' name='class' value=". $classid. "></TD>";
        echo "<TD>". $course["course"]. "</TD>";
        echo "<TD>". $course["prof"]. "</TD>";
        echo "<TD>". $tutor["stu_num"]. "</TD>";
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
echo "<button type=\"button\" onclick=\"location.href ='http://localhost:8080/matcher/mywish.php' \"> Add wishlist </button></p>";
echo "</FORM>";

$conn -> close();

?>
