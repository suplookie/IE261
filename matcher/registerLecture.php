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
        select, input[type=number]{
            font-size: 20px;
        }
        #please{
            text-align: center;
            margin-top: 3em;
            font-size: 3em;
            font-weight: bold;
        }
        #wish{
            text-align: center;
            margin-top: 1em;
            margin-bottom: -1em;
            font-size: 2em;
            font-weight: bold;
        }
    </style>
</head>
<?php
//성적, 튜터일 경우 평점을 입력할 수 있는 페이지
//이전에 입력한 결과(signup)를 볼 수 있고 성적과 평점도 볼 수 있음
//mypage 누르면 오는곳
//로그인했을때 첫화면이기도 하기때문에 signin시 입력한 정보(학번 이름 이메일)이용해 정보 가져오기
//signup시에도 연결되므로 그때 정보를 데이터베이스에 넣고 내정보 보여주기
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

// tutor만 들어올 수 있도록 추가
// 로그인 이후에 들어올 수 있도록 추가

if (!isset($_SESSION['studNum'])){
    echo "<div id='please' align='center'>Please Sign In</div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button></p>";
}
else {
    $tutorCheck = $conn->query("select * from match.tutor where stuNum = " . $_SESSION['studNum']);
    if ($tutorCheck->num_rows > 0) {

        echo "<FORM METHOD=\"post\" ACTION=\"registerLecture.php\" name='form'>";

        if (isset($_POST["open"])) {   //from registerLecture itself (after clicking submit button)
            $openclass = "insert into match.open_class (tutorNum, price, courseId) values (".$_SESSION["studNum"].",". $_POST["price"]. ",". $_POST["courses"].");";
            $conn->query($openclass);

            $gradeCheck = $conn->query("select * from match.tutorgrade where stuNum = " . $_SESSION['studNum'] . " and courseId = " . $_POST["courses"]);
            if($gradeCheck->num_rows == 0) {
                $insertgrade = "insert into match.tutorgrade (stunum, grade, courseId) values (" . $_SESSION["studNum"] . "," . $_POST["grade"] . "," . $_POST["courses"] . ");";
                $conn->query($insertgrade);
            }
        }

        $qu = "select * from match.kaistcourses";
        $courseCon = $conn->query($qu);

        echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
        echo "<TR><TD align='right'>Courses&nbsp;</TD><TD><select name=\"courses\" required>";
        while ($row = $courseCon->fetch_array()) {
            echo "<option value=" . $row['idkaistCourses'] . ">" . $row['course'] . " by " . $row['prof'] . "</option>";
        }
        echo "</select></TD></TR>";
        echo "<TR><TD align='right'>Grade &nbsp;</TD><TD><select name='grade' required>
                <option value=\"4.3\">A+</option>
                <option value=\"4.0\">A0</option>
                <option value=\"3.7\">A-</option>
                <option value=\"3.3\">B+</option>
                <option value=\"3.0\">B0</option>
                <option value=\"2.7\">B-</option>
                <option value=\"2.3\">C+</option>
                <option value=\"2.0\">C0</option>
                <option value=\"1.7\">C-</option>
                <option value=\"1.3\">D+</option>
                <option value=\"1.0\">D0</option>
                <option value=\"0.7\">D-</option>
                <option value=\"0.0\">F</option>
                </select></TD></TR>";
        echo "<TR><TD align='right'>Price &nbsp;</TD><TD><input type='number' name='price' required min='0' maxlength='6'></TD></TR>";
        echo "</TABLE>";
        echo "<p align='center'><INPUT type=\"submit\" value=\"OPEN\" name='open'>&nbsp;<INPUT type=\"reset\" value='Clear'></p>";
        echo "</FORM>";


        echo "<div id='wish' align='center'>Tutee Wish list</div>";
        $sel = "select * from match.wishlist;";
        $result = $conn->query($sel);
        if ($result->num_rows > 0) {
            echo "<TABLE border=\"0\" width=\"400\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
            echo "<TR><TD>Course</TD><TD>Professor</TD><TD>Price Upper Bound</TD></TR>";
            while ($now = $result->fetch_assoc()) {
                $id = $now['idwishlist'];
                $courseCon = $conn->query("select * from kaistcourses where idkaistCourses=" . $now["courseId"]);
                $course = $courseCon->fetch_assoc();
                echo "<TR><TD>" . $course["course"] . "</TD><TD>" . $course["prof"] . "</TD><TD>" . $now["priceUpper"] . "</TD></TR>";
            }
            echo "</TABLE>";
        } else {
            echo "<div id='please' align='center'>Empty Wishlist</div>";
            $empty = 1;
        }
    } else
        echo "<div id='please' align='center'>Only tutor can open class</div>";
}
$conn -> close();
?>

</html>
