<HTML>
<HEAD>
    <TITLE>Tutor-Tutee Matching System</TITLE>
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
</HEAD>
<BODY>

</BODY>
</HTML>

<?php
session_start();
if (!isset($_SESSION["studNum"])) {
    echo "<h3>Please Sign In</h3>";
    echo "<button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button>";
}
else {
    session_destroy();
    echo "<h4>Log Out Successed</h4>";
}
?>