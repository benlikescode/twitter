// Hover Animations for tweet icons
/*
function hoverAfterAjaxPost() {
    var isLiked = false;
    var isRetweeted = false;
    var likeButton = $("[data-feed-button='like']");
    var retweetButton = $("[data-feed-button='retweet']");
    var commentButton = $("[data-feed-button='comment']");
    var shareButton = $("[data-feed-button='share']");

    

    

    
    
    retweetButton.mouseover(function() {
        $(this).css("color", "#00bc00");
        $(this).find("button").css("backgroundColor", "#efffef");
        $(this).find("button").css("borderRadius", "50%");
        $(this).find("svg").css("fill", "#00bc00");
    });
    $("[data-feed-button='comment'], [data-feed-button='share']").mouseover(function() {
        $(this).css("color", "#4f4fff");
        $(this).find("button").css("backgroundColor", "#e6e6ff");
        $(this).find("button").css("borderRadius", "50%");
        $(this).find("svg").css("fill", "#4f4fff");
    });
    $("[data-feed-button='comment'], [data-feed-button='share']").mouseleave(function() {
        $(this).css("color", "gray");
        $(this).find("button").css("backgroundColor", "transparent");
        $(this).find("button").css("borderRadius", "none");
        $(this).find("svg").css("fill", "gray");
    });
    
    retweetButton.mouseleave(function() {
        $(this).find("button").css("borderRadius", "none");
        $(this).find("button").css("backgroundColor", "transparent");
        if (isRetweeted == false) {
            $(this).css("color", "gray");
            $(this).find("svg").css("fill", "gray");
        } 
    });
    
}
*/