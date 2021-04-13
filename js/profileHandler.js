$(document).ready(function() {

    $(document).on("click", "button[data-follow]", function() {

        console.log("made it here");

        var actionbutton = $(this);
        var profiletoken = $(this).attr("data-follow");
        var followprofile = true;
        console.log(profiletoken);

        $.ajax({

            type: "POST",
            url: "/projects/twitter/handlers/profileHandler.php",
            data: {

                followprofile: followprofile,
                profiletoken: profiletoken

            },

            success: function(response) {
                console.log(response);
                
                if (response["result"] == "follow") {
                    actionbutton.html("Following");
                }
                else if (response["result"] == "unfollow") {
                    actionbutton.html("Follow");
                }

            }

        });

    });

});
