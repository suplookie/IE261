<?php
/*echo "register result <br>";
echo "id: $_GET[id]<br>";
echo "password: $_GET[pass]";*/

$servername = "localhost:3306";
$username = "test";
$password = "1234";
$dbname = "omens";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

$sql = "select * from them";
$result = $conn->query($sql);

echo "SQL result of query: ";
echo $sql;
echo "<br>";

if ($result->num_rows >0) {
    while ($row = $result->fetch_assoc()) {
        echo $row["id"];
        echo "&nbsp&nbsp";
        echo $row["name"];
        echo "&nbsp&nbsp";
        echo $row["other"];
        echo "<br>";
    }
}
else {
    echo "0 results";
}
$conn->close();
?>