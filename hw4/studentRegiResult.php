<?php

$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "university";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

$put = "insert into university.student (name, address, phone) values ('$_POST[s_name]', '$_POST[s_address]', '$_POST[s_phone]')";

$sql = "select student from university";
$result = $conn -> query($sql);

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        echo "Name: ". $row["name"]. "-=Address: ". $row["address"]. "-Phone: ". $row["phone"]. "<br>";
    }
}else {
    echo "0 results";
}
echo "$_POST[s_name] $_POST[s_address] $_POST[s_phone] $_POST[department]";

$conn -> close();

?>