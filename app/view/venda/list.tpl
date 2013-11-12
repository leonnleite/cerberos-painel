<h2>Lista de Vendas</h2>
<hr>
<table class="table table-bordered table-striped tablesorter">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Data / Hora</th>
            <th>Valor</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$vendas item=venda}
            <tr>
                <td>{$venda['nm_usuario']}</td>
                <td>{$venda['dt_venda']|substr:8:2}/{$venda['dt_venda']|substr:5:2}/{$venda['dt_venda']|substr:0:4} {$venda['dt_venda']|substr:11:8}</td>
                <td>R$ {$venda['vl_total']}</td>
                <td>
                    <img title="Excluir" class="excluirVenda" onClick="Venda.excluirVenda({$venda['id_venda']})" src="/img/delete.png"> 
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
<script type="text/javascript">
        !(function($){
    'use strict'
    $(document).ready(function(){
    $(".table").tablesorter();
});
})(jQuery);
</script>