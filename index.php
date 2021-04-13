<?php


    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/authController.php');

    if (isset($_SESSION["usertoken"])) {
        header("location: /projects/twitter/home");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter</title>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ben Hoeg"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:title" content="Benny">
        <meta name="description" content="Benny.">
        <meta property="og:type" content="website" />

        <link href="/projects/twitter/css/index.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
    <div class="index-page-container">
        

        <div class="index-page-join-container">
            <div class="index-page-join-main">
                <svg viewBox="0 0 24 24" class=""><g><path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path></g></svg>
                <div dir="auto" class="">
                    <span class="index-happening-now">Happening now</span>
                </div>
                <div dir="auto" class="">
                    <span class="index-join-today">Join Twitter today.</span>
                </div>
                <div class="main-btn-container">
                    <a href="/projects/twitter/signup" role="button" data-focusable="true" class="index-page-main-btns" id="signup-btn">
                        <span class="main-btn-spans">Sign up</span>
                    </a>
                    <a href="/projects/twitter/signin" role="button" data-focusable="true" class="index-page-main-btns" id="login-btn">
                        <span class="main-btn-spans">Log in</span>
                    </a>
                </div>

            </div>

        </div>

        <div class="index-page-img-container">
            <img alt="" draggable="false" src="https://abs.twimg.com/sticky/illustrations/lohp_en_1302x955.png" class="">
            <svg viewBox="0 0 24 24" class="twitter-svg"><g><path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path></g></svg>
        </div>
    </div>
</body>
</html>