<h2>Registrar Venda</h2>
<hr>
<fieldset>
    <form id="formCreateUsuario" method="post" action="/venda/create/ajax/true">
        <div class="control-group">
            <label class="control-label" for="nu_cpf">CPF do Cliente</label>
            <div class="controls">
                <input class="input-xlarge focused required" id="nu_cpf" type="text" maxlength="14">
            </div>
            <label class="control-label" for="nm_usuario">Nome do Cliente</label>
            <div class="controls">
                <input class="input-xxlarge focused required" type="text" id="nm_usuario" maxlength="50" readonly="readonly">
                <input class="input-xlarge focused required" id="id_usuario" name="id_usuario" type="hidden" maxlength="50">
            </div>
        </div>

        <hr>

        <div class="control-group">
            <label class="control-label" for="id_produto">Selecione os Produtos</label>
            <div class="controls">
                <select id="id_produto" class="input-xxlarge">
                    {foreach from=$produtos item=produto}
                        <option value="{$produto['id_produto']}" vl_produto="{if $produto['vl_desconto']} {$produto['vl_desconto']} {else} {$produto['vl_produto']} {/if}">
                    {$produto['nm_produto']} - {if $produto['vl_desconto']} {$produto['nm_promocao']} de R$ {$produto['vl_produto']} por R$ {$produto['vl_desconto']} {else} R$ {$produto['vl_produto']} {/if}
                </option>
            {/foreach}
        </select>
        <button class="btn btn-primary success input-append" type="button" id="btnAddProdutoList">Adicionar Produto na Lista</button>
    </div>
</div>


<table class="table table-striped table-condensed">
    <thead>
        <tr>
            <td class="span8">Nome do Produto</td>
            <td class="span2">Valor (c/ Desconto)</td>
            <td class="span1">Quantidade</td>
            <td class="span1">Remover</td>
        </tr>
    </thead>
    <tbody id="containerProdutosVenda"></tbody>
</table>


<hr>
<hr>

<div class="control-group right">
    <label class="control-label" for="vl_total">Total à Pagar</label>
    <div class="controls">
        <input class="input-xlarge focused required success" id="vl_total" name="vl_total" type="text" readonly="readonly">
    </div>
</div>

<hr>

<div class="">
    <button type="submit" class="btn btn-primary">Salvar</button>
    <button class="btn" type="reset" onClick="Venda.cancelarVenda()">Cancelar</button>
</div>
</form>
</fieldset>

<script type="text/javascript">

        !(function($){
    'use strict'
    $(document).ready(function(){
            
    $('#nu_cpf').mask('999.999.999-99');
            
    $('.qt_produto').live('blur',function(){
    Venda.atualizarTotalVenda();
});
            
$('#nu_cpf').blur(function(){
if($(this).val().length=='14'){
$.post('/usuario/findClienteByCpf',{
nu_cpf:$(this).val()
},function(response){
if(response.status=='success'){
$('#nm_usuario').val(response.nm_usuario);
$('#id_usuario').val(response.id_usuario);
$('#nu_cpf').attr('disabled','disabled');
}else{
$('#nm_usuario').val('');
$('#id_usuario').val('');
showMessageBox(response);
}
},'json');
}
});
          
var tmpl = '<tr id="produto[[id_produto]]">'
+ '<td class="span8"><input class="id_produto" type="hidden" value="[[id_produto]]" name="id_produto[[[id_produto]]]">[[nm_produto]]</td>'
+ '<td class="span2">R$ <input class="span1 vl_produto required" name="vl_produto[[[id_produto]]]" value="[[vl_produto]]" readonly="readonly" type="text"></td>'
+ '<td class="span2"><input class="span1 qt_produto required integer" name="qt_produto[[[id_produto]]]" value="1" type="text"></td>'
+ '<td class="span1"><img title="Remover" onClick="Venda.removerProdutoList([[id_produto]])" src="/img/delete.png"></td>'
+ '</tr>';
            
$('#btnAddProdutoList').click(function(){
              
var valid = true;
                
$.each($('#containerProdutosVenda .id_produto'), function(){
if($(this).val()==$('#id_produto option:selected').val()){
valid = false;
}
});
                
if(!valid){
showMessageBox({
status:'error',
message:'Este produto já está na lista!'
})
return false;
}
               
$('#containerProdutosVenda').append(
tmpl.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[id_produto]]',$('#id_produto option:selected').val())
.replace('[[nm_produto]]',$('#id_produto option:selected').text())
.replace('[[vl_produto]]',$('#id_produto option:selected').attr('vl_produto')));

/**
*
**/
Venda.atualizarTotalVenda();

               
});
            
                
// Validacao do Formulario : Novo Venda
var formNew = $('#formCreateUsuario');
var actionNew = formNew.attr('action');
       
$("#formCreateUsuario").validate({
errorClass: "help-inline",
submitHandler: function() {
if(confirm('Você tem certeza que deseja registrar esta venda?')){
$.post(actionNew, formNew.serialize(), function(response){
if(response.status == 'success'){
formNew.each(function(){
this.reset();
});
$('#containerProdutosVenda').empty();
}
showMessageBox(response);
}, 'json') ;  
}
}
});
        
});

})(jQuery);


</script>