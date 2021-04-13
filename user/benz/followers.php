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
    <title>People following <?php echo $titleUsername ?></title>

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
                <a href="/projects/twitter/user/<?php echo $currUserName ?>/followers" class="load-followers-btn2"><span>Followers</span></a>
                <a href="/projects/twitter/user/<?php echo $currUserName ?>/following" class="load-following-btn2"><span>Following</span></a>
            </nav>

            <div class="following-body"></div>
        </div>

    </section>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

    <script>
        $(".load-followers-btn2").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $(".load-following-btn2").css("border-bottom", "none");
            $(".load-following-btn2").css("color", "gray");
            
        });
        $(".load-following-btn2").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $(".load-followers-btn2").css("border-bottom", "none");
            $(".load-followers-btn2").css("color", "gray");
            
        });

        //Load Users Followers

        var loaduserfollowers = true;

        $.ajax({

            type: "POST",
            url: "/projects/twitter/controllers/profileController.php",
            data: {

                loaduserfollowers: loaduserfollowers

            },

            success: function(response) {
                
                $(".following-body").html(response);

                /*
                
                 $(".user-following-follow-btn").mouseover(function() {
                    if ($(this).text() === "Following") {
                        $(this).css("background-color", "rgb(202, 32, 85)");
                        $(this).text("Unfollow");
                    }
                    else if ($(this).text() === "Follow") {
                        $(this).css("opacity", "0.8");
                    }
                });
                $(".user-following-follow-btn").mouseleave(function() {
                    if ($(this).text() === "Unfollow") {
                        $(this).css("background-color", "rgb(26, 145, 218)");
                        $(this).text("Following");
                    }
                    else if ($(this).text() === "Follow") {
                        $(this).css("opacity", "1");
                    }
                });

                */

                
               

            }

        });
    </script>
</body>
</html>