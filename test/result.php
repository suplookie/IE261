<?php

$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "market";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

$from = $_POST[from];
$to = $_POST[to];

if ($from > $to) echo "<h1>Warning: start date should be before end date</h1>";
else {
    $thres = $_POST[threshold];
    $selection = "select * from market.transaction_hist where Date >= '$from' and Date <= '$to' and Quantity * Price > '$thres'";
    $result = $conn -> query($selection);
    if ($result -> num_rows > 0) {
        while ($now = $result -> fetch_assoc()) {
            $value = $now["Quantity"] * $now["Price"];
            echo "Buyer : ". $now["buyer_idBUYER"]. " -- Seller : ". $now["seller_idSELLER"]. " -- Value : ". $value. "<br>";
        }
    }
    else {
        echo "<h1>Warning: NO TRADE HISTORY IN THE PERIOD</h1>";
    }
}

echo "<button type=\"button\" onclick=\"location.href ='http://localhost:8080/test/main.html' \"> Back </button>";
$conn -> close();

?>