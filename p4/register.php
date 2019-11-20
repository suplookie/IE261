<?php

$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "university";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

$put = "insert into p4.student (SNum, Name, Major, professor_PNum) values ('$_POST[s_number]', '$_POST[s_name]', '$_POST[s_major]', '$_POST[s_prof]')";
$conn -> query($put);


echo "Data has been successfully stored. <br>The result of student registration: <br>";
echo "Student Number: ". "$_POST[s_number]<br>Student Name: ". "$_POST[s_name]<br>Major: ". "$_POST[s_major]<br>Assigned Professor Number: ". "$_POST[s_prof]<br>";
echo "<button type=\"button\" onclick=\"location.href ='http://localhost:8080/p4/main.html' \"> Back </button>";
$conn -> close();

?>