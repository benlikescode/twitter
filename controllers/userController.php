<?php

    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');

    $sql = "SELECT * FROM users WHERE usertoken='$usertoken' LIMIT 1";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $username = $row['username'];
        $useremail = $row['useremail'];
    }

    $sql = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='useravatar' LIMIT 1";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $useravatar = $row['userdetailcontent'];
    }

    if (mysqli_num_rows($result) == 0) {
        $useravatar = "/projects/twitter/img/default_avatar.png";
    }

?>