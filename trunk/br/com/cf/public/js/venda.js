;
{
    var Venda = {};
    
    /**
     *
     **/
    Venda.cancelarVenda = function(){
        Util.reloadContainer('/venda/formCreate/ajax/true');
    }

    /**
     *
     **/
    Venda.atualizarTotalVenda = function(){
        var total = 0.00;
        $.each($('#containerProdutosVenda tr'), function(){
            total = total+ ($('.vl_produto',this).val() * $('.qt_produto',this).val());
        });
        $('#vl_total').val((total.toFixed(2)!=0.00)?total.toFixed(2):'');
    }
        
    /**
     *
     **/
    Venda.removerProdutoList = function(id){
        $('#produto'+id).remove();
        Venda.atualizarTotalVenda();
    }

    /**
     *
     **/
    Venda.excluirVenda = function(id){
        if(confirm('Você tem certeza que deseja excluir esta venda?')){
            $.post('/venda/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/venda/list/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

};