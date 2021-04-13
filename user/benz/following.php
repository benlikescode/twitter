<?php
 
 session_start();  
 include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/profileController.php');
 $titleToken = $_SESSION['usertoken'];
 $sql1 = "SELECT * FROM users WHERE usertoken='$titleToken' LIMIT 1";
 $result1 = mysqli_query($conn,$sql1);
 $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
 $titleUsername = $row1['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People followed by <?php echo $titleUsername ?></title>

    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>

    <section class="following-container">
        <div class="following-top">
            <div class="following-top-top">
                <p><?php echo $currUserName ?></p>
            </div>
            

            <nav>
                <a href="/projects/twitter/user/<?php echo $currUserName ?>/followers" class="load-followers-btn"> <span>Followers</span></a>
                <a href="/projects/twitter/user/<?php echo $currUserName ?>/following" class="load-following-btn"> <span>Following</span></a>
            </nav>

            <div class="following-body"></div>
        </div>

    </section>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

    <script>
        $(".load-followers-btn").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $(".load-following-btn").css("border-bottom", "none");
            $(".load-following-btn").css("color", "gray");
            
        });
        $(".load-following-btn").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $(".load-followers-btn").css("border-bottom", "none");
            $(".load-followers-btn").css("color", "gray");
            
        });

        //Load Users Following

        var loaduserfollowing = true;

        $.ajax({

            type: "POST",
            url: "/projects/twitter/controllers/profileController.php",
            data: {

                loaduserfollowing: loaduserfollowing

            },

            success: function(response) {
                
                $(".following-body").html(response);

                /*
                $(".user-following-follow-btn").mouseover(function() {
                    $(this).css("background-color", "rgb(202, 32, 85)");
                    $(this).text("Unfollow");
                });
                $(".user-following-follow-btn").mouseleave(function() {
                    $(this).css("background-color", "rgb(26, 145, 218)");
                    $(this).text("Following");
                })
                */
               

            }

        });
    </script>
</body>
</html>