<h2>Novo Usuário</h2>
<hr>
<fieldset>
    <form id="formCreateUsuario" method="post" action="/usuario/create/ajax/true">
        <div class="control-group">
            <label class="control-label" for="nm_usuario">Nome</label>
            <div class="controls">
                <input class="input-xlarge focused required" id="nm_usuario" name="nm_usuario" type="text" maxlength="50">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="nu_cpf">CPF</label>
            <div class="controls">
                <input class="input-xlarge focused required cpf" id="nu_cpf" name="nu_cpf" type="text" maxlength="14">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="fg_perfil">Perfil</label>
            <div class="controls">
                <select id="fg_perfil" name="fg_perfil" class="input-xlarge">
                    <option value="0">Cliente</option>
                    <option value="1">Administrador</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="tx_email">Email</label>
            <div class="controls">
                <input class="input-xlarge focused required email" id="tx_email" name="tx_email" type="text" maxlength="50">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="tx_senha">Senha</label>
            <div class="controls">
                <input class="input-xlarge focused required" id="tx_senha" name="tx_senha" type="password" minlength="6">
            </div>
        </div>
        <div class="">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button class="btn" type="reset">Limpar</button>
        </div>
    </form>
</fieldset>

<script type="text/javascript">

        !(function($){
    'use strict'
    $(document).ready(function(){
            
    $('#nu_cpf').mask('999.999.999-99');
          
    // Validacao do Formulario : Novo Usuario
    var formNew = $('#formCreateUsuario');
    var actionNew = formNew.attr('action');
       
    $("#formCreateUsuario").validate({
    errorClass: "help-inline",
    submitHandler: function() {
    if(confirm('Você tem certeza que deseja cadastrar este novo usuário?')){
    $.post(actionNew, formNew.serialize(), function(response){
    if(response.status == 'success'){
    formNew.each(function(){
    this.reset();
});
}
showMessageBox(response);
}, 'json') ;  
}
}
});
        
});


})(jQuery);


</script>