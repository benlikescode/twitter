<?php
    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/functionController.php');
 
    $usertoken = $_SESSION['usertoken'];
 
    
    if (isset($_POST["loadtrending"])) {

        $postsLikesArray = array();
 
        $sql = "SELECT * FROM posts";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $sql1 = "SELECT * FROM postactions WHERE posttoken='" . $row['posttoken'] . "' AND postaction='like'";
            $result1 = mysqli_query($conn,$sql1);
            $likeCount = mysqli_num_rows($result1);
            
            
 
            array_push($postsLikesArray, $likeCount);
 
        }
 
        rsort($postsLikesArray);
 
        $mostLikes1 = $postsLikesArray[0];
        $mostLikes2 = $postsLikesArray[1];
        $mostLikes3 = $postsLikesArray[2];
        $mostLikes1Token = "";
        $mostLikes2Token = "";
        $mostLikes3Token = "";
        
        $sql2 = "SELECT * FROM posts";
        $result2 = mysqli_query($conn,$sql2);
        while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
            $sql3 = "SELECT * FROM postactions WHERE posttoken='" . $row2['posttoken'] . "' AND postaction='like'";
            $result3 = mysqli_query($conn,$sql3);
            $likeCount3 = mysqli_num_rows($result3);
 
            if ($likeCount3 == $mostLikes1) {
                $mostLikes1Token = $row2['posttoken'];
            }
            else if ($likeCount3 == $mostLikes2) {
                $mostLikes2Token = $row2['posttoken'];
            }
            else if ($likeCount3 == $mostLikes3) {
                $mostLikes3Token = $row2['posttoken'];
            }
            
 
        }

        $trendingTokenArray = array();
        $trendingTokenArray[0] = $mostLikes1Token;
        $trendingTokenArray[1] = $mostLikes2Token;
        $trendingTokenArray[2] = $mostLikes3Token;

        $trendingTokenArrayLength = count($trendingTokenArray);

        for ($x = 0; $x < $trendingTokenArrayLength; $x++) {

            

            $sql1 = "SELECT * FROM posts WHERE posttoken='" . $trendingTokenArray[$x] . "' LIMIT 1";
            $result1 = mysqli_query($conn,$sql1);
            $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
            $postusertoken = $row1['usertoken'];
            $postdate = $row1['postdate'];
            $postcontent = $row1['postcontent'];
            $postlikecount = $postsLikesArray[$x];
            $postMedia = $row1["postmedia"];


            // Checking if this user has liked this post
            $likedPost = false;

            $sql2 = "SELECT * FROM postactions WHERE usertoken='" . $usertoken . "' AND posttoken='" . $row1['posttoken'] . "' AND postaction='like'";
            $result2 = mysqli_query($conn,$sql2);
            if (mysqli_num_rows($result2) > 0) {
                $likedPost = true;
            }
            // Checking if this user has retweeted this post
            $retweetedPost = false;
    
            $sql2 = "SELECT * FROM postactions WHERE usertoken='" . $usertoken . "' AND posttoken='" . $row1['posttoken'] . "' AND postaction='retweet'";
            $result2 = mysqli_query($conn,$sql2);
            if (mysqli_num_rows($result2) > 0) {
                $retweetedPost = true;
            }

            // Checking if this is one of this users posts
            $isPostOfThisUser = false;
            if ($row1['usertoken'] == $_SESSION['usertoken']) {
                $isPostOfThisUser = true;
            }
            

            //Getting Retweet Count
            $sql3 = "SELECT * FROM postactions WHERE postaction='retweet' AND posttoken='" . $row1['posttoken'] . "'";
            $result3 = mysqli_query($conn,$sql3);

            $postretweetcount = mysqli_num_rows($result3);

            //Getting Comment Count

            $sql4 = "SELECT * FROM postactions WHERE postaction='comment' AND posttoken='" . $row1['posttoken'] . "'";
            $result4 = mysqli_query($conn,$sql4);

            $postcommentcount = mysqli_num_rows($result4);

            //Getting username

            $sql10 = "SELECT * FROM users WHERE usertoken='" . $postusertoken . "' LIMIT 1";
            $result10 = mysqli_query($conn,$sql10);
            $row10 = mysqli_fetch_array($result10, MYSQLI_ASSOC);
            $postusername = $row10['username'];

            //Getting user profile image

            $sql20 = "SELECT * FROM userdetails WHERE usertoken='" . $postusertoken . "' AND userdetail='useravatar' LIMIT 1";
            $result20 = mysqli_query($conn,$sql20);
            

            while($row20 = mysqli_fetch_array($result20, MYSQLI_ASSOC)) {
                $postuseravatar = $row20["userdetailcontent"];
            }


            echo "
                    
            <div class='new-tweet-container' data-post-token='" . $trendingTokenArray[$x] . "' id='explore-tweet-container'>
                <div class='new-tweet-img'>
                    <img src='" . $postuseravatar . "' alt='' data-username='" . $postusername ."'>
                </div>
                <div class='new-tweet-body'>
                    <div class='new-tweet-header'>
                        <div class='tweet-header-left'>
                            <span class='new-tweet-name'>" . $postusername . "</span>
                            <span class='new-tweet-username'></span>
                            <span class='new-tweet-date'>" . time_elapsed($postdate) . "</span>
                        </div>";

                        if ($isPostOfThisUser) {
                            echo "
                            <div class='tweet-header-right'>
                                <button class='tweet-delete-btn'>
                                    <svg viewBox='0 0 24 24'><g><path d='M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z'></path><path d='M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z'></path></g></svg>
                                </button>
                            </div>";
                            
                        }
                    
                    echo "

                    </div>

 
                    <div class='new-tweet-text'>
                        <p>" . $postcontent . "</p>  
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
 
?>
