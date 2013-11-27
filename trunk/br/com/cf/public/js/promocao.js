;
{
    var Promocao = {};

    /**
     *
     **/
    Promocao.excluirPromocao = function(id){
        if(confirm('Você tem certeza que deseja excluir esta promoção?')){
            $.post('/promocao/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/promocao/list/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }
    
    /**
     *
     **/
    Promocao.desvincularProdutoPromocao = function(idProduto,idPromocao){
        if(confirm('Você tem certeza que deseja desvincular este produto desta promoção?')){
            $.post('/promocao/unAttachProduto/ajax/true', {
                idProduto:idProduto,
                idPromocao:idPromocao
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/promocao/listUnAttachProduto/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

};