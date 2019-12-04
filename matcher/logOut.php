<HTML>
<HEAD>
    <TITLE>Tutor-Tutee Matching System</TITLE>
    <style>
        button, input[type=submit], input[type=reset]{
            width: 130px;
            height: 40px;
            font-size: 18px;
            margin: 10px;
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
    </style>
</HEAD>
<BODY>

</BODY>
</HTML>

<?php
session_start();
if (!isset($_SESSION["studNum"])) {
    echo "<div id='please' align='center'>Please Sign In</div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Back</button></p>";
}
else {
    session_destroy();
    echo "<div id='please' align='center'>Log Out Successed</div>";
    echo "<p align='center'><button type='button' onclick=\"location.href ='main.html' \" class='button'>Main Menu</button></p>";
}
?>