/*
    Library js
    Leonid, (c) 2015
*/

$(document).ready(function() {
    $("li.genre a").bind("click", genreClick);
});

function genreClick(e) {
    e.preventDefault();
    $("li.genre a[class~='selected']").removeClass("selected");
    $(this).addClass("selected");
}


