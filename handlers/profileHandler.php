<?php
    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    

  
    

    if (isset($_POST["followprofile"])) {
        $profiletoken = $_POST['profiletoken'];
        $usertoken = $_SESSION['usertoken'];
        $profileaction;
        $profileactiondate = date('m/d/Y h:i:s a', time());
        

        // STEP 1

        $sql = "SELECT * FROM profileactions WHERE profileaction='follow' AND profiletoken='$profiletoken' AND usertoken='$usertoken'";
        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) > 0) {
            $profileaction = "unfollow";
            $sql1 = "DELETE FROM profileactions WHERE profileaction='follow' AND profiletoken='$profiletoken' AND usertoken='$usertoken'";
            $result1 = mysqli_query($conn,$sql1);
        }
        else {
            $profileaction = "follow";
            $sql1 = "INSERT INTO profileactions (profileaction, profileactiondate, profiletoken, usertoken) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql1);
            $stmt->bind_param('ssss', $profileaction, $profileactiondate, $profiletoken, $usertoken);
            $stmt->execute();
        }


        //

        header('Content-Type: application/json');
        $response;

        // STEP 2

        $response->result = $profileaction;
        
        echo json_encode($response, JSON_FORCE_OBJECT);
    }