<?php

    /*This Controller is in charge of getting all of your tweets and displaying them on your profile
    page. Also in charge of getting all of your followers/following. Lastly, it is responsible for
    updating and saving the changes made on the edit profile page.*/

    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/functionController.php');


    $profileSessionToken = $_SESSION['usertoken'];

    
    
    

    if (isset($_POST["loadprofiletweets"])) {
        $usertoken = $_POST['userToken'];

        $sqlprofiletweets = "SELECT * FROM posts WHERE usertoken='$usertoken' ORDER BY id DESC LIMIT 30";
        $resultprofiletweets = mysqli_query($conn,$sqlprofiletweets);
        while($rowprofiletweets = mysqli_fetch_array($resultprofiletweets, MYSQLI_ASSOC)) {

            // Getting Media

            $postMedia = $rowprofiletweets['postmedia'];

            //Getting username

            $sql1 = "SELECT * FROM users WHERE usertoken='" . $rowprofiletweets['usertoken'] . "' LIMIT 1";
            $result1 = mysqli_query($conn,$sql1);
            $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
            $postusername = $row1['username'];

            //Getting user profile image

            $sql2 = "SELECT * FROM userdetails WHERE usertoken='" . $rowprofiletweets['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result2 = mysqli_query($conn,$sql2);
            

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                $postuseravatar = $row2["userdetailcontent"];
            }
            if ($postuseravatar == "") {
                $postuseravatar = "/projects/twitter/img/default_avatar.png";
            }

            // Checking if this user has liked this post
            $likedPost = false;

            $sql2 = "SELECT * FROM postactions WHERE usertoken='" . $profileSessionToken . "' AND posttoken='" . $rowprofiletweets['posttoken'] . "' AND postaction='like'";
            $result2 = mysqli_query($conn,$sql2);
            if (mysqli_num_rows($result2) > 0) {
                $likedPost = true;
            }
            // Checking if this user has retweeted this post
            $retweetedPost = false;
    
            $sql2 = "SELECT * FROM postactions WHERE usertoken='" . $profileSessionToken . "' AND posttoken='" . $rowprofiletweets['posttoken'] . "' AND postaction='retweet'";
            $result2 = mysqli_query($conn,$sql2);
            if (mysqli_num_rows($result2) > 0) {
                $retweetedPost = true;
            }


            //Getting Like Count

            $sql2 = "SELECT * FROM postactions WHERE postaction='like' AND posttoken='" . $rowprofiletweets['posttoken'] . "'";
            $result2 = mysqli_query($conn,$sql2);

            $postlikecount = mysqli_num_rows($result2);

            //Getting Retweet Count

            $sql3 = "SELECT * FROM postactions WHERE postaction='retweet' AND posttoken='" . $rowprofiletweets['posttoken'] . "'";
            $result3 = mysqli_query($conn,$sql3);

            $postretweetcount = mysqli_num_rows($result3);

            //Getting Comment Count

            $sql4 = "SELECT * FROM postactions WHERE postaction='comment' AND posttoken='" . $rowprofiletweets['posttoken'] . "'";
            $result4 = mysqli_query($conn,$sql4);

            $postcommentcount = mysqli_num_rows($result4);
            
            echo "
                    
                <div class='new-tweet-container' data-post-token='" . $rowprofiletweets['posttoken'] . "' id='profile-tweet-container'>
                    <div class='new-tweet-img'>
                        <img src='" . $postuseravatar . "' alt=''>
                    </div>
                    <div class='new-tweet-body'>
                        <div class='new-tweet-header'>
                            <div class='tweet-header-left'>
                                <span class='new-tweet-name'>" . $postusername . "</span>
                                <span class='new-tweet-username'></span>
                                <span class='new-tweet-date'>" . time_elapsed($rowprofiletweets['postdate']) . "</span>
                            </div>";

                            if ($usertoken == $profileSessionToken) {
                                echo "
                                <div class='tweet-header-right'>
                                    <button class='tweet-delete-btn'>
                                        <svg viewBox='0 0 24 24'><g><path d='M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z'></path><path d='M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z'></path></g></svg>
                                    </button>
                                </div>
                                ";
                            }
                          
                        echo "
                        </div>

                        <div class='new-tweet-text'>
                            <p>" . $rowprofiletweets['postcontent'] . "</p>  
                        </div>";

                        if (!empty($postMedia)) {
                            echo "
                                <div class='new-tweet-media'>
                                    <img src='" . $postMedia . "' class='post-media-img'>
                                </div>
                            ";
                        }

                        echo "<div class='new-tweet-icons'>
                                <div class='tweet-icon-wrapper' data-feed-button='comment'>
                                    <div class='icon-wrapper-flex' aria-label='comment-button' id='tweet-icon-div'>
                                        <svg viewBox='0 0 24 24' class=''><g><path d='M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z'></path></g></svg>
                                    </div>
                                    <span>" . $postcommentcount . "</span>
                                </div>";

                        
                        
                            
                        if ($retweetedPost) {
                            echo "
                                <div class='tweet-icon-wrapper' data-feed-button='retweet'>    
                                    <div class='retweeted-btn icon-wrapper-flex' id='tweet-icon-div' aria-label='retweet-button'>
                                        <svg viewBox='0 0 24 24' id='retweeted-svg'><g><path d='M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z'></path></g></svg>   
                                    </div>
                                    <span id='retweeted-span'>" . $postretweetcount ."</span>
                                </div>
                            ";
                        }
                        else {
                            echo "
                                <div class='tweet-icon-wrapper' data-feed-button='retweet'>    
                                    <div class='icon-wrapper-flex' aria-label='retweet-button' id='tweet-icon-div'>
                                        <svg viewBox='0 0 24 24'><g><path d='M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z'></path></g></svg>   
                                    </div>
                                    <span>" . $postretweetcount ."</span>
                                </div>
                            "; 
                        }
                        
                        if ($likedPost) {
                            echo "
                                <div class='tweet-icon-wrapper' data-feed-button='like'>    
                                    <div class='liked-btn icon-wrapper-flex' id='tweet-icon-div' aria-label='like-button'>
                                        <svg viewBox='0 0 24 24' id='liked-svg'><g><path d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z'></path></g></svg>
                                    </div>
                                    <span id ='liked-span'>" . $postlikecount ."</span>
                                </div>
                            ";
                        }
                        else {
                            echo "
                                <div class='tweet-icon-wrapper' data-feed-button='like'>    
                                    <div class='icon-wrapper-flex' aria-label='like-button' id='tweet-icon-div'>
                                        <svg viewBox='0 0 24 24'><g><path d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z'></path></g></svg>  
                                    </div>
                                    <span>" . $postlikecount ."</span>
                                </div>
                            "; 
                        }
                        
                        echo "
     
                            <div class='tweet-icon-wrapper' data-feed-button='share'>    
                                <div class='icon-wrapper-flex' aria-label='share-button' id='tweet-icon-div'>
                                    <svg viewBox='0 0 24 24' class=''><g><path d='M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z'></path><path d='M19.708 21.944H4.292C3.028 21.944 2 20.916 2 19.652V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 1.264-1.028 2.292-2.292 2.292z'></path></g></svg>       
                                </div>
                            </div>  
                                  
                        </div>
                    </div>
                </div>
            
            "; 
                   

        }    
    }  

    if (isset($_POST["loaduserfollowing"])) {

        //Getting all of the users that this user follows
        $sqluserfollowing = "SELECT * FROM profileactions WHERE usertoken='$profileSessionToken' AND profileaction='follow'";
        $resultfollowing = mysqli_query($conn,$sqluserfollowing);
        while ($rowfollowing = mysqli_fetch_array($resultfollowing, MYSQLI_ASSOC)) {

            //Get each of these users avatar

            $sql10 = "SELECT * FROM userdetails WHERE usertoken='" . $rowfollowing['profiletoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result10 = mysqli_query($conn,$sql10);
            $row10 = mysqli_fetch_array($result10, MYSQLI_ASSOC);
            $userfollowingavatar = $row10['userdetailcontent'];

            //Checking if the user does not have an avatar and if so setting the variable to the default avatar path

            if (mysqli_num_rows($result10) == 0) {
                $userfollowingavatar = "/projects/twitter/img/default_avatar.png";
            }
            
            //Get each of these users bio

            $sql9 = "SELECT * FROM userdetails WHERE usertoken='" . $rowfollowing['profiletoken'] . "' AND userdetail='userbio' LIMIT 1";
            $result9 = mysqli_query($conn,$sql9);
            $row9 = mysqli_fetch_array($result9, MYSQLI_ASSOC);
            $userfollowingbio = $row9['userdetailcontent'];

            //Get each of these users name

            $sql8 = "SELECT * FROM users WHERE usertoken='" . $rowfollowing['profiletoken'] . "' LIMIT 1";
            $result8 = mysqli_query($conn,$sql8);
            $row8 = mysqli_fetch_array($result8, MYSQLI_ASSOC);
            $userfollowingname = $row8['username'];

            echo "
                    
            <div class='user-following-container' data-post-token=''>
                <div class='user-following-avatar'>
                    <img src='" . $userfollowingavatar . "' alt=''>
                </div>

                <div class='user-following-body'>
                    <div class='user-following-top'>
                        <span class='user-following-name'>" . $userfollowingname . "</span>
                        <button class='user-following-follow-btn' data-follow-type='following'></button>
                    </div>

                    <div class='user-following-bottom'>
                        <span class='user-following-bio'>" . $userfollowingbio . "</span>
                    </div>
                </div>
      
               
            </div>
        "; 


        }
            

    }

    if (isset($_POST["loaduserfollowers"])) {

        //Getting all of this users followers
        $sqluserfollowers = "SELECT * FROM profileactions WHERE profiletoken='$profileSessionToken' AND profileaction='follow'";
        $resultfollowers = mysqli_query($conn,$sqluserfollowers);
        while ($rowfollowers = mysqli_fetch_array($resultfollowers, MYSQLI_ASSOC)) {

            //Get each of these users avatar

            $sql11 = "SELECT * FROM userdetails WHERE usertoken='" . $rowfollowers['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result11 = mysqli_query($conn,$sql11);
            $row11 = mysqli_fetch_array($result11, MYSQLI_ASSOC);
            $userfollowersavatar = $row11['userdetailcontent'];

            //Checking if the user does not have an avatar and if so setting the variable to the default avatar path

            if (mysqli_num_rows($result11) == 0) {
                $userfollowersavatar = "/projects/twitter/img/default_avatar.png";
            }

            //Get each of these users bio
            
            $sql12 = "SELECT * FROM userdetails WHERE usertoken='" . $rowfollowers['usertoken'] . "' AND userdetail='userbio' LIMIT 1";
            $result12 = mysqli_query($conn,$sql12);
            $row12 = mysqli_fetch_array($result12, MYSQLI_ASSOC);
            $userfollowersbio = $row12['userdetailcontent'];

            //Get each of these users name

            $sql14 = "SELECT * FROM users WHERE usertoken='" . $rowfollowers['usertoken'] . "' LIMIT 1";
            $result14 = mysqli_query($conn,$sql14);
            $row14 = mysqli_fetch_array($result14, MYSQLI_ASSOC);
            $userfollowersname = $row14['username'];

            //Check if this user follows the current follower back

            $sqlfollowcheck = "SELECT * FROM profileactions WHERE profiletoken='" . $rowfollowers['usertoken'] . "' AND usertoken='$profileSessionToken' AND profileaction='follow'";
            $resultfollowcheck = mysqli_query($conn,$sqlfollowcheck);
            $rowfollowcheck = mysqli_fetch_array($resultfollowcheck, MYSQLI_ASSOC);

            //if rows is zero then this user does not follow current user back

            if (mysqli_num_rows($resultfollowcheck) == 0) {
                $doesNotFollowBack = true;
            }
            else {
                $doesNotFollowBack = false;
            }

            $followOrFollowingButton = "";

            if ($doesNotFollowBack) {
                $followOrFollowingButton = "follow";
            }
            else {
                $followOrFollowingButton = "following";
            }
            

            echo "
                    
            <div class='user-following-container' data-post-token=''>
                <div class='user-following-avatar'>
                    <img src='" . $userfollowersavatar . "' alt=''>
                </div>

                <div class='user-following-body'>
                    <div class='user-following-top'>
                        <span class='user-following-name'>" . $userfollowersname . "</span>
                        <button class='user-following-follow-btn' data-follow-type='" . $followOrFollowingButton . "' id=" . $followOrFollowingButton . "></button>
                    </div>

                    <div class='user-following-bottom'>
                        <span class='user-following-bio'>" . $userfollowersbio . "</span>
                    </div>
                </div>
            
            </div>
        "; 


        }
            

    }

    

   

       
    

    if (isset($_POST["edit-profile-save"])) {
        $userbanner = strip_tags($_POST["edit-profile-banner"]); //image going to need some more work
        $displayname = strip_tags($_POST["edit-name"]);
        $userbio = strip_tags($_POST["edit-bio"]);
        $userlocation = strip_tags($_POST["edit-location"]);
        $userwebsite = strip_tags($_POST["edit-website"]);

        //Updating Display Name

        $sqldisplaynamecheck = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='userdisplayname' LIMIT 1";
        $resultdisplaynamecheck = mysqli_query($conn,$sqldisplaynamecheck);

        $userdetail = "userdisplayname";
        
        if (mysqli_num_rows($resultdisplaynamecheck) == 0) {
            $sqldisplaynameinsert = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqldisplaynameinsert);
            $stmt->bind_param('sss', $userdetail, $displayname, $profileSessionToken);
            $stmt->execute();
        }
        else {
            if ($displayname !== "") {
                $sqldisplayname = "UPDATE userdetails SET userdetailcontent='$displayname' WHERE usertoken='$profileSessionToken' AND userdetail='userdisplayname'";
                $resultdisplayname = mysqli_query($conn,$sqldisplayname);
            }
           
        }
        


        //Updating Bio

        $sqlbiocheck = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='userbio' LIMIT 1";
        $resultbiocheck = mysqli_query($conn,$sqlbiocheck);

        $userdetail = "userbio";
        
        if (mysqli_num_rows($resultbiocheck) == 0) {
            $sqlbioinsert = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlbioinsert);
            $stmt->bind_param('sss', $userdetail, $userbio, $profileSessionToken);
            $stmt->execute();
        }
        else {
            if ($userbio !== "") {
                $sqlbio = "UPDATE userdetails SET userdetailcontent='$userbio' WHERE usertoken='$profileSessionToken' AND userdetail='userbio'";
                $resultbio = mysqli_query($conn,$sqlbio);
            }
           
        }

        //Updating Location

        $sqllocationcheck = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='userlocation' LIMIT 1";
        $resultlocationcheck = mysqli_query($conn,$sqllocationcheck);

        $userdetail = "userlocation";
        
        if (mysqli_num_rows($resultlocationcheck) == 0) {
            $sqllocationinsert = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqllocationinsert);
            $stmt->bind_param('sss', $userdetail, $userlocation, $profileSessionToken);
            $stmt->execute();
        }
        else {
            if ($userlocation !== "") {
                $sqllocation = "UPDATE userdetails SET userdetailcontent='$userlocation' WHERE usertoken='$profileSessionToken' AND userdetail='userlocation'";
                $resultlocation = mysqli_query($conn,$sqllocation);
            }
            
        }

        //Updating Website

        $sqlwebsitecheck = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='userwebsite' LIMIT 1";
        $resultwebsitecheck = mysqli_query($conn, $sqlwebsitecheck);

        $userdetail = "userwebsite";
        
        if (mysqli_num_rows($resultwebsitecheck) == 0) {
            $sqlwebsiteinsert = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlwebsiteinsert);
            $stmt->bind_param('sss', $userdetail, $userwebsite, $profileSessionToken);
            $stmt->execute();
        }
        else {
            if ($userwebsite !== "") {
                $sqlwebsite = "UPDATE userdetails SET userdetailcontent='$userwebsite' WHERE usertoken='$profileSessionToken' AND userdetail='userwebsite'";
                $resultwebsite = mysqli_query($conn,$sqlwebsite);
            }
           
        }

        //Updating Profile Picture

        if ($_FILES['useravatar']['size'] !== 0) {

            $sql = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='useravatar' LIMIT 1";
            $result = mysqli_query($conn,$sql);
    
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $formeruseravatar = $row['userdetailcontent'];
            }
            
            $avatartoken = bin2hex(random_bytes(6));

            $allowedExts = array("png", "jpeg", "jpg", "gif");
            $fileext = pathinfo($_FILES['useravatar']['name'], PATHINFO_EXTENSION);

            if (($_FILES["useravatar"]["size"] < 200000000)
            && in_array($fileext, $allowedExts)) {
        
                if ($_FILES["useravatar"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["useravatar"]["error"] . "<br />";
                } 
                else {
                    
                    move_uploaded_file($_FILES['useravatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/content/user/profile_images/' . $avatartoken . "." . $fileext);
    
                    
                    $file = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_images/" . $avatartoken . "." . $fileext; 
                    $avatartoken = bin2hex(random_bytes(6));
                    $save = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_images/" . $avatartoken . ".png";

                    list($widthold, $heightold) = getimagesize($file) ; 

                    $info = getimagesize($file);

                    if ($info['mime'] == 'image/jpeg') {
                        $image = imagecreatefromjpeg($file);
                    }
                    elseif ($info['mime'] == 'image/gif')  {
                        $image = imagecreatefromgif($file);
                    }
                    elseif ($fileext == 'png') {
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

                    if ($fileext == 'jpeg' || $fileext == 'jpg') {
                        imagejpeg($tn, $save, 70); 
                    }
                    elseif ($fileext == 'gif')  {
                        imagegif($tn, $save); 
                    }
                    elseif ($fileext == 'png') {
                        imagepng($tn, $save); 
                    }

                    $useravatar = "/projects/twitter/content/user/profile_images/" . $avatartoken . ".png";
                    unlink($file);

                }
            }

            $userdetail = "useravatar";

            if (isset($formeruseravatar) && $formeruseravatar !== "") {
                unlink($_SERVER['DOCUMENT_ROOT'] . $formeruseravatar);
                $sql = "UPDATE userdetails SET userdetailcontent='$useravatar' WHERE usertoken='$profileSessionToken' AND userdetail='useravatar'";
                $result = mysqli_query($conn,$sql);
            }
            else {
                $sql = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $userdetail, $useravatar, $profileSessionToken);
                $stmt->execute();
            }

        }

        //Updating User Banner Picture

        if ($_FILES['edit-profile-banner']['size'] !== 0) {

            $sql = "SELECT * FROM userdetails WHERE usertoken='$profileSessionToken' AND userdetail='userbanner' LIMIT 1";
            $result = mysqli_query($conn,$sql);
    
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $formerBannerAvatar = $row['userdetailcontent'];
            }
            
            $bannerToken = bin2hex(random_bytes(6));

            $allowedExts = array("png", "jpeg", "jpg", "gif");
            $fileext = pathinfo($_FILES['edit-profile-banner']['name'], PATHINFO_EXTENSION);

            if (($_FILES["edit-profile-banner"]["size"] < 200000000)
            && in_array($fileext, $allowedExts)) {
        
                if ($_FILES["edit-profile-banner"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["edit-profile-banner"]["error"] . "<br />";
                } 
                else {
                    
                    move_uploaded_file($_FILES['edit-profile-banner']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/content/user/profile_banners/' . $bannerToken . "." . $fileext);
    
                    $save = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_banners/" . $bannerToken . ".png";
                    $file = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_banners/" . $bannerToken . "." . $fileext; 

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

                    $width = 632;
                    $height = 200;

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

                    $userBannerAvatar = "/projects/twitter/content/user/profile_banners/" . $bannerToken . ".png";
                    unlink($file);

                }
            }

            $userdetail = "userbanner";

            if (isset($formerBannerAvatar) && $formerBannerAvatar !== "") {
                unlink($_SERVER['DOCUMENT_ROOT'] . $formerBannerAvatar);
                $sql = "UPDATE userdetails SET userdetailcontent='$userBannerAvatar' WHERE usertoken='$profileSessionToken' AND userdetail='userbanner'";
                $result = mysqli_query($conn,$sql);
            }
            else {
                $sql = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $userdetail, $userBannerAvatar, $profileSessionToken);
                $stmt->execute();
            }

        }










        //At the end of updating, redirect them back to their page

        $sqlgetusername = "SELECT * FROM users WHERE usertoken='$profileSessionToken' LIMIT 1";
        $resultusername = mysqli_query($conn, $sqlgetusername);
        $rowusername = mysqli_fetch_array($resultusername, MYSQLI_ASSOC);
        $userName = $rowusername['username'];

        header("location: /projects/twitter/user/$userName");
    }

?>