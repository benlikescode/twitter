<?php
    session_start();
    if (!isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/signin");
    }
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/userMessagesController.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <link href="/projects/twitter/css/messages.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>

        
        <section class="all-messages">
            <div class="all-messages-top">
                <p>Messages</p>
                <button type="submit" name="new-msg-btn" class="new-message-btn"><i class="fas fa-plus"></i></button>
            </div>
            <div class="all-messages-search">
                <input type="text" class="message-search" placeholder="Search for people and groups">
            </div>
            <div class="all-messages-body"></div>

            <script>

            var loadmessages = true;

            $("[name='new-msg-btn']").click(function() {
                $.ajax({

                    type: "POST",
                    url: "/projects/twitter/controllers/userMessagesController.php",
                    data: {

                        loadmessages: loadmessages

                    },

                    success: function(response) {
                        
                        $(".followers-append").html(response);

                        $(".followed-user-container").click(function() {
                            if ($(this).css("background-color") != "rgb(26, 145, 218)") {
                                $(this).css("background-color", "rgb(26, 145, 218");
                            }
                            else {
                                $(this).css("background", "transparent");
                            }

                            var userToken = $(this).attr("data-user-token");
                            console.log(userToken);

                           
                            
                            
                        });
                        
                    }

                });     
            });

            
            
            

            </script>

        </section>

        <section class="current-message-container">
            <div class="current-message-top">
                <div class="current-message-img"></div>
                <div class="current-message-username">Ben</div>
                <button class="current-message-info"><i class="fas fa-info-circle"></i></button>
            </div>
            <div class="current-message-user-info"></div>
            <div class="current-message-conversation"></div>
            <div class="current-message-bottom">
                <button class="current-message-file"><i class="fas fa-file-image"></i></button>
                <button class="current-message-gif"><i class="fas fa-photo-video"></i></button>
                <input type="text" class="send-new-msg-input" placeholder="Start a new message">
                <button class="current-message-emoji"><i class="far fa-smile"></i></button>
                <button class="send-new-msg-btn"><i class="fas fa-paper-plane"></i></button>
            </div>
        </section>
    </main>
   

    <div class="new-msg-container">
        <div class="new-msg-top">
            <button class="new-msg-exit-btn"><i class="fas fa-times"></i></button>
            <p>New Message</p>
            <button class="new-msg-next-btn">Next</button>
        </div>
        <div class="new-msg-body">
            <input type="text" placeholder="Search people">
            <div class="followers-append"></div>
        </div>
    </div>

    




   <script>
       $(".new-message-btn").click(function() {
            $(".new-msg-container").css("display", "block");
            //$("body").css("opacity", "0.5");
        });

        $(".new-msg-exit-btn").click(function() {
            $(".new-msg-container").css("display", "none");
            //$("body").css("opacity", "1");
        });

        

    
   </script>

</body>
</html>