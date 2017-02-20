/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


  function addFav() {
//    $("a.fav").click(function () {
    var this$ = $(this);
    var objpar = this$.parent("td");
    var objhtml = objpar.parent("tr").find("td").eq(1).html();
    var ideq = this$.attr("ideq");
    $.ajax({
        url: "http://localhost/footstat/web/app_dev.php/addequipe/" + ideq, type: 'get',
        beforeSend: function () {
//            this$.html('<div class="loading"></div>')
            $("#Mesequipes").append('<li style="padding: 5px;height: 30px;">'+objhtml+'</li>')
            this$.html('<span class="glyphicon glyphicon-star"></span>')
            this$.unbind('click');
        },
        success: function () {
            this$.attr('title', '[-] Remove from favorites')
            this$.unbind('click')
            this$.bind('click', removeFav);
        }
    });
}

function removeFav() {
    var this$ = $(this);
    var ideq = this$.attr("ideq");
    $.ajax({
        url: "http://localhost/footstat/web/app_dev.php/removeequipe/" + ideq, type: 'get',
        beforeSend: function () {
            this$.html('<span class="glyphicon glyphicon-star-empty"></span>')
            this$.unbind('click');
        },
        success: function () {
            this$.html('<span class="glyphicon glyphicon-star-empty"></span>')
            this$.attr('title', '[+] Add as favorite')
            this$.unbind('click')
            this$.bind('click', addFav);
        }
    });
}
//this will make the link listen to function addFav (you might know this already)
$('a.fav').bind('click', addFav);
$('a.nonfav').bind('click', removeFav);
$('a.supprfav').bind('click', supprfav);


function supprfav() {
    var this$ = $(this);
    var ideq = this$.attr("ideq");
    $.ajax({
        url: "http://localhost/footstat/web/app_dev.php/removeequipe/" + ideq, type: 'get',
        beforeSend: function () {
            this$.html('<div class="loading"></div>')
            this$.closest("li").remove();
        },
        success: function () { }});
}

$(".match-row").click(function() {
        window.document.location = $(this).data("href");
    });