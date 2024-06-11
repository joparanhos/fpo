$(document).ready(function () {
    listar();

});


function listar() {
   
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: $('#form').serialize(),
        dataType: "html",

        success: function (result) {
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
            limparCamposUsuarios();
        }
    });
}


function excluir(id) {
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: { id },
        dataType: "text",

        success: function (mensagem) {
            if (mensagem.trim() == "Excluído com Sucesso") {
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }

        },

    });
}



function ativar(id, acao) {
    $.ajax({
        url: 'paginas/' + pag + "/mudar-status.php",
        method: 'POST',
        data: { id, acao },
        dataType: "text",

        success: function (mensagem) {
            if (mensagem.trim() == "Alterado com Sucesso") {
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }

        },

    });
}




function inserir() {
    $('#mensagem').text('');
    $('#titulo_inserir').text('Inserir Registro');
    $('#modalForm').modal('show');

    $('#nome').text('');

    
    document.getElementById('cpf').text = "";
    document.getElementById('cargo').value = "";
    document.getElementById('reg_conselho').value = "";
    document.getElementById('cbo').value = "";
    document.getElementById('id').value = "";

}



$("#form").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

               

                $('#btn-fechar').click();
                listar();

                

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


