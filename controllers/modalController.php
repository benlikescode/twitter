<?php 

    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/functionController.php');

    /*This Controller returns the requested Modal*/
    

    $usertoken = $_SESSION["usertoken"];
    
    $modalType = $_POST["modalType"];

?>

<?php if ($modalType == "tweetMore"): ?>
    
    <div class="tweet-more-container">
        <div class="tweet-more-section">
            <svg viewBox="0 0 24 24" class="r-daml9f r-4qtqp9 r-yyyyoo r-1q142lx r-1xvli5t r-1b7u577 r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></g></svg>
            <span>Delete</span>
        </div>

        <div class="tweet-more-section">
            <svg viewBox="0 0 24 24" class="r-m0bqgq r-4qtqp9 r-yyyyoo r-1q142lx r-1xvli5t r-1b7u577 r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M20.472 14.738c-.388-1.808-2.24-3.517-3.908-4.246l-.474-4.307 1.344-2.016c.258-.387.28-.88.062-1.286-.218-.406-.64-.66-1.102-.66H7.54c-.46 0-.884.254-1.1.66-.22.407-.197.9.06 1.284l1.35 2.025-.42 4.3c-1.667.732-3.515 2.44-3.896 4.222-.066.267-.043.672.222 1.01.14.178.46.474 1.06.474h3.858l2.638 6.1c.12.273.39.45.688.45s.57-.177.688-.45l2.638-6.1h3.86c.6 0 .92-.297 1.058-.474.265-.34.288-.745.228-.988zM12 20.11l-1.692-3.912h3.384L12 20.11zm-6.896-5.413c.456-1.166 1.904-2.506 3.265-2.96l.46-.153.566-5.777-1.39-2.082h7.922l-1.39 2.08.637 5.78.456.153c1.355.45 2.796 1.78 3.264 2.96H5.104z"></path></g></svg>
            <span>Pin to your profile</span>
        </div>
    </div>



<?php endif; ?>

<div class="modal-container">
    <div class="modal-click-catcher" role="button"></div>




    

<?php if ($modalType == "comment"): ?>

<?php

    $postToken = $_POST['postToken'];

    $sql = "SELECT * FROM posts WHERE posttoken='$postToken' LIMIT 1";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $postUserToken = $row['usertoken'];
        $postContent = $row['postcontent'];
        $postDate = $row['postdate'];
    }

    $sql = "SELECT * FROM users WHERE usertoken='$postUserToken' LIMIT 1";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $postUserName = $row['username'];
    }

    // Getting The Posters User Avatar
    $sql2 = "SELECT * FROM userdetails WHERE usertoken='$postUserToken' AND userdetail='useravatar' LIMIT 1";
    $result2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
    $postProfilePic = $row2['userdetailcontent'];

    // Getting the Commenters User Avatar
    $sql5 = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='useravatar' LIMIT 1";
    $result5 = mysqli_query($conn,$sql5);
    $row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC);
    $userProfilePic = $row5['userdetailcontent'];

    

?>

    <div class="modal">

        <div class="comment-div-top">
            <button id="exit-comment-btn">
                <svg viewBox="0 0 24 24"><g><path d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z"></path></g></svg>
            </button>
        </div>

        <div class='new-tweet-container' id='comment-tweet-container' data-post-token=''>

            <div class="new-tweet-img">
                <img src="<?php echo $postProfilePic ?>" alt=''>
            </div>

            <div class="new-tweet-body">
                <div class="new-tweet-header">
                    <span class='new-tweet-name'><?php echo $postUserName ?></span>
                    <span><?php echo time_elapsed($postDate) ?></span>
                </div>

                <span><?php echo $postContent ?></span>

                <div class="replying-to-div">
                    <span class="replying-to-span1">Replying to</span>
                    <span class="replying-to-span2">@<?php echo $postUserName ?></span>
                </div>
                
            </div>
        </div>

        <div class="feed-tweet" id="comment-reply-container">
            <div class="feed-tweet-top">
                <div class="feed-tweet-profile-pic">
                    <img src="<?php echo $userProfilePic ?>" alt=''>
                </div>
                <textarea name="comment-content" class="feed-tweet-text" maxlength="190" placeholder="Tweet your reply" id="reply-textarea"></textarea>
            </div>

            <div class="feed-tweet-media-append">
                <img id="display-user-media" src="" alt="">
            </div>

            <div class="feed-tweet-bottom">
                <div class="feed-tweet-icons">
                    <input type="file" id="feed-tweet-file-btn" name="tweetmedia"  onchange="loadFile(event)">
                    <label for="feed-tweet-file-btn">
                        <svg viewBox="0 0 24 24" class="new-tweet-icon-svg"><g><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"></path><circle cx="8.868" cy="8.309" r="1.542"></circle></g></svg>
                    </label>
                    <input type="file" id="feed-tweet-gif-btn"   onchange="loadFile(event)">
                    <label for="feed-tweet-file-btn">
                        <svg viewBox="0 0 24 24" class="new-tweet-icon-svg"><g><path d="M19 10.5V8.8h-4.4v6.4h1.7v-2h2v-1.7h-2v-1H19zm-7.3-1.7h1.7v6.4h-1.7V8.8zm-3.6 1.6c.4 0 .9.2 1.2.5l1.2-1C9.9 9.2 9 8.8 8.1 8.8c-1.8 0-3.2 1.4-3.2 3.2s1.4 3.2 3.2 3.2c1 0 1.8-.4 2.4-1.1v-2.5H7.7v1.2h1.2v.6c-.2.1-.5.2-.8.2-.9 0-1.6-.7-1.6-1.6 0-.8.7-1.6 1.6-1.6z"></path><path d="M20.5 2.02h-17c-1.24 0-2.25 1.007-2.25 2.247v15.507c0 1.238 1.01 2.246 2.25 2.246h17c1.24 0 2.25-1.008 2.25-2.246V4.267c0-1.24-1.01-2.247-2.25-2.247zm.75 17.754c0 .41-.336.746-.75.746h-17c-.414 0-.75-.336-.75-.746V4.267c0-.412.336-.747.75-.747h17c.414 0 .75.335.75.747v15.507z"></path></g></svg>
                    </label>
                    <input type="file" id="feed-tweet-poll-btn"   onchange="loadFile(event)">
                    <label for="feed-tweet-file-btn">
                        <svg viewBox="0 0 24 24" class="new-tweet-icon-svg"><g><path d="M20.222 9.16h-1.334c.015-.09.028-.182.028-.277V6.57c0-.98-.797-1.777-1.778-1.777H3.5V3.358c0-.414-.336-.75-.75-.75s-.75.336-.75.75V20.83c0 .415.336.75.75.75s.75-.335.75-.75v-1.434h10.556c.98 0 1.778-.797 1.778-1.777v-2.313c0-.095-.014-.187-.028-.278h4.417c.98 0 1.778-.798 1.778-1.778v-2.31c0-.983-.797-1.78-1.778-1.78zM17.14 6.293c.152 0 .277.124.277.277v2.31c0 .154-.125.28-.278.28H3.5V6.29h13.64zm-2.807 9.014v2.312c0 .153-.125.277-.278.277H3.5v-2.868h10.556c.153 0 .277.126.277.28zM20.5 13.25c0 .153-.125.277-.278.277H3.5V10.66h16.722c.153 0 .278.124.278.277v2.313z"></path></g></svg>
                    </label>
                    <input type="file" id="feed-tweet-emoji-btn"   onchange="loadFile(event)">
                    <label for="feed-tweet-file-btn">
                        <svg viewBox="0 0 24 24" class="new-tweet-icon-svg"><g><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path><path d="M12 17.115c-1.892 0-3.633-.95-4.656-2.544-.224-.348-.123-.81.226-1.035.348-.226.812-.124 1.036.226.747 1.162 2.016 1.855 3.395 1.855s2.648-.693 3.396-1.854c.224-.35.688-.45 1.036-.225.35.224.45.688.226 1.036-1.025 1.594-2.766 2.545-4.658 2.545z"></path><circle cx="14.738" cy="9.458" r="1.478"></circle><circle cx="9.262" cy="9.458" r="1.478"></circle></g></svg>
                    </label>
                    <input type="file" id="feed-tweet-schedule-btn"   onchange="loadFile(event)">
                    <label for="feed-tweet-file-btn">
                        <svg viewBox="0 0 24 24" class="new-tweet-icon-svg"><g><path d="M-37.9 18c-.1-.1-.1-.1-.1-.2.1 0 .1.1.1.2z"></path><path d="M-37.9 18c-.1-.1-.1-.1-.1-.2.1 0 .1.1.1.2zM18 2.2h-1.3v-.3c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v.3H7.7v-.3c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v.3H4.8c-1.4 0-2.5 1.1-2.5 2.5v13.1c0 1.4 1.1 2.5 2.5 2.5h2.9c.4 0 .8-.3.8-.8 0-.4-.3-.8-.8-.8H4.8c-.6 0-1-.5-1-1V7.9c0-.3.4-.7 1-.7H18c.6 0 1 .4 1 .7v1.8c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-5c-.1-1.4-1.2-2.5-2.6-2.5zm1 3.7c-.3-.1-.7-.2-1-.2H4.8c-.4 0-.7.1-1 .2V4.7c0-.6.5-1 1-1h1.3v.5c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-.5h7.5v.5c0 .4.3.8.8.8.4 0 .8-.3.8-.8v-.5H18c.6 0 1 .5 1 1v1.2z"></path><path d="M15.5 10.4c-3.4 0-6.2 2.8-6.2 6.2 0 3.4 2.8 6.2 6.2 6.2 3.4 0 6.2-2.8 6.2-6.2 0-3.4-2.8-6.2-6.2-6.2zm0 11c-2.6 0-4.7-2.1-4.7-4.7s2.1-4.7 4.7-4.7 4.7 2.1 4.7 4.7c0 2.5-2.1 4.7-4.7 4.7z"></path><path d="M18.9 18.7c-.1.2-.4.4-.6.4-.1 0-.3 0-.4-.1l-3.1-2v-3c0-.4.3-.8.8-.8.4 0 .8.3.8.8v2.2l2.4 1.5c.2.2.3.6.1 1z"></path></g></svg>
                    </label>
                </div>
                <button class="feed-tweet-btn" type="submit" name="reply-btn">Reply</button> 
            </div>
        </div>
    </div>

    <script>
        $("[name='reply-btn']").click(function() {
            var reply = true;
            var posttoken = "<?php echo $postToken ?>";
            var commentcontent = $("[name='comment-content']").val();
            $.ajax({

                type: "POST",
                url: "/projects/twitter/controllers/feedController.php",
                data: {

                   reply: reply,
                   posttoken: posttoken,
                   commentcontent: commentcontent

                },

                success: function(response) {
                    closeModal();
                    //$("[data-feed-button='comment']").find("span").html(parseInt($("[data-feed-button='comment']").find("span").html()) + 1);
                }

            });
        });
        $(".feed-tweet-text").focus();
    </script>

<?php endif; ?>

<?php if ($modalType == "editProfile"): ?>

<?php
    // Getting the Profile Pic for the Session User to display on the edit profile modal page
    $sql = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='useravatar' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userAvatar = $row['userdetailcontent'];

    // Getting the Profile Banner for the Session User to display on the edit profile modal page
    $sql = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userbanner' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userBanner = $row['userdetailcontent'];
?>


    <form action="" method="post" style="display: contents" enctype="multipart/form-data">    
    <div class="edit-profile-container">
        <div class="edit-profile-top">
            <div>
                <div name="exit-edit-profile" class="edit-profile-exit-btn"><i class="fas fa-times"></i></div>
                <p>Edit profile</p>
            </div>
            
            <button name="edit-profile-save" class="edit-profile-save-btn">Save</button>
        </div>

        <div class="edit-profile-body">
            <div class="edit-profile-banner">
                <img src="<?php echo $userBanner ?>" alt="" id="user-profile-banner">
                <input id="edit-profile-banner-input" type="file" name="edit-profile-banner" accept="image/*">
            </div>

            <div class="user-profile-picture" id="edit-profile-picture">
                <img src="<?php echo $userAvatar ?>" id="user-edit-profile-img" alt=""> 
                <input type="file" name="useravatar" accept="image/*">
            </div>

            
            <div class="edit-profile-inputs">
                <input name="edit-name" placeholder="Name" type="text">
                <textarea name="edit-bio" id="" cols="30" rows="10" placeholder="Bio"></textarea>
                <input name="edit-location" placeholder="Location" type="text">
                <input name="edit-website" placeholder="Website" type="text">
            </div>
            
        </div>
    
    </div>
</form>
    
<?php endif; ?>


    
    <script>
        //Checks if we change the profile image

        $(document).ready(function() {
            $("input[name='useravatar']").change(function() {
                $("#user-edit-profile-img").attr("src", window.URL.createObjectURL(this.files[0]));
            })
        });

        //Checks if we change the profile banner

        $(document).ready(function() {
            $("input[name='edit-profile-banner']").change(function() {
                $("#user-profile-banner").attr("src", window.URL.createObjectURL(this.files[0]));
            })
        });


        $(document).on("click", ".modal-click-catcher", function() {
            closeModal();
        });

        $(document).on("click", ".edit-profile-exit-btn", function() {
            closeModal();
        });

        function closeModal() {
            $(".modal-container").remove();
            $("body").css("overflow-y", "auto");
        }
    </script>
</div>

