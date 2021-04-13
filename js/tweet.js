// LIKE BUTTON

$(document).on("click", "[data-feed-button='like']", function() {
    var likepost = true;
    var posttoken = $(this).parent().parent().parent().attr("data-post-token");
    var likebutton = $(this);
    console.log($(this));
    $.ajax({

        type: "POST",
        url: "/projects/twitter/controllers/postController.php",
        data: {
            likepost: likepost,
            posttoken: posttoken
        },

        success: function(response) {
            console.log("like button response:" + response);
            if (response == 1) {
                likebutton.find("span").html(parseInt(likebutton.find("span").html()) + 1);
                likebutton.find("svg").remove();
                likebutton.find("#tweet-icon-div").append("<svg viewBox='0 0 24 24' ><g><path d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z'></path></g></svg>");
                likebutton.find("svg").css("fill", "red");
                likebutton.find("span").css("color", "red");
            }
            else {
                likebutton.find("span").html(parseInt(likebutton.find("span").html()) - 1);
                likebutton.find("svg").remove();
                likebutton.find("#tweet-icon-div").append("<svg viewBox='0 0 24 24'><g><path d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z'></path></g></svg>");
                likebutton.find("span").css("color", "gray");
            }
           
        }

    });
});

// Retweet Button

$(document).on("click", "[data-feed-button='retweet']", function() {
    var retweetpost = true;
    var posttoken = $(this).parent().parent().parent().attr("data-post-token");
    var retweetbutton = $(this);

    $.ajax({

        type: "POST",
        url: "/projects/twitter/controllers/postController.php",
        data: {
            retweetpost: retweetpost,
            posttoken: posttoken
        },

        success: function(response) {
            console.log(response);
            if (response == 1) {
                retweetbutton.find("span").html(parseInt(retweetbutton.find("span").html()) + 1);
                retweetbutton.find("svg").css("fill", "rgb(23, 191, 99)");
                retweetbutton.find("span").css("color", "rgb(23, 191, 99)");
            }
            else {
                retweetbutton.find("span").html(parseInt(retweetbutton.find("span").html()) - 1);
                retweetbutton.find("svg").css("fill", "gray");
                retweetbutton.find("span").css("color", "gray");
            }
        }

    });
});


//Exit Comment Button

$(document).on("click", "#exit-comment-btn", function() {
    $(".modal-container").remove();
    $("body").css("overflow-y", "auto");
});

//Redirects user to profile that they click on

$(document).on("click", "[data-username]", function() {
    
    var gotouserprofile = true;
    var userclickedonname = $(this).attr("data-username");


    $.ajax({

        type: "POST",
        url: "/projects/twitter/controllers/feedController.php",
        data: {
            gotouserprofile: gotouserprofile
        },

        success: function(response) {
            console.log(userclickedonname);
        }

    });
});

// Comment Button

$(document).on("click", "[data-feed-button='comment']", function() {

    var modalType = "comment";
    var postToken = $(this).parent().parent().parent().attr("data-post-token");
    
    $.ajax({
        type: "POST",
        url: "/projects/twitter/controllers/modalController.php",
        data: {
            modalType: modalType,
            postToken: postToken
           
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
        }
    });

});

// This will redirect the user to the tweet index page with a unique url (with postToken)
// The tweet page includes the sidebars as well as the tweetSkel page

$(document).on("click", ".new-tweet-text", function() {

    var loadTweetPage = true;
    var postToken = $(this).parent().parent().attr("data-post-token");
    var posterName = $(".new-tweet-img").children("img").attr("data-username");
    
    window.location = '/projects/twitter/tweet/?id=' + postToken;

});

// Delete Tweet Button

$(document).on("click", ".tweet-delete-btn", function() {

    var deletepost = true;
    var postToken = $(this).parent().parent().parent().parent().attr("data-post-token");
    var tweetContainerID = $(this).parent().parent().parent().parent().attr("id");
    console.log(postToken);
    console.log(tweetContainerID);

    $.ajax({
        type: "POST",
        url: "/projects/twitter/controllers/postController.php",
        data: {
            deletepost: deletepost,
            postToken: postToken
        },
        success: function(response) {
            // after deleting this tweet, we reload the feed
            
            switch (tweetContainerID) {
                case "feed-tweet-container":
                    var loadfeed = true;

                    $.ajax({

                        type: "POST",
                        url: "/projects/twitter/controllers/feedController.php",
                        data: {

                            loadfeed: loadfeed

                        },

                        success: function(response) {

                            $("#feed").html(response);
                            hoverAfterAjaxPost();

                        }

                    });
                case "profile-tweet-container":
                    // LOAD FEED

                    var loadprofiletweets = true;
                    var userToken = $(".user-profile-container").attr("data-username");


                    $.ajax({

                        type: "POST",
                        url: "/projects/twitter/controllers/profileController.php",
                        data: {

                            loadprofiletweets: loadprofiletweets,
                            userToken: userToken

                        },

                        success: function(response) {
                            
                            $(".user-profile-feed").html(response);
                            hoverAfterAjaxPost();

                        }

                    });
                case "explore-tweet-container":
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
            }
            
        }
    });

});

// More info Tweet Button
// Work In Progress
/*

$(document).on("click", ".tweet-delete-btn", function() {

    var modalType = "tweetMore";
    var thisButton = this;
    
    $.ajax({
        type: "POST",
        url: "/projects/twitter/controllers/modalController.php",
        data: {
            modalType: modalType 
        },
        success: function(response) {
            if ($(".tweet-more-container").length == 0) {
                $(thisButton).append(response);
            }
            else {
                $(".tweet-more-container").remove();
                $(".tweet-delete-btn").append(response);
            }
            $(document).on("click", thisButton, function() {
                $(".tweet-more-container").remove();
            });
            
        }
    });

});
*/





