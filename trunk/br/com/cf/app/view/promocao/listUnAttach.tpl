<h2>Lista de Produtos Vinculados à Promoções</h2>
<hr>
<table class="table table-bordered table-striped tablesorter">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Promoção</th>
            <th>Validade</th>
            <th>Desconto % </th>
            <th>Preço c/ Desconto</th>
            <th>Desvincular</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$produtos item=produto}
            <tr>
                <td>{$produto['nm_produto']}</td>
                <td>{"R$ {$produto['vl_produto']}"}</td> 
                <td>{$produto['nm_promocao']}</td>
                <td>{$produto['dt_validade']|substr:8:2}/{$produto['dt_validade']|substr:5:2}/{$produto['dt_validade']|substr:0:4}</td>
                <td>{$produto['pc_promocao']}%</td>
                <td>R${$produto['vl_desconto']}</td>
                <td><img title="Desvincular" class="desativarPromocao" onClick="Promocao.desvincularProdutoPromocao({$produto['id_produto']},{$produto['id_promocao']})" src="/img/delete.png" </td>
            </tr>
        {/foreach}
    </tbody>
</table>
<script type="text/javascript">
        !(function($){
    'use strict';
    $(document).ready(function(){
    $(".table").tablesorter();
});
})(jQuery);
</script>