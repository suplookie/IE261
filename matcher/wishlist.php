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


$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$studentnumber = $_SESSION['studNum'];

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}
/*echo "<script>
function openwin() {
    window.open('about:blank','popwin','width=250,height=100');
    f1.submit();

</script>";}*/
echo "<FORM METHOD=\"POST\" ACTION=\"http://localhost:81/matcher/delete.php\" target='popwin'>";
echo "<h4>My Wishlist</h4>";

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
        echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
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
        echo "<h1>Warning: NO OPEN CLASS</h1>";
    }
}
else if (checktutortutee($studentnumber, $conn) == 1) {
    /*if (isset($_POST["course"])) {
        $courseconnect = $conn->query("select * from match.kaistcourses where course = $_POST[course] and prof = $_POST[prof]");
        $course1 = $courseconnect->fetch_assoc();
        $insertion = "insert into match.wishlist (priceUpper, TuteeNum, courseId) values ($_POST[priceUpper], $studentnumber, $course1[idkaistCourses])";
        mysqli($conn, $insertion);
    }*/


    $selection = "select * from match.wishlist where TuteeNum = '$studentnumber';";
    $result = $conn->query($selection);
    if ($result->num_rows > 0) {
        echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
        echo "<TR><TD></TD><TD>Course</TD><TD>Professor</TD><TD>Price Upper Bound</TD></TR>";
        while ($now = $result->fetch_assoc()) {
            $id = $now['idopen_class'];
            $courseCon = $conn->query("select * from kaistcourses where idkaistCourses=" . $now["courseId"]);
            $course = $courseCon->fetch_assoc();
            echo "<TR><TD><input type='radio' name='class' value=$id></TD><TD>" . $course["course"] . "</TD><TD>" . $course["prof"] . "</TD><TD>" . $now["priceUpper"] . "</TD></TR>";
            //echo "<input type='radio' name=\"class\" ". "value=" . $id . ">". $now["couse"]. " ". $now["priceUpper"]. " ". $now["time"]. " ".  $now["prof"]. "<br>";
        }
        echo "</TABLE>";
    } else {
        echo "<h1>Warning: NO TRADE HISTORY IN THE PERIOD</h1>";
    }
}
else {
    echo "Please log in";
}

if (checktutortutee($studentnumber, $conn) == 0) {
    echo "<INPUT type=\"submit\" value=\"delete\" >&nbsp;";
}
else if (checktutortutee($studentnumber, $conn) == 1) {
    echo "<INPUT type=\"submit\" value=\"delete\" >&nbsp;";
    echo "<button type='button' onclick=\"location.href ='http://localhost:81/matcher/mywish.php' \"> Add wishlist </button>";
}
echo "</FORM>";
$conn -> close();

//데이터베이스에 추가 구현 안함.. insert
//delete시 어떻게 할지 좀더 생각해야할듯
?>
</html>
