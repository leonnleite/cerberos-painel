<fieldset>
    <form id="formEditProduto" method="post" action="/produto/edit/ajax/true">
        <div class="control-group">
            <label class="control-label" for="nm_produto">Nome</label>
            <div class="controls">
                <input name="id_produto" type="hidden" value="{$id_produto}">
                <input class="input-xlarge focused required" id="nm_produto" name="nm_produto" type="text" maxlength="50" value="{$nm_produto}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="vl_produto">Preço</label>
            <div class="controls">
                <input class="input-xlarge focused required money" id="vl_produto" name="vl_produto" type="text" value="{$vl_produto}">
            </div>
        </div>
    </form>
</fieldset>

<script type="text/javascript">

        !(function($){
    'use strict'
    $(document).ready(function(){
                
    // Validacao do Formulario : Editar Produto
    var formNew = $('#formEditProduto');
    var actionNew = formNew.attr('action');
       
    $("#formEditProduto").validate({
    errorClass: "help-inline",
    submitHandler: function() {
    $.post(actionNew, formNew.serialize(), function(response){
    if(response.status == 'success'){
    formNew.each(function(){
    this.reset();
});
$('#modal-edit').modal('hide');
reloadContainer('/produto/list');
}
showMessageBox(response);
}, 'json') ;  
}
});
        
});


})(jQuery);


</script>