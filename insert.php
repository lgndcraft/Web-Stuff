<?php
$names = $_POST['name'];
$passwords = $_POST['password'];
$txtarea = $_POST['txtarea'];

if (!empty($names) || !empty($passwords) || !empty($txtarea)) {
    # code...
    $host = "localhost";
    $dbUsername = "admin";
    $dbPassword = "admin";
    $dbName = "answers_db";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if (mysqli_connect_error()) {
        # code...
        die('connect error('. mysqli_connect_error().')'.mysqli_connect_error());
    }
    else{
        $SELECT = "SELECT name from answers_tb where name = ? Limit 1";
        $INSERT = "INSERT into answers_tb (name, password, message) values(?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $names);
        $stmt->execute();
        $stmt->bind_result($names);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum == 0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $names, $passwords, $txtarea);
            $stmt->execute();
            //echo "Yay";
        }
        else{
            echo"Someone used that name";
        }
        $stmt->close();
        $conn->close();
    }
}
else{
    echo "All Fields Required";
    die();
}
?>