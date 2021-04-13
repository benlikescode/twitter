<?php 

    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    $usertoken = $_SESSION['usertoken'];

    /*This Controller inserts the data from a users new tweet into the db and any actions on that post such as
    likes, comments, retweets etc.*/


    
    if (isset($_POST['new-tweet-btn'])) {
        $tweetmediapath = "";

        // Storing the media into the server and the reference in the DB

        if ($_FILES['tweetmedia']['size'] !== 0) {
        $tweetMediaToken = bin2hex(random_bytes(6));
    
        $allowedExts = array("png", "jpeg", "jpg", "gif");
        $fileext = pathinfo($_FILES['tweetmedia']['name'], PATHINFO_EXTENSION);

            if (($_FILES["tweetmedia"]["size"] < 200000000)
            && in_array($fileext, $allowedExts)) {
        
                if ($_FILES["tweetmedia"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["tweetmedia"]["error"] . "<br />";
                } 
                else {
                    move_uploaded_file($_FILES['tweetmedia']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/content/user/tweet_media/' . $tweetMediaToken . "." . $fileext);

                   
                    $tweetmediapath = "/projects/twitter/content/user/tweet_media/" . $tweetMediaToken . "." . $fileext;
                    

                }
            }
        }


        $postcontent = strip_tags($_POST['new-tweet-input']);
        $postdate = date('m/d/Y h:i:s a', time());
        $posttoken = bin2hex(random_bytes(6));

        if ($postcontent != "" || $tweetmediapath != "") {
            $sql = "INSERT INTO posts (postcontent, postmedia, postdate, posttoken, usertoken) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $postcontent, $tweetmediapath, $postdate, $posttoken, $usertoken);
            $stmt->execute();
        }
    }

    if (isset($_POST['likepost'])) {

        $postactiondate = date('m/d/Y h:i:s a', time());
        $postaction = "like";
        $posttoken = $_POST['posttoken'];

        $likebool = 0;

        $sql2 = "SELECT * FROM postactions WHERE usertoken='$usertoken' AND posttoken='$posttoken' AND postaction='$postaction' LIMIT 1";
        $result2 = mysqli_query($conn,$sql2);
        if (mysqli_num_rows($result2) == 0) {
            $sql = "INSERT INTO postactions (postaction, postactiondate, posttoken, usertoken) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $postaction, $postactiondate, $posttoken, $usertoken);
            $stmt->execute();
            $likebool = 1;
        }
        else {
            $sql = "DELETE FROM postactions WHERE usertoken='$usertoken' AND posttoken='$posttoken' AND postaction='$postaction'";
            if (!mysqli_query($conn, $sql)) {
                echo "Error deleting record: " . mysqli_error($conn);
            } 
            mysqli_close($conn); 
        }
        echo $likebool;

       

        

    }

    if (isset($_POST['retweetpost'])) {

        $postactiondate = date('m/d/Y h:i:s a', time());
        $postaction = "retweet";
        $posttoken = $_POST['posttoken'];

        $retweetbool = 0;

        $sql2 = "SELECT * FROM postactions WHERE usertoken='$usertoken' AND posttoken='$posttoken' AND postaction='$postaction' LIMIT 1";
        $result2 = mysqli_query($conn,$sql2);
        if (mysqli_num_rows($result2) == 0) {
            $sql = "INSERT INTO postactions (postaction, postactiondate, posttoken, usertoken) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $postaction, $postactiondate, $posttoken, $usertoken);
            $stmt->execute();
            $retweetbool = 1;
        }
        else {
            $sql = "DELETE FROM postactions WHERE usertoken='$usertoken' AND posttoken='$posttoken' AND postaction='$postaction'";
            if (!mysqli_query($conn, $sql)) {
                echo "Error deleting record: " . mysqli_error($conn);
            } 
            mysqli_close($conn); 
        }
        echo $retweetbool;

    }

    if (isset($_POST['deletepost'])) {

        $postToken = $_POST['postToken'];
        $sql = "DELETE FROM posts WHERE posttoken='" . $postToken . "'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error deleting record: " . mysqli_error($conn);
        } 
        mysqli_close($conn); 
    }

    

    //If the user uploads media in their tweet
    //Note this is still work in progress!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


    /*
    if (isset($_POST['tweetmedia'])) {

        $tweetMediaToken = bin2hex(random_bytes(6));
    
        $allowedExts = array("png", "jpeg", "jpg", "gif");
        $fileext = pathinfo($_FILES['tweetmedia']['name'], PATHINFO_EXTENSION);

        if (($_FILES["tweetmedia"]["size"] < 200000000)
        && in_array($fileext, $allowedExts)) {
    
            if ($_FILES["tweetmedia"]["error"] > 0) {
                echo "Return Code: " . $_FILES["tweetmedia"]["error"] . "<br />";
            } 
            else {
                move_uploaded_file($_FILES['tweetmedia']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/content/user/tweet_media/' . $tweetMediaToken . "." . $fileext);

                $save = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/tweet_media/" . $tweetMediaToken . ".png";
                $file = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/tweet_media/" . $tweetMediaToken . "." . $fileext; 

                list($widthold, $heightold) = getimagesize($file) ; 

                $info = getimagesize($file);

                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($file);
                }

                elseif ($info['mime'] == 'image/gif')  {
                    $image = imagecreatefromgif($file);
                }

                elseif ($info['mime'] == 'image/png') {
                    $image = imagecreatefrompng($file);
                }

                $width = 150;
                $height = 150;

                $tn = imagecreatetruecolor($width, $height) ; 

                if(($widthold/$width) > ($heightold / $height)) {
                    $y = 0;
                    $x = $widthold - (($heightold * $width) / $height);
                } else {
                    $x = 0;
                    $y = $heightold - (($widthold * $height) / $width);
                }

                $tn = imagecreatetruecolor($width, $height);
                imagecopyresized($tn, $image, 0, 0, $x/2, $y/2, $width, $height, $widthold - $x, $heightold - $y);

                imagejpeg($tn, $save, 70); 
                

                $tweetmediapath = "/projects/twitter/content/user/tweet_media/" . $tweetMediaToken . ".png";
                unlink($file);
                

            }
        }

    }
    */

    