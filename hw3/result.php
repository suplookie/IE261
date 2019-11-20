<?php
echo "Your name is $_GET[name]<br>";
echo  "Your gender is $_GET[gender]<br>";
$month = $_GET[month];
$date = $_GET[date];

if ($month == 1){
    $mon = "Jan";
    if ($date < 20)
        $zodiac = "Capricorn";
    else
        $zodiac = "Aquarius";
}
if ($month == 2){
    $mon = "Feb";
    if ($date < 19)
        $zodiac = "Aquarius";
    else
        $zodiac = "Pisces";
}
if ($month == 3) {
    $mon = "Mar";
    if ($date < 21)
        $zodiac = "Pisces";
    else
        $zodiac = "Aries";
}
if ($month == 4) {
    $mon = "Apr";
    if ($date < 20)
        $zodiac = "Aries";
    else
        $zodiac = "Taurus";
}
if ($month == 5) {
    $mon = "May";
    if ($date < 21)
        $zodiac = "Taurus";
    else
        $zodiac = "Gemini";
}
if ($month == 6) {
    $mon = "Jun";
    if ($date < 21)
        $zodiac = "Gemini";
    else
        $zodiac = "Cancer";
}
if ($month == 7) {
    $mon = "Jul";
    if ($date < 23)
        $zodiac = "Cancer";
    else
        $zodiac = "Leo";
}
if ($month == 8) {
    $mon = "Aug";
    if ($date < 23)
        $zodiac = "Leo";
    else
        $zodiac = "Virgo";
}
if ($month == 9) {
    $mon = "Sep";
    if ($date < 23)
        $zodiac = "Virgo";
    else
        $zodiac = "Libra";
}
if ($month == 10){
    $mon = "Oct";
    if ($date < 23)
        $zodiac = "Libra";
    else
        $zodiac = "Scorpio";
}
if ($month == 11) {
    $mon = "Nov";
    if ($date < 22)
        $zodiac = "Scorpio";
    else
        $zodiac = "Sagittarius";
}
if ($month == 12) {
    $mon = "Dec";
    if ($date < 22)
        $zodiac = "Sagittarius";
    else
        $zodiac = "Capricorn";
}
echo "Your date of birth is $mon $date<br>";

if ($month > 12 || $month < 1 || $date > 31 || $date < 1) {
    echo "<H1>Error: Invalid Information</H1>";
    echo "Please type your date of birth correctly<br>";
}
else if (($month == 2 && $date > 29) || (($month == 4 || $month == 6 || $month == 9 || $month == 11)) && $date > 30) {
    echo "<H1>Error: Invalid Information</H1>";
    echo "Please type your date of birth correctly<br>";
}
else{
    $servername = "localhost:3306";
    $username = "test";
    $password = "1234";
    $dbname = "p3";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_errno()) {
        echo "connection failed".mysqli_connect_error();
    }
    $query = "SELECT name, textUrl, imgUrl FROM horoscopes WHERE name LIKE '$zodiac%'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($result);
    $textUrl = $data['textUrl'];
    $name = $data['name'];


    echo "<H1>$name</H1>";
    echo '<img src = '.$data['imgUrl'].' width=100><br><br>';
    $fp = fopen($textUrl, 'r') or die("cannot open file $textUrl");
    while (!feof($fp)) {
        echo fgets($fp);
    };
    fclose($fp);
}