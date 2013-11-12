<fieldset>
    <form id="formEditUsuario" method="post" action="/usuario/edit/ajax/true">
        <div class="control-group">
            <label class="control-label" for="nm_usuario">Nome</label>
            <div class="controls">
                <input name="id_usuario" type="hidden" value="{$id_usuario}">
                <input class="input-xlarge focused required" name="nm_usuario" type="text" maxlength="50" value="{$nm_usuario}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="nu_cpf">CPF</label>
            <div class="controls">
                <input class="input-xlarge focused required cpf" id="nu_cpf" name="nu_cpf" type="text" maxlength="14" value="{$nu_cpf}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="fg_perfil">Perfil</label>
            <div class="controls">
                <select id="fg_perfil" name="fg_perfil" class="input-xlarge">
                    <option value="0" {if $fg_perfil == 0} selected {/if}>Cliente</option>
                    <option value="1" {if $fg_perfil == 1} selected {/if}>Administrador</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="tx_email">Email</label>
            <div class="controls">
                <input class="input-xlarge focused required email" id="tx_email" name="tx_email" type="text" maxlength="50" value="{$tx_email}">
            </div>
        </div>
    </form>
</fieldset>

<script type="text/javascript">

        !(function($){
    'use strict'
    $(document).ready(function(){
            
    $('#nu_cpf').mask('999.999.999-99');
          
    // Validacao do Formulario : Editar Usuario
    var formNew = $('#formEditUsuario');
    var actionNew = formNew.attr('action');
       
    $("#formEditUsuario").validate({
    errorClass: "help-inline",
    submitHandler: function() {
    $.post(actionNew, formNew.serialize(), function(response){
    if(response.status == 'success'){
    formNew.each(function(){
    this.reset();
});
$('#modal-edit').modal('hide');
reloadContainer('/usuario/list');
}
showMessageBox(response);
}, 'json') ;  
}
});
        
});


})(jQuery);


</script>