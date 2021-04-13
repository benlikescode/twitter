<?php
    
    
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    $sessiontoken = $_SESSION['usertoken'];

    if (isset($_POST["loadmessages"])) {
        
        $sql = "SELECT * FROM profileactions where usertoken='$sessiontoken' AND profileaction='follow' LIMIT 10";
        $result = mysqli_query($conn,$sql);
        
        /*
        $sql = "SELECT * FROM users WHERE NOT usertoken='$sessiontoken' LIMIT 5";
        $result = mysqli_query($conn,$sql);
        */

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $sql1 = "SELECT * FROM users WHERE usertoken='" . $row['profiletoken'] . "' LIMIT 1";
            $result1 = mysqli_query($conn,$sql1);
            $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

            $sql2 = "SELECT * FROM userdetails WHERE usertoken='" . $row1['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result2 = mysqli_query($conn,$sql2);

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                $postuseravatar = $row2["userdetailcontent"];
            }

            echo "
                <div name='followed-user-container' class='followed-user-container' data-user-token=" . $row['profiletoken'] . ">
                    <div class='feed-tweet-profile-pic'>
                        <img src='$postuseravatar' alt=''>
                    </div>
                    <div class='followed-user-name'>" . $row1['username'] . "</div>
                   
                </div>
                
            
            
            
            ";
            
        }
    }

    /*if (isset($_POST["new-msg-next-btn"])) {}*/
        if (isset($_POST["userToken"])) {
            echo $_POST["userToken"];
        }

    
    

    

?>

