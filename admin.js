(function($){

    $('.bern-badge-form').on('change', 'select', function(){
       toggleBernBadges();
    });

    toggleBernBadges();

    $('.bern-badge').click(function(){
        $('#bern_badge').val($(this).data('name'));
        $('.bern-badge-form').submit();
    });

})(jQuery);

function toggleBernBadges(){

    jQuery('.bern-badge').each(function(){

        var color = jQuery('#bern-badge-color').val();
        var position = jQuery('#bern-badge-position').val();
        var language = jQuery('#bern-badge-language').val();

        if (color == jQuery(this).data('color') && position == jQuery(this).data('position') && language == jQuery(this).data('language')) {
            jQuery(this).show();
        } else {
            jQuery(this).hide()
        }
    });
}