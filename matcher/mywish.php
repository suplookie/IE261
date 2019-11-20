
<HTML>
<HEAD>
    <TITLE>Register</TITLE>
</HEAD>
<BODY>
<h4>Add to your wishlist if there's no lecture you want</h4>
<FORM METHOD="post" ACTION="wishlist.php">
    <TABLE border="0" width="500" CELLPADDING = "5" CELLSPACING = "1">
        <TR>
            <TD>Course</TD>
            <TD><INPUT type="text" name="course"  required>
        </TR>
        <TR>
            <TD>Price Upper Bound</TD>
            <TD><INPUT type="number" name="priceUpper" required></TD>
        </TR>
        <TR>
            <TD>Time</TD>
            <TD><input type="text" name="time"></TD>
        </TR>
        <TR>
            <TD>Professor</TD>
            <TD><INPUT type="text" name="prof" required></TD>
        </TR>
    </TABLE>
    <p><INPUT type="submit" value="Add">
        <INPUT type="reset" value="Clear">
        <button onclick="location.href = 'http://localhost:8080/matcher/wishlist.php'">Cancel</button>
    </p>
</FORM>
</BODY>
</HTML>