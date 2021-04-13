<?php
    
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');

    if (isset($_POST["signup"])) {
        
        $username = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', preg_replace('/\s+/', '', strip_tags($_POST["username"]))));
        $useremail = strip_tags($_POST["useremail"]);
        $userpassword = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);
        $userdate = date('F Y');
        $usertoken = bin2hex(random_bytes(6));
        $userbio = strip_tags($_POST["sign-up-bio"]);
    
        $sql = "SELECT * FROM users WHERE useremail='$useremail' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        $sql1 = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $result1 = mysqli_query($conn, $sql1);
        
        if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result1) == 0) {
            
            $sql = "INSERT INTO users (username, useremail, userpassword, userdate, usertoken) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $username, $useremail, $userpassword, $userdate, $usertoken);
            $_SESSION['usertoken'] = $usertoken;
            if ($userbio != "") {

                $userdetail = "userbio";

                $sql1 = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param('sss', $userdetail, $userbio, $usertoken);
            }

                $avatarToken = bin2hex(random_bytes(6));
    
                $allowedExts = array("png", "jpeg", "jpg", "gif");
                $fileext = pathinfo($_FILES['userprofileimg']['name'], PATHINFO_EXTENSION);
    
                if (($_FILES["userprofileimg"]["size"] < 200000000)
                && in_array($fileext, $allowedExts)) {
            
                    if ($_FILES["userprofileimg"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["userprofileimg"]["error"] . "<br />";
                    } 
                    else {
                        
                        move_uploaded_file($_FILES['userprofileimg']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/content/user/profile_images/' . $avatarToken . "." . $fileext);
        
                        $save = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_images/" . $avatarToken . ".png";
                        $file = $_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/content/user/profile_images/" . $avatarToken . "." . $fileext; 
    
                        list($widthold, $heightold) = getimagesize($file) ; 
    
                        $info = getimagesize($file);
    
                        if ($info['mime'] == 'image/jpeg') {
                            $image = imagecreatefromjpeg($file);
                        }
    
                        elseif ($info['mime'] == 'image/gif')  {
                            $image = imagecreatefromgif($file);
                        }
    
                        elseif ($info['mime'] == 'image/png') {
                            $image = imagecreatefrompng($file);
                        }
    
                        $width = 150;
                        $height = 150;
    
                        $tn = imagecreatetruecolor($width, $height) ; 
    
                        if(($widthold/$width) > ($heightold / $height)) {
                            $y = 0;
                            $x = $widthold - (($heightold * $width) / $height);
                        } else {
                            $x = 0;
                            $y = $heightold - (($widthold * $height) / $width);
                        }
    
                        $tn = imagecreatetruecolor($width, $height);
                        imagecopyresized($tn, $image, 0, 0, $x/2, $y/2, $width, $height, $widthold - $x, $heightold - $y);
    
                        imagejpeg($tn, $save, 70); 
    
                        $userAvatar = "/projects/twitter/content/user/profile_images/" . $avatarToken . ".png";
                        unlink($file);
    
                    }
                }
                   

                $userdetail2 = "useravatar";

                $sql2 = "INSERT INTO userdetails (userdetail, userdetailcontent, usertoken) VALUES (?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param('sss', $userdetail2, $userAvatar, $usertoken);
            
                $stmt->execute();
                $stmt1->execute();
                $stmt2->execute();


            if (true) {

                // CREATE PROFILE PAGE

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/user/' . $username)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/user/' . $username, 0777, true);
                }
        
                $x = "'";
        
                $p='
                    <?php 
        
                        $usertoken = "' . $usertoken . '";
                        include($_SERVER[' . $x . 'DOCUMENT_ROOT' . $x . '] . ' . $x . '/projects/twitter/skel/profileSkel.php' . $x . '); 
        
                    ?>
                ';
        
                $a = fopen($_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/user/" . $username . "/index.php", 'w');
                fwrite($a, $p);
                fclose($a);
                chmod($_SERVER['DOCUMENT_ROOT'] . "/projects/twitter/user/" . $username . "/index.php", 0644);

                ///

                header('location: /projects/twitter/home');
            } else {
                header('location: /projects/twitter/signup');
            }
        } else {
            header('location: /projects/twitter/signup');
        }
    }

    if (isset($_POST["signin"])) {
        $useremail = strip_tags($_POST["useremail"]);
        $userpassword = strip_tags($_POST['userpassword']);
    
        $sql = "SELECT * FROM users WHERE useremail=? OR userpassword=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $useremail, $userpassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($userpassword, $user['userpassword'])) {

            $sql="SELECT * FROM users WHERE useremail='$useremail' LIMIT 1";
            $result=mysqli_query($conn,$sql);

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $_SESSION['usertoken'] = $row['usertoken'];
            }

            header('location: /projects/twitter/home');
            exit();

        }
    }
    
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['usertoken']);
        
        header('location: /projects/twitter/signin');
        exit();
    }
    

?>