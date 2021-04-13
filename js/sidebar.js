  // Inserting Recently Searched into DB

  $(".rightsidebar-input-container input").keypress(function(e) {
    if (e.which == 13) {
        var submitquery = true;
        var query = $(this).val();
        if (query.trim() !== "") {
            $.ajax({
                type: "POST",
                url: "/projects/twitter/controllers/searchController.php",
                data: {
                    submitquery: submitquery,
                    query: query
                },

                success: function(response) {
                    $(".rightsidebar-input-container input").css("border", "none");
                    $(".rightsidebar-input-container input").css("background-color", "#E5E7EB");
                    $(".search-bar-icon").css("fill", "#9CA3AF");
                }
            });
        }
    }      
});


 $(".clear-this-recent").click(function() {
     console.log("Me name is Ben.");
 });




// Loading Recently Searched

$(".rightsidebar-input-container input").click(function() {
    
    var searchResultsContainer = $("#searchresults");
    var loadrecents = true;

    $.ajax({
        type: "POST",
        url: "/projects/twitter/controllers/searchController.php",
        data: {
            loadrecents: loadrecents
        },

        success: function(response) {
            searchResultsContainer.html(response);
            // If Clear all button is clicked, send another ajax call to delete all queries from this user
            $("#clear-recent").click(function() {
                var clearrecents = true;
                
                $.ajax({
                    type: "POST",
                    url: "/projects/twitter/controllers/searchController.php",
                    data: {
                        clearrecents: clearrecents
                    },

                    success: function(response) {
                        searchResultsContainer.html(
                            "<span class='no-recents-msg'>Try searching for people, topics, or keywords</span>"
                        )
                    }
                });
                
            });
        }
    });
    
});



// Quering results based on what user has typed at the moment

$(".rightsidebar-input-container input").keyup(function() {
    var query = $(this).val();
    var searchResultsContainer = $("#searchresults");
    var trendingResultsContainer = $("#trendingresults");
    if (query.trim() !== "") {
       
        var loadresults = true;
        

        $.ajax({
            type: "POST",
            url: "/projects/twitter/controllers/searchController.php",
            data: {
                loadresults: loadresults,
                query: query
            },

            success: function(response) {
                searchResultsContainer.html(response);
            }
        });

        var loadtrending = true;
        $.ajax({
            type: "POST",
            url: "/projects/twitter/controllers/searchController.php",
            data: {
                loadtrending: loadtrending,
                query: query
            },

            success: function(response) {
                trendingResultsContainer.html(response);
            }
        });
    }
    else {

        var loadrecents = true;

        $.ajax({
            type: "POST",
            url: "/projects/twitter/controllers/searchController.php",
            data: {
                loadrecents: loadrecents
            },

            success: function(response) {
                searchResultsContainer.html(response);
            }
        });
    }
});

// DELETE MODALS ON DOCUMENT CLICK

$(document).click(function(event) {
    var clickedTarget = $(event["target"]);

    if (clickedTarget.parents('[data-modal]').length == 0 || clickedTarget.attr("[data-modal]").length == 0 || clickedTarget.hasClass("searchBar")) {
        removeModals();
    }
});

function removeModals() {
    $("[data-modal]").remove();
}

$(".rightsidebar-input").click(function() {
    $(".search-bar-icon").css("fill", "rgb(26, 145, 218)");
    $(this).css("border", "1px solid rgb(26, 145, 218)");
    $(this).css("background-color", "white");
 });






/*
 $("body").click(function() {
    $(".search-bar-icon").css("fill", "#9CA3AF");
    $(".rightsidebar-input").css("border", "none");
    $(".rightsidebar-input").css("background-color", "#E5E7EB");
 })
 */