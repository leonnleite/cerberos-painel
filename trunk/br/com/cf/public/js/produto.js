;
{
    var Produto = {};
    
    /**
     *
     **/
    Produto.excluirProduto = function (id){
        if(confirm('Você tem certeza que deseja excluir esta produto?')){
            $.post('/produto/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/produto/list/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

    /**
     *
     **/
    Produto.editarProduto = function(id){
        $('#modal-edit .modal-body .content').load('/produto/formEdit/ajax/true/id_produto/'+id);
        $('#modal-edit .modal-header .title').html('Editar Informações');
        $('#modal-edit .modal-footer .close-message-box').click(function(){
            $('#formEditProduto').submit();
        });
 
        $('#modal-edit').modal('show');
    }
    
};