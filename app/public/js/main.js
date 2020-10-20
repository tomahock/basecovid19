$(function () {
    if (!RegExp.escape) {
        RegExp.escape = function (value) {
            return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
        };
    }

    var regex = new RegExp('covid|corona|SARS-COV-2|nCoV-2019|SARS|epidemia|pandemia|COV2', 'ig');

    $('.findr ').each(function () {
        var text = $(this).text();
        $(this).html(text.replace(regex, function (part) {
            return '<span class="highlight">' + part + '</span>'
        }))
    })
});
