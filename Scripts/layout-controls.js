//This script loads the content into the layout
$(document).ready(function() {
    
    var $placeholderMain = $("#RenderBody");
    var $contentMain = $("main.DynamicLoad:not(#RenderBody)");

    //console.log(placeholderMain);
    //console.log(contentMain);
    if ($placeholderMain.length > 0 && $contentMain.length > 0)
    {
        //Replace the placeholder
        $placeholderMain.replaceWith($contentMain);
        $contentMain.removeClass('DynamicLoad');
        $contentMain.addClass('DynamicLoaded');
    }
    else if ($placeholderMain.length > 0)
    {
        alert("Couldn't find content to put into placeholder");
    }
    else if ($contentMain.length > 0)
    {
        alert("Couldn't find placeholder main - have you added a layout?");
    }
    else 
    {
        alert("You've really fucked up somewhere");
    }
});