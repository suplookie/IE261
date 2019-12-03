<HTML>
<HEAD>
    <style>
        table{
            alignment: center;
            font-size: 20px;
            margin-top: 3em;
            border-collapse: separate;
            border: 2px solid black;
            border-radius: 20px;
            border-spacing: 5px 20px;
            font-weight: bold;
            width: max-content;
        }
        td{
            text-align: center;
        }
        button, input[type=submit], input[type=reset]{
            width: 130px;
            height: 40px;
            font-size: 18px;
            margin: 30px;
            left: 8px;
            position: relative;
            background-color: white;
            border: 2px solid black;
            border-radius: 5px;
            color:black;
            font-weight: bold;
        }
        button:hover, input[type=submit]:hover, input[type=reset]:hover{
            color:white;
            background-color: black;
        }
        #please{
            text-align: center;
            margin-top: 3em;
            font-size: 3em;
            font-weight: bold;
        }
        #select{
            text-align: center;
            margin-top: 2em;
            font-size: 1em;
            font-weight: bold;
        }
    </style>
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
        <div id='select' align='center'>Add to your wishlist if there's no lecture you want</div>
        <FORM METHOD="post" ACTION="addwish.php">
            <TABLE border="0" width="500" CELLPADDING = "5" CELLSPACING = "1" align="center">
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
            <p align='center'><INPUT type="submit" value="Add">
                <INPUT type="reset" value="Clear">
                <button onclick="location.href = 'wishlist.php'">Cancel</button></p>
            </p>
        </FORM>

<?php
$conn -> close();
?>
</BODY>
</HTML>