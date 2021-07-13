function get_cookie(name) {
    return (document.cookie.match('(^|; )' + name + '=([^;]*)') || 0)[0]
}

function checkDatabase() {
    if (get_cookie('DataChanged') == "Y") {
        location.href = '<?php echo $linkNavigate?>.php';
    }
}
alert(get_cookie('DataChanged'));
setInterval(function() {
    checkDatabase();
    alert(get_cookie('DataChanged'));


}, 5000);

function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}