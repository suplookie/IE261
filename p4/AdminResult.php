<?php

$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "university";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

$check = "select * from p4.professor where PNum = '$_POST[p_number]'";
if ($conn -> query($check) -> num_rows > 0) {
    $sql = "select * from p4.student";
    $result = $conn -> query($sql);

    if ($result -> num_rows > 0) {
        echo "<TABLE border='1' cellpadding='5'>";
        echo "<TR align = 'center'><TD>Number</TD><TD>Name</TD><TD>Major</TD><TD>professor_PNum</TD></TR>";
        while ($row = $result -> fetch_assoc()) {
            echo "<TR align='center'><TD>". $row["SNum"]. "</TD><TD>". $row["Name"]. "</TD><TD>". $row["Major"]. "</TD><TD>". $row["professor_PNum"]. "</TD></TR>";
        }
        echo "</TABLE><br>";
    }else {
        echo "0 results";
    }
}
else {
    echo "Warning: Unregistered Professor Number<br>";
}


echo "<button type=\"button\" onclick=\"location.href ='http://localhost:8080/p4/main.html' \"> Back </button>";
$conn -> close();

?>