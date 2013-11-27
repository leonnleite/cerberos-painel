;
(function($) {
    $(document).ready(function() {
        $('.linkcontent').click(function() {
            $('#loaging-content-container').show();
            $('.containercontent').load($(this).attr('value'), function() {
                $('#loaging-content-container').fadeOut(500);
            });
        });
    });
}(jQuery));