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
//성적, 튜터일 경우 평점을 입력할 수 있는 페이지
//이전에 입력한 결과(signup)를 볼 수 있고 성적과 평점도 볼 수 있음
//mypage 누르면 오는곳
//로그인했을때 첫화면이기도 하기때문에 signin시 입력한 정보(학번 이름 이메일)이용해 정보 가져오기
//signup시에도 연결되므로 그때 정보를 데이터베이스에 넣고 내정보 보여주기
//$servername = "110.76.66.224";
$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

// tutor만 들어올 수 있도록 추가
// 로그인 이후에 들어올 수 있도록 추가



if (!isset($_SESSION['studNum']))
    echo "<h4>please Sign In</h4>";
else {
    $tutorCheck = $conn->query("select * from match.tutor where stuNum = " . $_SESSION['studNum']);
    if ($tutorCheck->num_rows > 0) {

        echo "<FORM METHOD=\"post\" ACTION=\"registerLecture.php\" name='form'>";

        if (isset($_POST["open"])) {   //from registerLecture itself (after clicking submit button)
            $openclass = "insert into match.open_class (tutorNum, price, courseId) values (".$_SESSION["studNum"].",". $_POST["price"]. ",". $_POST["courses"].");";
            $conn->query($openclass);
        }

        $qu = "select * from match.kaistcourses";
        $courseCon = $conn->query($qu);

        echo "<TABLE CELLPADDING = \"5\" CELLSPACING = \"1\" border='1'>";
        echo "<TR><TD align='right'>Courses&nbsp;</TD><TD><select name=\"courses\" required>";
        while ($row = $courseCon->fetch_array()) {
            echo "<option value=" . $row['idkaistCourses'] . ">" . $row['course'] . " by " . $row['prof'] . "</option>";
        }
        echo "</select></TD></TR>";
        echo "<TR><TD align='right'>Grade! &nbsp;</TD><TD><select name='grade' required>
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
        echo "<TR><TD colspan='2' align='center'><p><INPUT type=\"submit\" value=\"OPEN\" name='open'>&nbsp;<INPUT type=\"reset\" value='Clear'></p></TD></TR>";
        echo "</TABLE>";
        echo "</FORM>";
    } else
        echo "Only tutor can select class";
}
$conn -> close();
?>

</html>
