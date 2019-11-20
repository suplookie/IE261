<?php

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if ($imageFileType != "jpg" && $imageFileType != "png"
        && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, PNG, JPEG & GIF files are allowed.";
    $uploadOk = 0;
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && $uploadOk == 1){
    $filename = $_FILES["fileToUpload"]["name"];
    $imgurl = "http://localhost:8080/uploads/".$filename;
    $size = $_FILES["fileToUpload"]["size"];

    $servername = "localhost:3306";
    $username = "test";
    $password = "1234";
    $dbname = "omens";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sql = "insert into images(filename, imgurl, size) values('$filename', '$imgurl', '$size')";
    $result = mysqli_query($conn, $sql);

    echo "<p>The file " . basename($_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
    echo "<br><img src=../uploads/".basename($_FILES["fileToUpload"]["name"]).">";
    echo "<br><button type='button' onclick='history.back()'>back</button>";

    mysqli_close($conn);
}
else {
    echo "<p>Sorry, there was an error uploading your file.</p>";
    echo "<br><button type='button' onclick='history.back()'>back</button>";
}

?>