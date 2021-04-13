<?php
    session_start();
    if (!isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/signin");
    }  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/exploreController.php');
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
    <title>Explore / Twitter</title>

    <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>

    <section class="explore-container">
        <div class="explore-top">
            <div class="explore-top-top">
                <input type="text" placeholder="Search Twitter">
                <button><i class="fas fa-cog"></i></button>
            </div>
            <nav class="explore-top-bottom">
                <a href=""><span>For you</span></a>
                <a href=""><span>Trending</span></a>
                <a href=""><span>News</span></a>
                <a href=""><span>Sports</span></a>
                <a href=""><span>Entertainment</span></a>
                <a href=""><span>COVID-19</span></a>
            </nav>
        </div>

        <div class="trending-append"></div>
    </section>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>

    <script>
        var loadtrending = true;

        $.ajax({

            type: "POST",
            url: "/projects/twitter/controllers/exploreController.php",
            data: {

                loadtrending: loadtrending

            },

            success: function(response) {
                
                $(".trending-append").html(response);
                hoverAfterAjaxPost();

            }

        });
    </script>
    <script src="/projects/twitter/js/tweet.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>
    <script src="/projects/twitter/js/functions.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>


</body>
</html>