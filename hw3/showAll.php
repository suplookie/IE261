<?php
$servername = "localhost:3306";
$username = "test";
$password = "1234";
$dbname = "p3";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "connection failed".mysqli_connect_error();
}
$query = "SELECT * FROM horoscopes";
$result = mysqli_query($conn, $query);

while ($data = mysqli_fetch_array($result)) {
    $textUrl = $data['textUrl'];
    $fp = fopen($textUrl, 'r') or die("cannot open file $textUrl");
    echo '<li style = \'float: left; margin: 10px;\'>';
    echo '<b><font size="5"> '.$data['name'].'</font></b><br>';
    echo '<img src = '.$data['imgUrl'].' width=100><br>';
    while (!feof($fp)) {
        echo fgets($fp);
    };
    fclose($fp);
    echo '</li>';
}

mysqli_close($conn);
?>