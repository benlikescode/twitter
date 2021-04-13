<?php
    session_start();
    if (!isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/signin");
    }  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    $usertoken = $_SESSION['usertoken'];
    $sql1 = "SELECT * FROM users WHERE usertoken='$usertoken' LIMIT 1";
    $result1 = mysqli_query($conn,$sql1);
    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $titleUsername = $row1['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications / Twitter</title>

    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>

    <section class="notif-container">
       <div class="notif-header">
           <div class="notif-header-top">
               <span class="bookmarks-span1">Notifications</span>
               <button><i class="fas fa-cog"></i></button>
           </div>
           <div class="notif-header-bottom">
               <a href="/projects/twitter/notifications" class="notifactions-all-btn"><span>All</span></a>
               <a href="/projecsts/twitter/notifications/mentions" class="notifactions-mentions-btn"><span>Mentions</span></a>
           </div>
       </div>

       <div class="notif-default">
           <span class="bookmarks-span1">Nothing to see here - yet</span>
           <span class="bookmarks-span2">When someone mentions you, you'll find it here.</span>
       </div>

        <div class="notifications-append"></div>

    </section>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

    <script>

        $(".notifactions-all-btn").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $("..notifactions-mentions-btn").css("border-bottom", "none");
            $("..notifactions-mentions-btn").css("color", "gray");
                    
        });
        $(".notifactions-mentions-btn").click(function() {
            $(this).css("color", "rgb(26, 145, 218)");
            $(this).css("border-bottom", "2px solid rgb(26, 145, 218)");
            $(".notifactions-all-btn").css("border-bottom", "none");
            $(".notifactions-all-btn").css("color", "gray");
        });




        /*
        var loadlist = true;

        $.ajax({

            type: "POST",
            url: "",
            data: {

                loadlist: loadlist

            },

            success: function(response) {
                
                $(".lists-append").html(response);
                console.log("List page works!");

            }

        });
        */
    </script>
</body>
</html>