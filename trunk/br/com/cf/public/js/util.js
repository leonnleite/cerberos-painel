;
{
    var Util = {};

    /**
     * Caixa de Messagens
     **/
    Util.showMessageBox = function(response) {
        Notifications.push({
            imagePath: (response.status === 'error') ? 'img/icons/error.png' : 'img/icons/success.png',
            text: '<p>' + ((response.status === 'error') ? 'Erro' : 'Sucesso') + '</p><div>' + response.message + '<div>',
            autoDismiss: 10
        });
    }

    /**
     * Reload Container
     **/
    Util.reloadContainer = function(url) {
        $('#loaging-content-container').show();
        $('.containercontent').load(url, function() {
            $('#loaging-content-container').fadeOut(500);
        });
    }

}
;