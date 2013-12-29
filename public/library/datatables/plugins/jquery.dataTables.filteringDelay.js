;
jQuery.fn.dataTableExt.oApi.fnSetFilteringDelay = function(oSettings, iDelay) {
    var _that = this;

    if (iDelay === undefined) {
        iDelay = 250;
    }

    this.each(function(i) {

        $.fn.dataTableExt.iApiIndex = i;

        var
                oTimerId = null,
                sPreviousSearch = null,
                anControl = $('input', _that.fnSettings().aanFeatures.f);

        anControl.unbind('keyup').unbind('keypress').bind('keypress', function(e) {
            if (e.which === 13) {
                if (sPreviousSearch === null || sPreviousSearch !== anControl.val()) {
                    window.clearTimeout(oTimerId);
                    sPreviousSearch = anControl.val();
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter(anControl.val());
                }
            }
        });

        return this;
    });
    return this;
};