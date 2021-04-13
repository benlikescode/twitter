<?php 
    session_start();  
    //include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/controllers/authController.php');
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

        <link href="/projects/twitter/css/signup.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    </head>
    <body>
  
        <form class="sign-up-form-container" action="/projects/twitter/controllers/authController.php" method="post" enctype="multipart/form-data">
            <div class="sign-up-form" id="sign-up-form1">
                <i class="fab fa-twitter" id="twitter-icon"></i>
                <div class="sign-up-next-btn"><span>Next</span></div> 
                <h1>Create your account</h1>
                <div class="form1-grid">
                    <input name="username" placeholder="User Name" type="text">
                    <input name="useremail" placeholder="Email" type="email">
                    <input name="userpassword" placeholder="Password" type="password">
                    <p>By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use. Others will be able to find you by email or phone number when provided · Privacy Options</p>
                </div>
              
            </div>

            <div class="sign-up-form" id="sign-up-form2">
                <div class="sign-up-back-btn" id="sign-up-back-btn1"><i class="fas fa-arrow-left"></i></div>  
                <i class="fab fa-twitter" id="twitter-icon"></i>
                <div class="sign-up-skip-btn">Skip for now</div>
                <h1>Pick a profile picture</h1>
                <p>Have a favorite selfie? Upload it now.</p>
                <div class="user-profile-picture-wrapper">
                    <div class="user-profile-picture">
                        <img src="/projects/twitter/img/default_avatar.png" id="user-profile-img" alt=""> 
                        <input type="file" name="userprofileimg" accept="image/*">
                    </div>
                </div> 
            </div>

            <div class="sign-up-form" id="sign-up-form3">
                <div class="sign-up-back-btn" id="sign-up-back-btn2"><i class="fas fa-arrow-left"></i></div>
                <i class="fab fa-twitter" id="twitter-icon"></i>
                <h1>Describe yourself</h1>
                <p>What makes you special? Don't think too hard, just have fun with it.</p>
                <textarea name="sign-up-bio" id="sign-up-bio" maxlength="160" cols="30" rows="10" placeholder="Your bio"></textarea>
                <button type="submit" name="signup">Sign Up</button>
            </div> 
        </form>
        
    </body>

    <script>
        var nextButton = document.querySelector(".sign-up-next-btn");
        var backButton1 = document.querySelector("#sign-up-back-btn1");
        var backButton2 = document.querySelector("#sign-up-back-btn2");
        var skipButton = document.querySelector(".sign-up-skip-btn");
        var bioTextArea = document.querySelector("#sign-up-bio");
        var Form1 = document.querySelector("#sign-up-form1");
        var Form2 = document.querySelector("#sign-up-form2");
        var Form3 = document.querySelector("#sign-up-form3");

        nextButton.onclick = function() {
            Form2.style.zIndex = "1";
            Form1.style.zIndex = "-1";
        }

        backButton1.onclick = function() {
            Form1.style.zIndex = "1";
            Form2.style.zIndex = "-1";
        }

        backButton2.onclick = function() {
            Form2.style.zIndex = "1";
            Form3.style.zIndex = "-1";
            Form1.style.zIndex = "-1";
        }      

        skipButton.onclick = function() {
            Form3.style.zIndex = "1";
            Form2.style.zIndex = "-1";
        }

        //Checks if we change the profile image

        $(document).ready(function() {
            $("input[name='userprofileimg']").change(function() {
                $("#user-profile-img").attr("src", window.URL.createObjectURL(this.files[0]));
                $(".sign-up-skip-btn").html(`<div class="sign-up-next-btn"><span>Next</span></div>`);
            })
        });


        /*
        bioTextArea.addEventListener("click", function() {
            if (bioTextArea.style.border === "1px solid red") {
                bioTextArea.style.border = "1px solid rgb(26, 145, 218)";
            }
            else {
                bioTextArea.style.border = "1px solid red"
            }
            
        })
        */

        
    </script>
</html>