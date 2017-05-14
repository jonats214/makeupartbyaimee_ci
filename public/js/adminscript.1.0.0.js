/**
 * Created by Jonats on 10/08/2016.
 */
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});



function setPageTitle(title){
    $(document).prop('title', title);
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function htmlEncode(value){
    if (value) {
        return jQuery('<div/>').text(value).html();
    } else {
        return '';
    }
}

function htmlDecode(value){
    if (value) {
        return jQuery('<div/>').html(value).text();
    } else {
        return '';
    }
}