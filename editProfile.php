<?php 
    session_start();
    $usertoken = $_SESSION['usertoken'];
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/skel/profileSkel.php'); 
?>

<script>
    var modalType = "editProfile";
    $.ajax({
        type: "POST",
        url: "/projects/twitter/controllers/modalController.php",
        data: {
            modalType: modalType
        },
        success: function(response) {
            if ($(".modal-container").length == 0) {
                $("body").append(response);
            }
            else {
                $(".modal-container").remove();
                $("body").append(response);
            }
            $("body").css("overflow-y", "hidden");
            window.history.pushState('editProfile', 'Edit Your Profile', '/projects/twitter/editProfile');
        }
    });

    $(document).on("click", ".edit-profile-exit-btn", function() {
        $(".modal-container").remove();
        $("body").css("overflow-y", "auto");
        

    });
</script>