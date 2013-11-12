<h2>Nova Promoção</h2>
<hr>
<fieldset>
    <form id="formCreatePromocao" method="post" action="/promocao/create/ajax/true">
        <div class="control-group">
            <label class="control-label" for="nm_promocao">Nome</label>
            <div class="controls">
                <input class="input-xlarge focused required" id="nm_promocao" name="nm_promocao" value="" type="text" maxlength="50">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="pc_promocao">Percentual de Desconto</label>
            <div class="controls">
                <select id="pc_promocao" name="pc_promocao" class="input-xlarge">
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                    <option value="25">25%</option>
                    <option value=30">30%</option>
                    <option value="35">35%</option>
                    <option value="40">40%</option>
                    <option value="45">45%</option>
                    <option value="50">50%</option>
                    <option value="55">55%</option>
                    <option value="60">60%</option>
                    <option value="65">65%</option>
                    <option value="70">70%</option>
                    <option value="75">75%</option>
                    <option value="80">80%</option>
                    <option value="85">85%</option>
                    <option value="90">90%</option>
                    <option value="95">95%</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="dt_validade">Validade</label>
            <div class="controls">
                <input class="input-xlarge focused required" id="dt_validade" name="dt_validade" type="text" readonly="readonly">
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
    $.datepicker.setDefaults( $.datepicker.regional = "pt-Br" );
    $( "#dt_validade" ).datepicker({
    minDate: -0,
    dateFormat: 'dd/mm/yy'
});
                
// Validacao do Formulario : Nova Promocao
var formNew = $('#formCreatePromocao');
var actionNew = formNew.attr('action');
       
$("#formCreatePromocao").validate({
errorClass: "help-inline",
submitHandler: function() {
if(confirm('Você tem certeza que deseja cadastrar esta nova promoção?')){
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