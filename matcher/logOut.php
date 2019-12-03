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
        #please{
            text-align: center;
            margin-top: 3em;
        }
    </style>
</HEAD>
<BODY>

</BODY>
</HTML>

<?php
session_start();
if (!isset($_SESSION["studNum"])) {
    echo "<div id='please' align='center'><h3>Please Sign In</h3></div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button></p>";
}
else {
    session_destroy();
    echo "<p><h4>Log Out Successed</h4></p>";
}
?>