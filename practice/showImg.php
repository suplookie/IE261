<!doctype html>
<html>
    <head></head>
    <body>
        <form action = "./upload.php" method="post" enctype="multipart/form-data">
            <div>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <input type="submit" value="upload" name="submit">
        </form>

        <ul>
            <?php
                $servername = "localhost:3306";
                $username = "test";
                $password = "1234";
                $dbname = "omens";

                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (mysqli_connect_errno()) {
                    echo "connection failed".mysqli_connect_error();
                }
                $query = "SELECT * FROM images";
                $result = mysqli_query($conn, $query);

                while ($data = mysqli_fetch_array($result)) {
                    echo '<li style = \'float: left; margin: 2px;\'>';
                    echo '<img src = '.$data['imgurl'].' width=200><br>';
                    echo ($data['filename']);
                    echo '</li><br>';
                }

                mysqli_close($conn);
            ?>
        </ul>
    </body>
</html>