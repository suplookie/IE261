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
            margin-top: 30px;
            margin-left: 10px;
            margin-right: 10px;
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
session_start();
$servername = $_SESSION["ip"];
$username = "test";
$password = "1234";
$dbname = "match";
$conn = new mysqli($servername, $username, $password, $dbname);
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
                    <TD>
                        <SELECT name = 'id' required>
                        <?php
                        $qu = "select * from match.kaistcourses";
                        $courseCon = $conn->query($qu);
                        while ($row = $courseCon->fetch_array()) {
                            echo "<option value=" . $row['idkaistCourses'] . ">" . $row['course'] . " by " . $row['prof'] . "</option>";
                        }
                        ?>
                        </SELECT>
                    </TD>
                </TR>
                <TR>
                    <TD>Price upper bound</TD>
                    <TD><INPUT type="number" name="priceUpper" min="0" maxlength="6" required></TD>
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