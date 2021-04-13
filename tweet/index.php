<?php
    session_start(); 
    $postToken = $_GET['id'];
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/functionController.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/userController.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Benny</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ben Hoeg"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:title" content="Benny">
        <meta name="description" content="Benny.">
        <meta property="og:type" content="website" />

        <link href="/projects/twitter/css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/sidebar.php'); ?>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/skel/tweetSkel.php');  ?>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/preload/rightSideBar.php'); ?>
    </body>
</html>