<?php 
    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/authController.php');

    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Benny</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ben Hoeg"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:image">
        <meta property="og:title" content="Benny">
        <meta name="description" content="Benny.">
        <meta property="og:type" content="website" />

        <link href="/projects/twitter/css/signin.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    </head>
    <body>
        
        <div class="sign-in-container">
            <span><i class="fab fa-twitter" id="twitter-icon"></i></span>
            <h1 class="log-in-header">Log in to Twitter</h1>
            <form action="" method="post" enctype="multipart/form-data">
               
                <input name="useremail" placeholder="Email" type="email">
                <input name="userpassword" placeholder="Password" type="password" >
                <button type="submit" name="signin">Log In</button>
                <div class="footer-links">
                    <a href="">Forgot password?</a>
                    <a href="https://benhoeg.com/projects/twitter/signup">Sign up for Twitter</a>
                </div>
            
            </form>
        </div>
        
       
        
    </body>
</html>