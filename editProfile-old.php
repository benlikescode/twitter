
<?php 
    session_start();  
    $usertoken = $_SESSION["usertoken"];
    if (!isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/signin");
    }
    else {
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/userController.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/authController.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/profileController.php');
    }

    // Getting the users bio

    $sql = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userbio' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userBio = $row['userdetailcontent'];

    // Getting the users location

    $sqlselectlocation = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userlocation' LIMIT 1";
    $resultlocation = mysqli_query($conn,$sqlselectlocation);
    $rowlocation = mysqli_fetch_array($resultlocation, MYSQLI_ASSOC);
    $userLocation = $rowlocation['userdetailcontent'];

    // Getting the users website

    $sqlselectwebsite = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userwebsite' LIMIT 1";
    $resultwebsite = mysqli_query($conn,$sqlselectwebsite);
    $rowwebsite = mysqli_fetch_array($resultwebsite, MYSQLI_ASSOC);
    $userWebsite = $rowwebsite['userdetailcontent'];

    // Getting the users join date

    $sqlselectdate = "SELECT * FROM users WHERE usertoken='$usertoken' LIMIT 1";
    $resultdate = mysqli_query($conn,$sqlselectdate);
    $rowdate = mysqli_fetch_array($resultdate, MYSQLI_ASSOC);
    $userDate = $rowdate['userdate'];

    // Getting the users following count

    $sqlfollowingcount = "SELECT * FROM profileactions WHERE usertoken='$usertoken' AND profileaction='follow'";
    $resultfollowingcount = mysqli_query($conn,$sqlfollowingcount);
    $userfollowingcount = mysqli_num_rows($resultfollowingcount);

    // Getting the users followers count

    $sqlfollowerscount = "SELECT * FROM profileactions WHERE profiletoken='$usertoken' AND profileaction='follow'";
    $resultfollowerscount = mysqli_query($conn,$sqlfollowerscount);
    $userfollowerscount = mysqli_num_rows($resultfollowerscount);

    // Getting the users display name

    $sqlselectdisplay = "SELECT * FROM userdetails WHERE usertoken='$usertoken' AND userdetail='userdisplayname' LIMIT 1";
    $resultdisplay = mysqli_query($conn,$sqlselectdisplay);
    $rowdisplay = mysqli_fetch_array($resultdisplay, MYSQLI_ASSOC);
    $userDisplayName = $rowdisplay['userdetailcontent'];

    // Getting the users number of tweets

    // Checking if user clicks exit edit profile

    if (isset($_POST['exit-edit-profile'])) {
        header("location: /projects/twitter/user/$username");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username ?></title>

    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href="/projects/twitter/css/editProfile.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


</head>
<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>
    <section class="user-profile-container">
        <form action="" method="post" enctype="multipart/form-data">    
        <header>
            <button type="button"><i class="far fa-arrow-left"></i></button>
            <div>
                <h1><?php echo $username ?></h1>
                <h2>24 Tweets</h2>
            </div>
        </header>
        <div class="user-profile-banner">
            <img src="/projects/twitter/theo-twitter.jpg" alt="" role="presentation">
        </div>
        <div class="user-profile-details">
            <div class="user-profile-details-top">
                <div class="user-profile-picture">
                    <img src="<?php echo $useravatar ?>" id="user-profile-img" alt=""> 
                    <input type="file" name="useravatar" accept="image/*">
                </div>
                <?php if($_SESSION["usertoken"] == $usertoken): ?>
                <button name="edit-profile-btn" aria-label="Edit your profile">Edit profile</button>
                <?php endif; ?>
                <?php if($_SESSION["usertoken"] !== $usertoken): ?>
                <button aria-label="Follow User" type="button" data-follow="<?php echo $usertoken ?>">Follow</button>
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
                        <span class="user-profile-snippet-label"><a href="https://<?php echo $userWebsite ?>" aria-label="" target="_blank"><?php echo $userWebsite ?></a></span>
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
            <nav class="user-profile-nav">
                <button class="user-profile-nav-btn active" aria-label="">Tweets</button>
                <button class="user-profile-nav-btn" aria-label="">Tweets & replies</button>
                <button class="user-profile-nav-btn" aria-label="">Media</button>
                <button class="user-profile-nav-btn" aria-label="">Likes</button>
            </nav>
            <div class="user-profile-feed"></div>
        </div>
        <div class="user-profile-feed"></div>

        <!-- New Stuff (Edit Profile Container) -->
        
        <div class="edit-profile-container">
            <div class="edit-profile-top">
                <div>
                    <button name="exit-edit-profile" class="edit-profile-exit-btn"><i class="fas fa-times"></i></button>
                    <p>Edit profile</p>
                </div>
                
                <button name="edit-profile-save"class="edit-profile-save-btn">Save</button>
            </div>

            <div class="edit-profile-body">
                <div class="edit-profile-banner">
                    <input id="edit-profile-banner-input" type="file" name="edit-profile-banner" accept="image/*">
                </div>
                <div class="edit-profile-inputs">
                    <input name="edit-name" placeholder="Name" type="text">
                    <textarea name="edit-bio" id="" cols="30" rows="10" placeholder="Bio"></textarea>
                    <input name="edit-location" placeholder="Location" type="text">
                    <input name="edit-website" placeholder="Website" type="text">
                </div>
               
            </div>
        
        </div>

        <a href="/projects/twitter/?logout=1">Log Out</a>

        <hr>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        

            <div class="text-input-container">
                <input type="text" placeholder="Your website address" name="userwebsite" value="">
            </div>

            <button name="editprofile">Commit Changes</button>
        </form>
    </section>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>



   
</body>
</html>