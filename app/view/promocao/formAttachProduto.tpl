<h2>Vincular Produto à Promoção</h2>
<hr>
<fieldset>
    <form id="formAttachProduto" method="post" action="/promocao/attachProduto/ajax/true">
        <div class="control-group">
            <label class="control-label" for="id_promocao">Promoção</label>
            <div class="controls">
                <select id="id_promocao" name="id_promocao" class="input-xlarge required">
                    {foreach from=$promocoes item=promocao}
                        <option value="{$promocao['id_promocao']}">{$promocao['nm_promocao']} ({$promocao['pc_promocao']}%)</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="id_produto">Produto</label>
            <div class="controls">
                <select id="id_promocao" name="id_produto" class="input-xlarge required">
                    {foreach from=$produtos item=produto}
                        <option value="{$produto['id_produto']}">{$produto['nm_produto']}</option>
                    {/foreach}
                </select>
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
                    
    // Validacao do Formulario : Vincular Promocao a Produto
    var formNew = $('#formAttachProduto');
    var actionNew = formNew.attr('action');
       
    $("#formAttachProduto").validate({
    errorClass: "help-inline",
    submitHandler: function() {
    if(confirm('Você tem certeza que deseja vincular este produto e esta promoção?')){
    $.post(actionNew, formNew.serialize(), function(response){
    if(response.status == 'success'){
    formNew.each(function(){
    this.reset();
});
}
showMessageBox(response);
reloadContainer('/promocao/formAttachProduto');
}, 'json') ;  
}
}
});
        
});


})(jQuery);


</script>