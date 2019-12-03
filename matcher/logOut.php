<?php
session_start();
if (!isset($_SESSION["studNum"])) {
    echo "<h4>Please Sign In</h4>";
}
else {
    session_destroy();
    echo "<h4>Log Out Successed</h4>";
}
?>