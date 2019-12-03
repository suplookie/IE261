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
if (!isset($_SESSION['studNum']))
    echo "<h4>ERROR! Please sign in again and retry</h4>";
else {
    $tutee = $_SESSION['studNum'];
    $semester = date("Y");
    if (date("m") < 9) $semester = $semester. "Spring";
    else $semester = $semester. "Fall";
    $query = "insert into match.tutoring_match (tuteeNum, semester, classId) values (".$tutee. ", '". $semester. "', ". $_POST["class"]. ");";
    $conn->query($query);
    echo "<h4>Class successfully matched!</h4>";
}
?>