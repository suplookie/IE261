<?php
//성적, 튜터일 경우 평점을 입력할 수 있는 페이지
//이전에 입력한 결과(signup)를 볼 수 있고 성적과 평점도 볼 수 있음
//mypage 누르면 오는곳
//로그인했을때 첫화면이기도 하기때문에 signin시 입력한 정보(학번 이름 이메일)이용해 정보 가져오기
//signup시에도 연결되므로 그때 정보를 데이터베이스에 넣고 내정보 보여주기
$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "match";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

echo "<FORM METHOD=\"post\" ACTION=\"moreInfo.php\">";

if ($_POST["name"] != null) {   //from sign up
    echo "<TABLE CELLPADDING = \"5\" CELLSPACING = \"1\" border='1'>";
    echo "<TR><TD align='right'>Name &nbsp;</TD><TD><input type='text' name='name' value=". $_POST["name"]. "></TD>";
        echo "<TR><TD align='right'>Password &nbsp;</TD><TD><input type='password' name='password'></TD></TR>";
    echo "<TR><TD align='right'>Student Number &nbsp;</TD><TD>". $_POST["StudNum"]. "</TD>";
    echo "<TR><TD align='right'>Department &nbsp;</TD><TD><select name=\"department\">
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
                </select></TD></TR>";
    echo "<TR><TD align='right'>Email &nbsp;</TD><TD><input type='text' name='email' value=". $_POST["email"]. "></TD>";
    if(isset($_POST["tutor"])) {
        echo "<TR><TD align='right' rowspan='3'>Add Grade&nbsp;</TD><TD><input type='text' name='course' placeholder='course'></TD></TR>";
        echo "<TR><TD><input type='text' name='prof' placeholder='professor'></TD></TR>";
        echo "<TR><TD><input type='text' name='grade' placeholder='grade'></TD></TR>";
    }
    echo "<TR><TD colspan='2' align='center'><p><INPUT type=\"submit\" value=\"update\">&nbsp;<INPUT type=\"reset\" value='clear'></p></TD></TR>";
    echo "</TABLE>";
    echo "</FORM>";
}

else if ($_POST["StudNum"] != null) { //from sign in
    if ($_POST["course"] != null && $_POST["prof"] != null && $_POST["grade"] != null) {        //update tutor grade
        $qu = "select * from match.kaistcourses where course='". $_POST["course"]. "' and prof= '". $_POST["prof"]. "'";
        $courseCon = $conn->query($qu);
        $course=$courseCon->fetch_assoc();
        $query = "insert into match.tutorgrade (stunum, grade, courseId) values (". $_POST["StudNum"]. ", '". $_POST["grade"]. "', ". $course["idkaistCourses"]. ")";
        $conn->query($query);
    }

    $selection = "select * from match.kaist_stu where stu_num = ". $_POST["StudNum"]. " and password = ".$_POST["password"];
    $result = $conn -> query($selection);
    if ($result -> num_rows > 0) {
        $now = $result -> fetch_assoc();
        echo "<input type='hidden' name='StudNum' value=". $now["stu_num"]. ">";
        echo "<TABLE CELLPADDING = \"5\" CELLSPACING = \"1\" border='1'>";
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
            </select></TD></TR>";
        echo "<TR><TD align='right'>Email &nbsp;</TD><TD><input type='text' name='email' value=". $now["email"]. "></TD></TR>";
        $tutorCheck = "select * from match.tutor where stuNum=". $_POST["StudNum"];
        $tutorRes = $conn -> query($tutorCheck);
        if ($tutorRes -> num_rows > 0) {        //if tutor, add table for upgrading grade
            //$tutor = $tutorRes -> fetch_assoc();
            echo "<TR><TD align='right' rowspan='3'>Add Grade&nbsp;</TD><TD><input type='text' name='course' placeholder='course'></TD></TR>";
            echo "<TR><TD><input type='text' name='prof' placeholder='professor'></TD></TR>";
            echo "<TR><TD><input type='text' name='grade' placeholder='grade'></TD></TR>";
        }
        echo "<TR><TD colspan='2' align='center'><p><INPUT type=\"submit\" value=\"update\">&nbsp;<INPUT type=\"reset\" value='clear'></p></TD></TR>";
        echo "</TABLE>";
        echo "</FORM>";

        if ($tutorRes -> num_rows > 0) {        //if tutor, show my grade I uploaded
            $getGrade = $conn -> query("select * from match.tutorgrade where stunum=". $_POST["StudNum"]);
            echo "<TABLE CELLPADDING = \"5\" CELLSPACING = \"1\">";
            echo "<TR><TD align='center'>Course</TD><TD align='center'>Professor</TD><TD align='center'>Grade</TD></TR>";
            while ($grade = $getGrade->fetch_assoc()){
                $courseCon = $conn -> query("select * from match.kaistcourses where idkaistCourses=". $grade["courseId"]);
                $course = $courseCon->fetch_assoc();
                echo "<TR><TD align='center'>". $course["course"]. "</TD><TD align='center'>". $course["prof"]. "</TD><TD align='center'>". $grade["grade"]. "</TD></TR>";
            }
            echo "</TABLE>";
        }
    }
    else {
        echo "no user information exists. Please sign up. <br></FORM>";
        echo "<button type='button' onclick=\"location.href = 'http://localhost:8080/matcher/main.html'\">Back</button>";
    }
}
else {  //from mypage
    echo "not implemented<br>";
}

$conn -> close();
    ?>
