;
{

    Index.admin = {};

    Index.admin.gridJogadorAdmin = null;

    Index.admin.btnSearchJogadorAdminHiddenToggle = true;

    Index.admin.autocompleteClubeJogadorAdmin = null;

    Index.admin.autocompletePaisJogadorAdmin = null;

    Index.admin.autocompleteSelecaoJogadorAdmin = null;

}
;

;
{

    $(document).ready(function() {
        $('.containercontent').load('/jogador/list');
    });
}
;