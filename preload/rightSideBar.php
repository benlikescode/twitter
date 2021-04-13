<?php

    // Getting Users to Append to "Who To Follow" (Currently Getting 2nd Connections - Friends of Friends)
    $secondFriendsArray = array();
    $firstFriendsArray = array();

    $usertoken = $_SESSION['usertoken'];


    // Getting all this Users 1st Connections to weed out as they already follow them so shouldnt be recommended

    $sqluserfollowing = "SELECT * FROM profileactions WHERE usertoken='$usertoken' AND profileaction='follow'";
    $resultfollowing = mysqli_query($conn,$sqluserfollowing);
    while ($rowfollowing = mysqli_fetch_array($resultfollowing, MYSQLI_ASSOC)) {
        $firstFriends = $rowfollowing['profiletoken'];
        array_push($firstFriendsArray, $firstFriends);
    }


    $sql = "SELECT * FROM profileactions WHERE usertoken='$usertoken' AND profileaction='follow'";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $firstFriends = $row['profiletoken'];
        $sql2 = "SELECT * FROM profileactions WHERE usertoken='$firstFriends' AND profileaction='follow'";
        $result2 = mysqli_query($conn,$sql2);
        while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
            $secondFriends = $row2['profiletoken'];
            //Checking that the 2nd connections are not yourself or any of your 1st connections
            if ($secondFriends != $usertoken && !in_array($secondFriends, $firstFriendsArray)) {
                array_push($secondFriendsArray, $secondFriends);
            }
        }
    }
    $randomNumber1 = rand(0, count($secondFriendsArray) - 1);
    $randomNumber2 = rand(0, count($secondFriendsArray) - 1);
    $friendName = "";
    $friendName2 = "";

    // If you have any 2nd connections (friends of friends)
    if (count($secondFriendsArray) > 0) {
        $random2ndFriendToken = $secondFriendsArray[$randomNumber1];

        // Getting Their Username
        $sqlname = "SELECT * FROM users WHERE usertoken='$random2ndFriendToken' LIMIT 1";
        $resultname = mysqli_query($conn,$sqlname);
        $rowname = mysqli_fetch_array($resultname, MYSQLI_ASSOC);
        $friendName = $rowname['username'];
        $friendToken = $rowname['usertoken'];
        // Getting Their Avatar
        $sql2 = "SELECT * FROM userdetails WHERE usertoken='$random2ndFriendToken' AND userdetail='useravatar' LIMIT 1";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        $currUserAvatar1 = $row2['userdetailcontent'];
        if ($currUserAvatar1 == "") {
            $currUserAvatar1 = "/projects/twitter/img/default_avatar.png";
        }
        if (count($secondFriendsArray) > 1 && $randomNumber1 != $randomNumber2) {
            $random2ndFriendToken2 = $secondFriendsArray[$randomNumber2];

            // Getting Their Username
            $sqlname2 = "SELECT * FROM users WHERE usertoken='$random2ndFriendToken2' LIMIT 1";
            $resultname2 = mysqli_query($conn,$sqlname2);
            $rowname2 = mysqli_fetch_array($resultname2, MYSQLI_ASSOC);
            $friendName2 = $rowname2['username'];
            $friendToken2 = $rowname2['usertoken'];
            // Getting Their Avatar
            $sql2 = "SELECT * FROM userdetails WHERE usertoken='$random2ndFriendToken2' AND userdetail='useravatar' LIMIT 1";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $currUserAvatar2 = $row2['userdetailcontent'];
            if ($currUserAvatar2 == "") {
                $currUserAvatar2 = "/projects/twitter/img/default_avatar.png";
            }
        }
        else {
            // if they dont have atleast 2 mutual connections, choose a random user
            // Getting Their Username
            $sqlname2 = "SELECT * FROM users WHERE usertoken!='$usertoken' ORDER BY RAND()  LIMIT 1";
            $resultname2 = mysqli_query($conn,$sqlname2);
            $rowname2 = mysqli_fetch_array($resultname2, MYSQLI_ASSOC);
            $friendName2 = $rowname2['username'];
            $friendToken2 = $rowname2['usertoken'];
            // Getting Their Avatar
            $sql2 = "SELECT * FROM userdetails WHERE usertoken='" . $rowname2['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $currUserAvatar2 = $row2['userdetailcontent'];
            if ($currUserAvatar2 == "") {
                $currUserAvatar2 = "/projects/twitter/img/default_avatar.png";
            }
        }
    }
    // If you dont have any 2nd connections
    else {
         // Getting Their Username
         $sqlname = "SELECT * FROM users WHERE usertoken!='$usertoken' ORDER BY RAND()  LIMIT 1";
         $resultname = mysqli_query($conn,$sqlname);
         $rowname = mysqli_fetch_array($resultname, MYSQLI_ASSOC);
         $friendName = $rowname['username'];
         $friendToken = $rowname['usertoken'];
         // Getting Their Avatar
         $sql2 = "SELECT * FROM userdetails WHERE usertoken='" . $rowname['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
         $result2 = mysqli_query($conn,$sql2);
         $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
         $currUserAvatar1 = $row2['userdetailcontent'];
         if ($currUserAvatar1 == "") {
             $currUserAvatar1 = "/projects/twitter/img/default_avatar.png";
         }
         // if they dont have atleast 2 mutual connections, choose a random user
            // Getting Their Username
            $sqlname2 = "SELECT * FROM users WHERE usertoken!='$usertoken' ORDER BY RAND()  LIMIT 1";
            $resultname2 = mysqli_query($conn,$sqlname2);
            $rowname2 = mysqli_fetch_array($resultname2, MYSQLI_ASSOC);
            $friendName2 = $rowname2['username'];
            $friendToken2 = $rowname2['usertoken'];
            // Getting Their Avatar
            $sql2 = "SELECT * FROM userdetails WHERE usertoken='" . $rowname2['usertoken'] . "' AND userdetail='useravatar' LIMIT 1";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $currUserAvatar2 = $row2['userdetailcontent'];
            if ($currUserAvatar2 == "") {
                $currUserAvatar2 = "/projects/twitter/img/default_avatar.png";
            }
    }
    $friendLink1 = "/projects/twitter/user/" . strtolower($friendName);
    $friendLink2 = "/projects/twitter/user/" . strtolower($friendName2);

?>


<section class="rightSideBar-container">
    <div class="rightsidebar-input-container">
        <input type="text" class="rightsidebar-input" placeholder="Search Twitter">
        <svg viewBox="0 0 24 24" class="search-bar-icon"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
        
       
        <div id="trendingresults"></div>
        
        <div id="searchresults"></div>

    </div>

    
   

    <div class="rightsidebar-trending-container">
        <div class="rightsidebar-trending-top">
            <span class="trending-container-header">What's happening</span>
        </div>
        
        <div class="rightsidebar-trending">
            <div class="trending-btn">
                <div class="trending-left-div">
                    <span class="trending-genre">Politics</span>
                    <span class="trending-postdate">Yesterday</span>
                    <div class="trending-content">
                        <span>House passes sweeping bill on election, government reforms</span>
                    </div>
                </div>
                <div class="trending-right-div">
                    <img src="https://pbs.twimg.com/semantic_core_img/1367219911039217665/gK8zxIUL?format=jpg&name=120x120" alt="" class="trending-img">
                </div>
            </div>

            <div class="trending-btn">
                <div class="trending-left-div">
                    <span class="trending-genre">Trending in Canada</span>
                    <div class="trending-content">
                        <span>Covid-19</span>
                    </div>
                </div>
            </div>

            <div class="trending-btn">
                <div class="trending-left-div">
                    <span class="trending-genre">Trending in Canada</span>
                    <div class="trending-content">
                        <span>#MondayMotivation</span>
                    </div>
                </div>
            </div>

            <div class="trending-btn">
                <div class="trending-left-div">
                    <span class="trending-genre">Space</span>
                    <span class="trending-postdate">4 hours ago</span>
                    <div class="trending-content">
                        <span>SpaceX’s Starship explodes after successful take-off</span>
                    </div>
                </div>
                <div class="trending-right-div">
                    <img src="https://pbs.twimg.com/semantic_core_img/1367278811507687424/RGJR8Lww?format=jpg&name=120x120" alt="" class="trending-img">
                </div>
            </div>

            <div class="trending-btn">
                <div class="trending-left-div">
                    <span class="trending-genre">NHL</span>
                    <span class="trending-postdate">Trending</span>
                    <div class="trending-content">
                        <span>Sidney Crosby</span>
                    </div>
                </div>
            </div>

            
            <button class="rightsidebar-more-btn">Show more</button>
        </div>
    </div>

    <div class="rightsidebar-who-to-follow-container">
        <div class="rightsidebar-who-to-follow-top">
            <span class="who-to-follow-header">Who to follow</span> 
        </div>
        
        <div class="rightsidebar-who-to-follow">
            <a class="who-to-follow-btn" href='<?php echo $friendLink1 ?>'>
                <div class="log-out-left">
                    <img src='<?php echo $currUserAvatar1  ?>' alt=''>
                    <div class="log-out-left-username">
                        <span><?php echo $friendName ?></span>
                        <span>@<?php echo $friendName ?></span>
                    </div>
                </div>
                <button class="not-already-following-btn" data-follow=<?php echo $friendToken ?>>Follow</button>
                
            </a>
            <a class="who-to-follow-btn" href='<?php echo $friendLink2 ?>'>
                <div class="log-out-left">
                    <img src='<?php echo $currUserAvatar2  ?>' alt=''>
                    <div class="log-out-left-username">
                        <span><?php echo $friendName2 ?></span>
                        <span>@<?php echo $friendName2 ?></span>
                    </div>
                </div>
                <button class="not-already-following-btn" data-follow=<?php echo $friendToken2 ?>>Follow</button>
            </a>
            <button class="rightsidebar-more-btn">Show more</button>
        </div> 
    </div>
</section>

<script>
    // When clicking the follow button, we want to follow the user, but since the button is nested inside an a tag
    // we have to call preventDefault. The hander for following a user is included in external profileHandler script
    $(".not-already-following-btn").click(function(event) {
        event.preventDefault();
    })
</script>


<script src="/projects/twitter/js/profileHandler.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>
<script src="/projects/twitter/js/sidebar.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>




