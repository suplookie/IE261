<html>
<head>
    <style>
        button, input[type=submit], input[type=reset]{
            width: 90px;
            height: 25px;
            margin: 5px;
            left: 8px;
            position: relative;
            background-color: white;
            border: 1px solid black;
            border-radius: 5px;
            color:black;
        }
        button:hover, input[type=submit]:hover, input[type=reset]:hover{
            color:white;
            background-color: black;
        }
    </style>
</head>
<?php

//$servername = "110.76.66.224";
$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}
/*echo "<script>
function openwin() {
    window.open('about:blank','popwin','width=250,height=100');
    f1.submit();

</script>";}*/
echo "<FORM METHOD=\"post\" ACTION=\"delete.php\" target='popwin'>";

echo "<h4>My Wishlist</h4>";

$selection = "select * from match.wishlist";
$result = $conn -> query($selection);
if ($result -> num_rows > 0) {
    echo "<TABLE cellpadding='5' cellspacing='1' border='1'>";
    echo "<TR><TD></TD><TD>Course</TD><TD>Professor</TD><TD>Price Upper Bound</TD></TR>";
    while ($now = $result -> fetch_assoc()) {
        $id = $now["idopen_class"];
        $courseCon = $conn -> query("select * from kaistcourses where idkaistCourses=". $now["courseId"]);
        $course = $courseCon->fetch_assoc();
        echo "<TR><TD><input type='radio' name='class' value=". $id. "></TD><TD>". $course["course"]. "</TD><TD>". $course["prof"]. "</TD><TD>". $now["priceUpper"]. "</TD></TR>";
        //echo "<input type='radio' name=\"class\" ". "value='$id'>". $now["couse"]. " ". $now["priceUpper"]. " ". $now["time"]. " ".  $now["prof"]. "<br>";
    }
    echo "</TABLE>";
}
else {
    echo "<h1>Warning: NO TRADE HISTORY IN THE PERIOD</h1>";
}
echo "<INPUT type=\"submit\" value=\"delete\" >&nbsp;";
echo "<button type='button' onclick=\"location.href ='mywish.php' \"> Add wishlist </button>";
echo "</FORM>";

$conn -> close();

//데이터베이스에 추가 구현 안함.. insert
//delete시 어떻게 할지 좀더 생각해야할듯
?>
</html>
