<html>
<head>
    <style>
        #please{
            text-align: center;
            margin-top: 3em;
            font-size: 3em;
            font-weight: bold;
        }
    </style>
</head>

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
if (!isset($_SESSION['studNum'])){
    echo "<div id='please' align='center'>ERROR! Please sign in again and retry</div>";
    //mail("hsk0306@kaist.ac.kr", "hi", "hi", "From: rushhour357@gmail.com\r\n");
}
else {
    $tutee = $_SESSION['studNum'];
    $semester = date("Y");
    if (date("m") < 9) $semester = $semester. "Spring";
    else $semester = $semester. "Fall";
    $query = "insert into match.tutoring_match (tuteeNum, semester, classId) values (".$tutee. ", '". $semester. "', ". $_POST["class"]. ");";
    $conn->query($query);
    echo "<div id='please' align='center'>Class successfully matched!</div>";

}
?>
</html>
