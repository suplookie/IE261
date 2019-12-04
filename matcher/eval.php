<html>
<head>
    <style>
        table{
            alignment: center;
            font-size: 20px;
            margin-top: 5em;
            border-collapse: separate;
            border: 2px solid black;
            border-radius: 20px;
            border-spacing: 5px 20px;
            font-weight: bold;
        }
        td{
            text-align: center;
        }
        button, input[type=submit], input[type=reset]{
            width: 120px;
            height: 40px;
            font-size: 20px;
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
        select, input[type=number]{
            font-size: 20px;
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

$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}
if (!isset($_SESSION['studNum'])){
    echo "<div id='please' align='center'>ERROR! Please sign in again and retry</div>";
}
else {
    if (isset($_GET["semester"])) {
        $tutee = $_SESSION['studNum'];
        $semester = date("Y");
        if (date("m") < 9) $semester = $semester. "Spring";
        else $semester = $semester. "Fall";
        if ($semester != $_GET["semester"]) {
            $classID = $_GET['classId'];
            $tutorNum = $_GET['tutorNum'];
            echo "<FORM METHOD=\"post\" ACTION=\"eval.php\" name='form'>";
            echo "<input type='hidden' name='classId' value= '$classID'>";
            echo "<input type='hidden' name='tutorNum' value= '$tutorNum'>";
            echo "<TABLE border=\"0\" width=\"500\" CELLPADDING = \"5\" CELLSPACING = \"1\" align=\"center\">";
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
            echo "<TR><TD align='right'>Satisfaction &nbsp;</TD><TD>
                        <input type='radio' name='satisfy' value='1'>1 &nbsp;
                        <input type='radio' name='satisfy' value='2'>2 &nbsp;
                        <input type='radio' name='satisfy' value='3'>3 &nbsp;
                        <input type='radio' name='satisfy' value='4'>4 &nbsp;
                        <input type='radio' name='satisfy' value='5'>5 &nbsp;</TD></TR>";
            echo "<TR><TD align='right'>Comment &nbsp;</TD><TD><input type='text' name='comment' required maxlength='45'></TD></TR>";
            echo "</TABLE>";
            echo "<p align='center'><INPUT type=\"submit\" value=\"OPEN\" name='open'>&nbsp;<INPUT type=\"reset\" value='Clear'></p>";
            echo "</FORM>";
        }
        else {
            echo "<div id='please' align='center'>Not a evaluation period</div>";
        }
    }
    else {
        $grades = $conn->query("select * from match.tuteegrade where classId=". $_POST["classId"]. ";");
        if ($grades->num_rows > 0) {
            echo "<div id='please' align='center'>Already evaluated</div>";
        }
        else {
            $que = "insert into match.tuteegrade (grade, classId, tutorNum, satisfy, comment) values ('". $_POST["grade"]. "', ". $_POST["classId"]. ", ". $_POST["tutorNum"]. ", ". $_POST["satisfy"]. ", '". $_POST["comment"]. "');";
            $conn->query($que);
            echo "<div id='please' align='center'>Thank you for Evaluation</div>";
        }
    }
}
$conn -> close();
?>
</html>

