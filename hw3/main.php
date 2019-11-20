<html>
    <head>
        <title>My Zodiac</title>
        <style>
            .short{
                width: 40px;
            }
        </style>
    </head>

    <body bgcolor="black" text="white">
        <h2 align="center">My Zodiac</h2>
        <form method="get" action="result.php">
            <table bgcolor="black" width="600" cellpadding="5" cellspacing="1" align="center" border="1">
                <tr align="center">
                    <td rowspan="4"><img src="./img/main.jpg" width="120"></td>
                    <td>Enter your name : <input type="text" name="name" id="name" required></td>
                </tr>
                <tr align="center">
                    <td>Choose your gender : <input type="radio" value="Male" name="gender" required> Male <input type="radio" value="Female" name="gender" id="gender" required> Female</td>
                </tr>
                <tr align="center">
                    <td>Enter your date of birth : Month <input type="text" name="month" id="month" class="short" required> Date <input type="text" name="date" id="date" class="short" required></td>
                </tr>
                <tr align="center">
                    <td><input type="submit" value="show my zodiac" name="submit" align="center"></td>
                </tr>
            </table>
        </form>
        <button type="button" onclick="this.open('http://localhost:8080/hw3/showAll.php')"> ALL </button>
    </body>
</html>