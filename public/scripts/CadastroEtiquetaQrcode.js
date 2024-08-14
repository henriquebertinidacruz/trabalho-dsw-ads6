$(document).ready(function () {
    var table = $('#etiquetasTable').DataTable({
        "processing": true,
        "serverSide": false,
        language: {
            paginate: {
                previous: '<i class="ti-angle-left"></i>',
                next: '<i class="ti-angle-right"></i>',
            },
            search: 'Pesquisar',
            lengthMenu: 'Exibindo _MENU_ registros por página.',
            zeroRecords: 'Dados não encontrados!',
            info: '_MAX_ registros encontrados.',
            infoEmpty: '',
            infoFiltered: '(filtro aplicado)',
        },
        "ajax": {
            "url": "/trabalho-dsw-ads6/controllers/CarregarCadastroEtiquetasQrcodeController.php",
            "type": "GET"
        },
        "columns": [
            { "data": "id" },
            { "data": "familia" },
            { "data": "item" },
            { "data": "peso_min" },
            { "data": "peso_max" },
            { "data": "descricao" },
            { "data": "ean" },
            { "data": "zpl" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-atualizar" data-id="' + row.id + '"><i class="bi bi-sliders"></i></button>';
                }
            }
        ]
    });

    $('#etiquetasTable').on('click', '.btn-atualizar', function () {
        var id = $(this).data('id');
        console.log('Botão Atualizar ID: ' + id);

        var data = table.row($(this).parents('tr')).data();

        $('#id').val(data.id);
        $('#familia').val(data.familia);
        $('#item').val(data.item);
        $('#peso_min').val(data.peso_min);
        $('#peso_max').val(data.peso_max);
        $('#descricao').val(data.descricao);
        $('#ean').val(data.ean);
        $('#zpl').val(data.zpl);

        $('#atualizarModal').modal('show');
    });

    $('#atualizarForm').submit(function (event) {
        event.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '/trabalho-dsw-ads6/controllers/AtualizarCadastroEtiquetaQrcodeController.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#atualizarModal').modal('hide');
                table.ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error('Erro ao atualizar os dados:', error);
            }
        });
    });

});