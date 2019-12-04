<?php
session_start();
$servername = $_SESSION["ip"];
$username = "test";
$password = "1234";
$dbname = "match";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

if (isset($_GET["courseId"])) {
    echo "tutor: ". $_GET["tutor"]. "<br>";
    $course = $conn->query("select * from kaistcourses where idkaistCourses = ". $_GET["courseId"]. ";");
    if ($course->num_rows > 0){
        $courseNow = $course ->fetch_assoc();
        echo "course: ". $courseNow["course"]. " by ". $courseNow["prof"]. "<br>";
    }
    $query = "select * from match.tutorgrade where stunum = ". $_GET["tutor"]. " and courseId = ". $_GET["courseId"]. ";";
    $grade = $conn->query($query);
    if ($grade->num_rows > 0) {
        $now = $grade -> fetch_assoc();
        echo "grade: ". $now["grade"];
    }
    else
        echo "grade: null";

    $q = "select * from match.tuteegrade where tutorNum=". $_GET["tutor"]. ";";
    echo "<br><br><b>tutee's evalation</b>";
    echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
    echo "<TR></TD><TD>Grade</TD><TD>Satisfaction</TD><TD>Comment</TD></TR>";
    $tuteeGrade = $conn->query($q);
    if ($tuteeGrade->num_rows > 0) {
        while ($tuteeNow = $tuteeGrade->fetch_assoc()) {
            echo "<TR><TD>". $tuteeNow["grade"]. "</TD><TD>". $tuteeNow["satisfy"]. "</TD><TD>". $tuteeNow["comment"]. "</TD></TR>";
        }
    }

    echo "</TABLE>";
    echo "<h1>getting all tutee evaluation: bring course Info or bring evaluation of selected course</h1>";
}

?>