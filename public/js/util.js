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
     * Mostrar Modal
     **/
    Util.showModal = function(titleWindow, titleModal, url) {
        $('#modalTitleWindow').html(titleWindow);
        $('#modalTitle').html(titleModal);
        $('#modalContent').load(url);
        $('#modal').modal();
    }

    /**
     * Ocultar Modal
     **/
    Util.hideModal = function() {
        $('#modal').modal('hide');
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