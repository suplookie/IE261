<html>
<head>
    <style>
        table{
            alignment: center;
            font-size: 20px;
            margin-top: 3em;
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
$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

if (isset($_GET["courseId"])) {
    echo "<div id='select' align='center'>tutor: ". $_GET["tutor"]. "</div>";
    $course = $conn->query("select * from kaistcourses where idkaistCourses = ". $_GET["courseId"]. ";");
    if ($course->num_rows > 0){
        $courseNow = $course ->fetch_assoc();
        echo "<div id='select' align='center'>course: ". $courseNow["course"]. " by ". $courseNow["prof"]. "</div>";
    }
    $query = "select * from match.tutorgrade where stunum = ". $_GET["tutor"]. " and courseId = ". $_GET["courseId"]. ";";
    $grade = $conn->query($query);
    if ($grade->num_rows > 0) {
        $now = $grade -> fetch_assoc();
        echo "<div id='select' align='center'>grade: ". $now["grade"]."</div>";
    }
    else
        echo "<div id='select' align='center'>grade: null</div>";

    $q = "select * from match.tuteegrade where tutorNum=". $_GET["tutor"]. ";";
    echo "<br><div id='please' align='center'>tutee's evalation</div>";
    echo "<TABLE border=\"0\" width=\"400\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
    echo "<TR></TD><TD>Grade</TD><TD>Satisfaction</TD><TD>Comment</TD></TR>";
    $tuteeGrade = $conn->query($q);
    if ($tuteeGrade->num_rows > 0) {
        while ($tuteeNow = $tuteeGrade->fetch_assoc()) {
            echo "<TR><TD>". $tuteeNow["grade"]. "</TD><TD>". $tuteeNow["satisfy"]. "</TD><TD>". $tuteeNow["comment"]. "</TD></TR>";
        }
    }

    echo "</TABLE>";
    echo "<div id='please' align='center'>getting all tutee evaluation: bring course Info or bring evaluation of selected course</div>";
}

?>
</html>
