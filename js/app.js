// Taking the File that the user uploads and displaying it inside the tweet container

var hasImage = false;

var loadFile = function(event) {
    var output = document.getElementById('display-user-media');
    $(".feed-tweet-media-append").find("img").css("width", "500px");
    $(".feed-tweet-media-append").find("img").css("height", "280px");
    $(".feed-tweet-text").css("border-bottom", "none");
    hasImage = true;

    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
    URL.revokeObjectURL(output.src) // free memory
    }
};

// Changing the sizing of the tweet container after a certain amount of characters in the text box

/*$(".feed-tweet-text").on('keydown', function() {
    var tweetCharCount = $(".feed-tweet-text").val().length;
    if (tweetCharCount == 73 || tweetCharCount == 146 || tweetCharCount == 219) {
        $(".feed-tweet").css("height", "+=20px");
        $(".feed-tweet-top").css("height", "+=20px");
        $(".feed-tweet-text").css("height", "+=20px");
    }

});*/







// LOAD FEED

var loadfeed = true;

$.ajax({

    type: "POST",
    url: "/projects/twitter/controllers/feedController.php",
    data: {

        loadfeed: loadfeed

    },

    success: function(response) {

        $("#feed").html(response);

    }

});


 // Comment Button - Replaced Code

                /*

                $(document).on("click", "[data-feed-button='comment']", function() {
                    $(".comment-append").css("display", "block");
                    var commentpost = true;
                    var posttoken = $(this).parent().parent().parent().attr("data-post-token");
                    var commentbutton = $(this);

                    $.ajax({

                        type: "POST",
                        url: "/projects/twitter/controllers/postController.php",
                        data: {
                            commentpost: commentpost,
                            posttoken: posttoken
                        },

                        success: function(response) {
                            commentbutton.find("span").html(parseInt(commentbutton.find("span").html()) + 1);
                        }

                    });
                });

                */


                               //Loading the users media onto the tweet div
/*
                $(document).ready(function(){
                    $('input[type="file"]').change(function(e){
                        var fileName = e.target.files[0].name;
                        alert(fileName);
                        $(".feed-tweet-media-append").find("img").attr("src", fileName);
                    });
                });
                */