<h2>Lista de Usuários</h2>
<hr>
<table class="table table-bordered table-striped tablesorter">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Perfil</th>
            <th>Email</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$usuarios item=usuario}
            <tr>
                <td>{$usuario['nm_usuario']}</td>
                <td>{$usuario['nu_cpf']}</td>
                <td>{if $usuario['fg_perfil'] == 0} Cliente {else} Administrador {/if}</td>
                <td>{$usuario['tx_email']}</td>
                <td>
                    <img title="Editar" class="btn16" onClick="Usuario.editarUsuario({$usuario['id_usuario']})" src="/img/edit.png"> 
                    <img title="Excluir" class="btn16" onClick="Usuario.excluirUsuario({$usuario['id_usuario']})" src="/img/delete.png"> 
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