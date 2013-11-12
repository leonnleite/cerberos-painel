<h2>Lista de Promoções</h2>
<hr>
<table class="table table-bordered table-striped tablesorter">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Desconto</th>
            <th>Validade</th>
            <th>Desativar</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$promocoes item=promocao}
            <tr>
                <td>{$promocao['nm_promocao']}</td>
                <td>{$promocao['pc_promocao']}%</td>
                <td>{$promocao['dt_validade']|substr:8:2}/{$promocao['dt_validade']|substr:5:2}/{$promocao['dt_validade']|substr:0:4}</td>
                <td><img title="Desativar Promoção" class="desativarPromocao" onClick="Promocao.excluirPromocao({$promocao['id_promocao']})" src="/img/delete.png" </td>
            </tr>
        {/foreach}
    </tbody>
</table>
<script type="text/javascript">
        !(function($){
    'use strict'/
        $(document).ready(function(){
    $(".table").tablesorter();
});
})(jQuery);
</script>