<?php 

    session_start();  
   
    
    if (!isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/signin");
    }
    else {
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/userController.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/authController.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/profileController.php');
    }

    

    //Note that $usertoken is defined in each seperate user file and is their unique usertoken

    //Getting the users bio

    $sql = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userbio' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userBio = $row['userdetailcontent'];

    //Getting the users location

    $sqlselectlocation = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userlocation' LIMIT 1";
    $resultlocation = mysqli_query($conn,$sqlselectlocation);
    $rowlocation = mysqli_fetch_array($resultlocation, MYSQLI_ASSOC);
    $userLocation = $rowlocation['userdetailcontent'];

    //Getting the users website

    $sqlselectwebsite = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userwebsite' LIMIT 1";
    $resultwebsite = mysqli_query($conn,$sqlselectwebsite);
    $rowwebsite = mysqli_fetch_array($resultwebsite, MYSQLI_ASSOC);
    $userWebsite = $rowwebsite['userdetailcontent'];

    //Getting the users join date

    $sqlselectdate = "SELECT * FROM users WHERE usertoken='$usertoken' LIMIT 1";
    $resultdate = mysqli_query($conn,$sqlselectdate);
    $rowdate = mysqli_fetch_array($resultdate, MYSQLI_ASSOC);
    $userDate = $rowdate['userdate'];

    //Getting the users following count

    $sqlfollowingcount = "SELECT * FROM profileactions WHERE usertoken='$usertoken' AND profileaction='follow'";
    $resultfollowingcount = mysqli_query($conn,$sqlfollowingcount);
    $userfollowingcount = mysqli_num_rows($resultfollowingcount);

    //Getting the users followers count

    $sqlfollowerscount = "SELECT * FROM profileactions WHERE profiletoken='$usertoken' AND profileaction='follow'";
    $resultfollowerscount = mysqli_query($conn,$sqlfollowerscount);
    $userfollowerscount = mysqli_num_rows($resultfollowerscount);

    //Getting the users display name

    $sqlselectdisplay = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userdisplayname' LIMIT 1";
    $resultdisplay = mysqli_query($conn,$sqlselectdisplay);
    $rowdisplay = mysqli_fetch_array($resultdisplay, MYSQLI_ASSOC);
    $userDisplayName = $rowdisplay['userdetailcontent'];

    //Getting the users number of tweets

    $sqltweetcount = "SELECT * FROM posts WHERE usertoken='$usertoken'";
    $resulttweetcount = mysqli_query($conn,$sqltweetcount);
    $usertweetcount = mysqli_num_rows($resulttweetcount);

    //Getting the users banner picture
    
    $sqlbanner = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userbanner' LIMIT 1";
    $resultbanner = mysqli_query($conn,$sqlbanner);
    $rowbanner = mysqli_fetch_array($resultbanner, MYSQLI_ASSOC);
    $userBanner = $rowbanner['userdetailcontent'];


    //Checking if the Session User follows the current user of the profile they are on

    $doesFollow = false;
    $sqlfollowers = "SELECT * FROM profileactions WHERE profiletoken='$usertoken' AND profileaction='follow'";
    $resultfollowerscount = mysqli_query($conn,$sqlfollowers);
    while($row = mysqli_fetch_array($resultfollowerscount, MYSQLI_ASSOC)) {
        if ($_SESSION["usertoken"] == $row['usertoken']) {
            $doesFollow = true;
        }
    }
    

    //Checking if user clicks edit profile

    if (isset($_POST['edit-profile-btn'])) {
        header("location: /projects/twitter/editProfile");
    }

    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $username ?> / Twitter</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ben Hoeg"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:title" content="Benny">
        <meta name="description" content="Benny.">
        <meta property="og:type" content="website" />

        <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href="/projects/twitter/css/editProfile.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>
        <section class="user-profile-container" data-username= <?php echo $usertoken ?>>
            <header>
                <button type="button" id='twitter-back-btn'><i class="far fa-arrow-left"></i></button>
                <div>
                    <h1><?php echo $username ?></h1>
                    <h2><?php echo $usertweetcount ?> Tweets</h2>
                </div>
            </header>
            <div class="user-profile-banner">
                <?php if($userBanner == ""): ?>
                    <div class="set-banner-default"></div>
                <?php endif; ?>
                <?php if($userBanner != ""): ?>
                    <img src="<?php echo $userBanner ?>" alt="" role="presentation">
                <?php endif; ?>
            </div>
            <div class="user-profile-details">
                <div class="user-profile-details-top">
                    <div class="user-profile-picture">
                        <img src="<?php echo $useravatar ?>" id="user-profile-img" alt=""> 
                        
                    </div>
                    <?php if($_SESSION["usertoken"] == $usertoken): ?>
                    <button name="edit-profile-btn" aria-label="Edit your profile">Edit profile</button>
                    <?php endif; ?>
                    <?php if($_SESSION["usertoken"] !== $usertoken && $doesFollow == false): ?>
                    <button aria-label="Follow User" type="button" data-follow="<?php echo $usertoken ?>">Follow</button>
                    <?php endif; ?>
                    <?php if($_SESSION["usertoken"] !== $usertoken && $doesFollow == true): ?>
                    <button aria-label="Following" type="button" data-follow="<?php echo $usertoken ?>">Following</button>
                    <?php endif; ?>
                </div>
                <div class="user-profile-details-content">
                    <span class="user-profile-name"><?php echo $username ?></span>
                    <span class="user-profile-display-name"><?php echo $userDisplayName ?></span>
                    <span class="user-profile-bio"><?php echo $userBio ?></span>
                    <ul class="user-profile-snippets">
                        <li>
                            <i class="far fa-map-marker-alt"></i>
                            <span class="user-profile-snippet-label"><?php echo $userLocation ?></span>
                        </li>
                        <li>
                            <i class="far fa-link"></i>
                            <span class="user-profile-snippet-label"><a href="<?php echo $userWebsite ?>" aria-label="" target="_blank"><?php echo parse_url($userWebsite)["host"] ?></a></span>
                        </li>
                        <li>
                            <i class="far fa-calendar-alt"></i>
                            <span class="user-profile-snippet-label">Joined <?php echo $userDate ?></span>
                        </li>
                    </ul>
                    <div class="user-profile-following-container">
                        <a href="/projects/twitter/user/<?php echo $username ?>/following" aria-label=""><strong><?php echo $userfollowingcount ?></strong> Following</a>
                        <a href="/projects/twitter/user/<?php echo $username ?>/followers" aria-label=""><strong><?php echo $userfollowerscount ?></strong> Followers</a>
                        
                    </div>
                </div>
                
               
            </div>
            <nav class="user-profile-nav">
                    <button class="user-profile-nav-btn active" aria-label="">Tweets</button>
                    <button class="user-profile-nav-btn" aria-label="">Tweets & replies</button>
                    <button class="user-profile-nav-btn" aria-label="">Media</button>
                    <button class="user-profile-nav-btn" aria-label="">Likes</button>
                </nav>
            <div class="user-profile-feed"></div>


            <script>
               
                // LOAD FEED

                var loadprofiletweets = true;
                var userToken = $(".user-profile-container").attr("data-username");


                $.ajax({

                    type: "POST",
                    url: "/projects/twitter/controllers/profileController.php",
                    data: {

                        loadprofiletweets: loadprofiletweets,
                        userToken: userToken

                    },

                    success: function(response) {
                        
                        $(".user-profile-feed").html(response);

                    }

                });

                // Load Edit Profile Modal

                $(document).on("click", "[name='edit-profile-btn']", function() {

                    var modalType = "editProfile";
                    

                    $.ajax({
                        type: "POST",
                        url: "/projects/twitter/controllers/modalController.php",
                        data: {
                            modalType: modalType
                        },
                        success: function(response) {
                            if ($(".modal-container").length == 0) {
                                $("body").append(response);
                            }
                            else {
                                $(".modal-container").remove();
                                $("body").append(response);
                            }
                            $("body").css("overflow-y", "hidden");
                            window.history.pushState('editProfile', 'Edit Your Profile', '/projects/twitter/editProfile');
                        }
                    });

                });

                $("#twitter-back-btn").click(function() {
                    console.log("fired");
                    window.history.back();
                });

                

        
            </script>
            
        </section>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

        <script src="/projects/twitter/js/tweet.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>

    </body>

</html>