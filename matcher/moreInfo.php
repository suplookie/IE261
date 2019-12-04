<html>
<head>
    <style>
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
        table{
            alignment: center;
            font-size: 20px;
            margin-top: 3em;
            border-collapse: separate;
            border: 2px solid black;
            border-radius: 20px;
            border-spacing: 5px 20px;
            font-weight: bold;
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
    $servername = "143.248.171.107";
    $username = "test";
    $password = "1234";
    $dbname = "match";
    $_SESSION["ip"] = $servername;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn-> connect_error) {
        die("Connection failed: " + $conn -> connect_error);
    }

    echo "<FORM METHOD=\"post\" ACTION=\"moreInfo.php\">";

    if (isset($_POST["name"])) {   //from sign up
        $checkDup = $conn->query("select * from match.kaist_stu where stu_num = ". $_POST['StudNum']);
        if ($checkDup -> num_rows > 0)
            echo "<div id='please' align='center'>Student ID is already registered.</div>";
        else {
            $kaist = "insert into match.kaist_stu (stu_num, name, department, email, password) values (". $_POST["StudNum"]. ", '". $_POST["name"]. "', '". $_POST["department"]. "', '". $_POST["email"]. "', '". $_POST["password"]. "');";
            $conn->query($kaist);
            if ($_POST["tt"] == "tutor") {
                $conn->query("insert into match.tutor (stuNum, avgrade) values (". $_POST["StudNum"]. ", '0');");
            }
            else{
                $conn->query("insert into match.tutee (stunum) values (". $_POST["StudNum"]. ");");
            }
            $_SESSION['studNum'] = $_POST["StudNum"];
            $_SESSION['password'] = $_POST['password'];
            echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
            echo "<TR><TD align='right'>Name &nbsp;</TD><TD><input type='text' name='name' value=". $_POST["name"]. "></TD>";
            echo "<TR><TD align='right'>Password &nbsp;</TD><TD><input type='password' name='password'></TD></TR>";
            echo "<TR><TD align='right'>Student Number &nbsp;</TD><TD>". $_POST["StudNum"]. "</TD>";
            echo "<TR><TD align='right'>Department &nbsp;</TD>
                <TD><select name=\"department\">
                    <option value=". $_POST["department"]. ">". $_POST["department"]. "</option>
                    <option value=\"PH\">Physics</option>
                    <option value=\"MAS\">Mathematics</option>
                    <option value=\"CH\">Chemistry</option>
                    <option value=\"BS\">Biology</option>
                    <option value=\"CS\">Computer Science</option>
                    <option value=\"EE\">Electronic Engineering</option>
                    <option value=\"CE\">Civil & Environment Engineering</option>
                    <option value=\"BiS\">Bio & Brain Engineering</option>
                    <option value=\"ID\">Industrial Design</option>
                    <option value=\"IE\">Industrial & System Engineering</option>
                    <option value=\"CBE\">Chemical & Biomolecular Engineering</option>
                    <option value=\"NQE\">Nuclear & Quantum Engineering</option>
                    <option value=\"MS\">Material Science And Engineering</option>
                    <option value=\"ME\">Mechanical Engineering</option>
                    <option value=\"AE\">Aerospace Engineering</option>
                    <option value=\"MSB\">Business</option>
                    <option value=\"Fresh\">Freshman</option>
                 </select></TD></TR>";
            echo "<TR><TD align='right'>Email &nbsp;</TD><TD><input type='text' name='email' value=". $_POST["email"]. "></TD>";
            echo "</TABLE>";
            echo "<p align='center'><INPUT type=\"submit\" value=\"update\">&nbsp;<INPUT type=\"reset\" value='clear'></p>";
            echo "</FORM>";
        }
    }

    else if (isset($_POST["StudNum"]) || isset($_SESSION['studNum'])) { //from sign in + mypage

        if (isset($_SESSION['studNum'])) {
            $selection = "select * from match.kaist_stu where stu_num = ". $_SESSION["studNum"]. " and password = ".$_SESSION["password"];
        }
        else
            $selection = "select * from match.kaist_stu where stu_num = ". $_POST["StudNum"]. " and password = ".$_POST["password"];

        $result = $conn -> query($selection);
        if ($result -> num_rows > 0) {
            if (!isset($_SESSION['studNum'])) {
                $_SESSION['studNum'] = $_POST["StudNum"];
                $_SESSION['password'] = $_POST['password'];
            }
            $now = $result -> fetch_assoc();
            echo "<input type='hidden' name='StudNum' value=". $now["stu_num"]. ">";
            echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
            echo "<TR><TD align='right'>Name &nbsp;</TD><TD><input type='text' name='Name' value=". $now["name"]. "></TD></TR>";
            echo "<TR><TD align='right'>Password &nbsp;</TD><TD><input type='password' name='password' required></TD></TR>";
            echo "<TR><TD align='right'>Student Number &nbsp;</TD><TD>". $now["stu_num"]. "</TD></TR>";
            echo "<TR><TD align='right'>Department &nbsp;</TD><TD><select name=\"department\">
                    <option value=". $now["department"]. ">". $now["department"]. "</option>
                    <option value=\"PH\">Physics</option>
                    <option value=\"MAS\">Mathematics</option>
                    <option value=\"CH\">Chemistry</option>
                    <option value=\"BS\">Biology</option>
                    <option value=\"CS\">Computer Science</option>
                    <option value=\"EE\">Electronic Engineering</option>
                    <option value=\"CE\">Civil & Environment Engineering</option>
                    <option value=\"BiS\">Bio & Brain Engineering</option>
                    <option value=\"ID\">Industrial Design</option>
                    <option value=\"IE\">Industrial & System Engineering</option>
                    <option value=\"CBE\">Chemical & Biomolecular Engineering</option>
                    <option value=\"NQE\">Nuclear & Quantum Engineering</option>
                    <option value=\"MS\">Material Science And Engineering</option>
                    <option value=\"ME\">Mechanical Engineering</option>
                    <option value=\"AE\">Aerospace Engineering</option>
                    <option value=\"MSB\">Business</option>
                    <option value=\"Fresh\">Freshman</option>
                </select></TD></TR>";
            echo "<TR><TD align='right'>Email &nbsp;</TD><TD><input type='text' name='email' value=". $now["email"]. "></TD></TR>";
            $tutorCheck = "select * from match.tutor where stuNum=". $_POST["StudNum"];
            $tutorRes = $conn -> query($tutorCheck);
            /*if ($tutorRes -> num_rows > 0) {        //if tutor, add table for upgrading grade
                //$tutor = $tutorRes -> fetch_assoc();
                echo "<TR><TD align='right' rowspan='3'>Add Grade&nbsp;</TD><TD><input type='text' name='course' placeholder='course'></TD></TR>";
                echo "<TR><TD><input type='text' name='prof' placeholder='professor'></TD></TR>";
                echo "<TR><TD><input type='text' name='grade' placeholder='grade'></TD></TR>";
            }*/
            echo "</TABLE>";
            echo "<p align='center'><INPUT type=\"submit\" value=\"update\">&nbsp;<INPUT type=\"reset\" value='clear'></p>";
            echo "</FORM>";

            $tutorOrtutee = $conn->query("select * from match.tutor where stuNum = " . $_SESSION['studNum'].";");

            if($tutorOrtutee->num_rows > 0){ // 튜터일 때
                $tutorMatch = $conn->query("select * from match.tutoring_match where classId in (select idopen_class from match.open_class where tutorNum = " . $_SESSION['studNum'].");");
                if($tutorMatch->num_rows > 0) {
                    echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
                    echo "<TR><TD>Tutee &nbsp;</TD><TD>Price &nbsp;</TD><TD>Course &nbsp;</TD><TD>Professor &nbsp;</TD><TD>Semester &nbsp;</TD></TR>";
                    while ($row = $tutorMatch->fetch_array()) {
                        $classid = $row['classId'];
                        $dataOpenClass = $conn->query("select * from match.open_class where idopen_class = " . $row['classId']);
                        $openrow = $dataOpenClass->fetch_array();
                        $dataKaistCourse = $conn->query("select * from match.kaistcourses where idkaistCourses = " . $openrow['courseId']);
                        $courserow = $dataKaistCourse->fetch_array();
                        echo "<TR><TD>".$row['tuteeNum']."</TD><TD>".$openrow['price']."</TD><TD>".$courserow['course']."</TD><TD>".$courserow['prof']."</TD><TD>".$row['semester']."</TD></TR>";
                    }
                    echo "</TABLE>";
                }
            }
            else {
                $tuteeMatch = $conn->query("select * from match.tutoring_match where tuteeNum = " . $_SESSION['studNum'].";");
                if($tuteeMatch->num_rows > 0) {
                    echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
                    echo "<TR><TD>Tutor &nbsp;</TD><TD>Price &nbsp;</TD><TD>Course &nbsp;</TD><TD>Professor &nbsp;</TD><TD>Semester &nbsp;</TD></TR>";
                    while ($row = $tuteeMatch->fetch_array()) {
                        $classid = $row['classId'];
                        $dataOpenClass = $conn->query("select * from match.open_class where idopen_class = " . $row['classId']);
                        $openrow = $dataOpenClass->fetch_array();
                        $dataKaistCourse = $conn->query("select * from match.kaistcourses where idkaistCourses = " . $openrow['courseId']);
                        $courserow = $dataKaistCourse->fetch_array();
                        $link = "eval.php?semester=". $row['semester']. "&classId=".$row['idtutoring_match']. "&tutorNum=". $openrow['tutorNum'];
                        echo "<TR><TD>".$openrow['tutorNum']."</TD><TD>".$openrow['price']."</TD><TD>".$courserow['course']."</TD><TD>".$courserow['prof']."</TD><TD> <a href = '". $link. "' target='_blank'>".$row['semester']."</a></TD></TR>";
                    }
                    echo "</TABLE>";
                }
            }

        }
        else {          //login fail
            echo "<div id='please' align='center'>Student ID or password is wrong.</div></FORM>";
            echo "<p align='center'><button type='button' onclick=\"location.href = 'main.html'\">Back</button></p>";
        }
    }
    else {  //from mypage not logged in
        echo "<div id='please' align='center'>Please Sign In</div>";
    }

    $conn -> close();
?>
</html>
