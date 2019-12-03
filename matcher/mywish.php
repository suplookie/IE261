
<HTML>
<HEAD>
    <TITLE>Register</TITLE>
</HEAD>
<BODY>
<?php

$servername = "143.248.219.83";
$username = "test";
$password = "1234";
$dbname = "match";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$studentnumber = $_SESSION['studNum'];

if ($conn-> connect_error) {
    die("Connection failed: " + $conn -> connect_error);
}

?>
        <h4>Add to your wishlist if there's no lecture you want</h4>
        <FORM METHOD="post" ACTION="addwish.php">
            <TABLE border="0" width="500" CELLPADDING="5" CELLSPACING="1">
                <TR>
                    <TD>Course</TD>
                    <TD><INPUT type="text" name="course" required>
                </TR>
                <TR>
                    <TD>Price Upper Bound</TD>
                    <TD><INPUT type="number" name="priceUpper" required></TD>
                </TR>
                <TR>
                    <TD>Professor</TD>
                    <TD><INPUT type="text" name="prof" required></TD>
                </TR>
            </TABLE>
            <p><INPUT type="submit" value="Add">
                <INPUT type="reset" value="Clear">
                <button onclick="location.href = 'wishlist.php'">Cancel</button>
            </p>
        </FORM>

<?php
$conn -> close();
?>
</BODY>
</HTML>