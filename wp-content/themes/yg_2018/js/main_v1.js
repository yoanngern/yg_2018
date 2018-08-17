// @codekit-prepend "vendor/jquery-2.2.2.js"
// @codekit-append "vendor/jquery.slides.js"


$(document).ready(function () {

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

        $('body').addClass("mobile");

    }


    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();

        var target = this.hash;
        target = target.replace('#', '');

        $("#services article.service").removeClass('current');
        $("#services article.service#" + target).addClass('current');

        scrollToAnchor(target);

    });


    $('#burger').click(function () {

        $('body').toggleClass('open_nav');
    });

    $('#open_lang').click(function (e) {
        e.preventDefault();

        $('body > header > .local #language').toggleClass('open');
    });




    $(document).on('scroll', function () {
        scrollEvent();
    });

});

function scrollToAnchor(aid) {


    var aTag = $('#' + aid);

    $('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
}


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


function scrollEvent() {


    var scrollPos = $(document).scrollTop();

}


var updateQueryStringParam = function (key, value) {
    var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
        urlQueryString = document.location.search,
        newParam = key + '=' + value,
        params = '?' + newParam;

    // If the "search" string exists, then build params from it
    if (urlQueryString) {
        keyRegex = new RegExp('([\?&])' + key + '[^&]*');

        // If param exists already, update it
        if (urlQueryString.match(keyRegex) !== null) {
            params = urlQueryString.replace(keyRegex, "$1" + newParam);
        } else { // Otherwise, add it to end of query string
            params = urlQueryString + '&' + newParam;
        }
    }
    window.history.replaceState({}, "", baseUrl + params);
};