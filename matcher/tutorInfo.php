<?php
$servername = "143.248.219.83";
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

    $q = "select * from match.tuteegrade where tutorNum=". $_GET["tutor"]. " and classId in 
                    (select idopen_class from match.open_class where courseId=". $_GET["courseId"].");";
    echo "<br><br><b>tutee's evalation</b>";
    echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
    echo "<TR></TD><TD>Grade</TD><TD>Satisfaction</TD></TR>";
    $tuteeGrade = $conn->query($q);
    if ($tuteeGrade->num_rows > 0) {
        while ($tuteeNow = $tuteeGrade->fetch_assoc()) {
            echo "<TR><TD>". $tuteeNow["grade"]. "</TD><TD>". $tuteeNow["satisfy"]. "</TD></TR>";
        }
    }
    echo "</TABLE>";
}

?>