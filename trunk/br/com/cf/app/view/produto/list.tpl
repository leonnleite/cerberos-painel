<h2>Lista de Produtos</h2>
<hr>
<table class="table table-bordered table-striped tablesorter">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$produtos item=produto}
            <tr>
                <td>{$produto['nm_produto']}</td>
                <td>{if $produto['vl_desconto']} (Em promoção) De R$ {$produto['vl_produto']} por R$ {$produto['vl_desconto']} {else} R$ {$produto['vl_produto']} {/if}</td>
                <td>
                    <img title="Editar" class="btn16" onClick="Produto.editarProduto({$produto['id_produto']})" src="/img/edit.png">
                    <img title="Excluir" class="btn16" onClick="Produto.excluirProduto({$produto['id_produto']})" src="/img/delete.png"> 
                </td>
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