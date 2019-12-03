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

//$servername = "110.76.66.224";
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

echo "<FORM METHOD=\"POST\" ACTION=\"delete.php\">";

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
    $selection = "select * from match.open_class where idopen_class not in (select classId from match.tutoring_match) and tutorNum = '$studentnumber';";
    $result = $conn->query($selection);
    if ($result->num_rows > 0) {
        echo "<TABLE border=\"0\" width=\"400\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
        echo "<TR><TD></TD><TD>Course</TD><TD>Professor</TD><TD>Price</TD></TR>";
        while ($now = $result->fetch_assoc()) {
            $id = $now['idopen_class'];
            $courseCon = $conn->query("select * from kaistcourses where idkaistCourses=" . $now["courseId"]);
            $course = $courseCon->fetch_assoc();
            echo "<TR><TD><input type='radio' name='class' value=$id></TD><TD>" . $course["course"] . "</TD><TD>" . $course["prof"] . "</TD><TD>" . $now["price"] . "</TD></TR>";
        }
        echo "</TABLE>";
    }
    else {
        echo "<div id='please' align='center'>Warning: NO OPEN CLASS</div>";
    }
}
else if (checktutortutee($studentnumber, $conn) == 1) {

    $selection = "select * from match.wishlist where TuteeNum = '$studentnumber';";
    $result = $conn->query($selection);
    if ($result->num_rows > 0) {
        echo "<TABLE border=\"0\" width=\"400\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
        echo "<TR><TD></TD><TD>Course</TD><TD>Professor</TD><TD>Price Upper Bound</TD></TR>";
        while ($now = $result->fetch_assoc()) {
            $id = $now['idopen_class'];
            $courseCon = $conn->query("select * from kaistcourses where idkaistCourses=" . $now["courseId"]);
            $course = $courseCon->fetch_assoc();
            echo "<TR><TD><input type='radio' name='class' value=$id></TD><TD>" . $course["course"] . "</TD><TD>" . $course["prof"] . "</TD><TD>" . $now["priceUpper"] . "</TD></TR>";
        }
        echo "</TABLE>";
    } else {
        echo "<div id='please' align='center'>Warning: NO TRADE HISTORY IN THE PERIOD</div>";
    }
}
else {
    echo "<div id='please' align='center'>Please Sign In</div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button></p>";
}

if (checktutortutee($studentnumber, $conn) == 0) {
    echo "<p align='center'><INPUT type=\"submit\" value=\"Delete\" ></p>&nbsp;";
}
else if (checktutortutee($studentnumber, $conn) == 1) {
    echo "<p align='center'><INPUT type=\"submit\" value=\"Delete\" >&nbsp;";
    echo "<button type='button' onclick=\"location.href ='mywish.php' \"> Add Wishlist </button></p>";
}
echo "</FORM>";
$conn -> close();

?>
</html>
