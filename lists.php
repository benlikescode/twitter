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
    <title>Lists / Twitter</title>

    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>

    <section class="lists-container">
        <div class="lists-top">
            <div class="lists-top-left">
                <span class="bookmarks-span1">Lists</span>
                <span class="bookmarks-span2">@<?php echo $titleUsername  ?></span>
            </div>
            <div class="lists-top-right">
                <button><i class="fas fa-file-alt"></i></button>
                <button><i class="fas fa-ellipsis-h"></i></button>
            </div>
        </div>

        <div class="lists-pinned-container">
            <div class="lists-pinned-top">
                <span class="bookmarks-span1">Pinned</span>
            </div>
            <div class="lists-pinned-body">
                <span>Nothing to see here yet - pin up to five of your favourite Lists to access them quickly.</span>
            </div>
        </div>

        <div class="lists-your-lists-container">
            <div class="lists-your-lists-top">
                <span class="bookmarks-span1">Your Lists</span>
            </div>
            <div class="lists-your-lists-body">
                <span class="bookmarks-span1">You haven't created any Lists yet</span>
                <span class="bookmarks-span2">When you do, it'll show up here.</span>
                <button>Create a List</button>
            </div>
        </div>

        <div class="lists-append"></div>

    </section>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

    <script>
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