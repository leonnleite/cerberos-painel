;
{
    
    var Usuario = {};
    
    /**
     *
     **/
    Usuario.excluirUsuario = function(id){
        if(confirm('Você tem certeza que deseja excluir esta usuário?')){
            $.post('/usuario/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/usuario/list/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

    /**
     *
     **/
    Usuario.excluirAdministrador = function(id){
        if(confirm('Você tem certeza que deseja excluir este administrador?')){
            $.post('/usuario/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/usuario/listAdministrador/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

    /**
     *
     **/
    Usuario.excluirCliente = function(id){
        if(confirm('Você tem certeza que deseja excluir este cliente?')){
            $.post('/usuario/delete/ajax/true', {
                id:id
            }, function(response){
                if(response.status == 'success'){
                    Util.reloadContainer('/usuario/listCliente/ajax/true');
                }
                Util.showMessageBox(response);
            }, 'json') ;  
        }
    }

    /**
     *
     **/
    Usuario.editarUsuario = function(id){
        $('#modal-edit .modal-body .content').load('/usuario/formEdit/ajax/true/id_usuario/'+id);
        $('#modal-edit .modal-header .title').html('Editar Informações');
        $('#modal-edit .modal-footer .close-message-box').click(function(){
            $('#formEditUsuario').submit();
        });
 
        $('#modal-edit').modal('show');
 
    }

};