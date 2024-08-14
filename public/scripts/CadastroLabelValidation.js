$(document).ready(function () {
    var table = $('#LabelValidationTable').DataTable({
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
            "url": "/trabalho-dsw-ads6/controllers/CarregarCadastroLabelValidationController.php",
            "type": "GET"
        },
        "columns": [
            { "data": "ID" },
            { "data": "item" },
            { "data": "TIPO" },
            { "data": "LEITOR" },
            { "data": "LEITOR_MASTER" },
            { "data": "LEITOR_3" },
            { "data": "QTD_CX_MASTER" },
            { "data": "QTD_LEITOR" },
            { "data": "QTD_CODIGO_MASTER" },
            { "data": "ID_COLUNA_QRCODE" },
            { "data": "REPLACE_DOUBLE_COMMA" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-atualizar" data-id="' + row.ID + '"><i class="bi bi-sliders"></i></button>';
                }
            }
        ]
    });

    $('#LabelValidationTable').on('click', '.btn-atualizar', function () {
        var id = $(this).data('id');
        var data = table.row($(this).parents('tr')).data();

        $('#id').val(data.ID);
        $('#item').val(data.item);
        $('#tipo').val(data.TIPO);
        $('#leitor').val(data.LEITOR);
        $('#leitor_master').val(data.LEITOR_MASTER);
        $('#leitor_3').val(data.LEITOR_3);
        $('#qtd_cx_master').val(data.QTD_CX_MASTER);
        $('#qtd_leitor').val(data.QTD_LEITOR);
        $('#qtd_codigo_master').val(data.QTD_CODIGO_MASTER);
        $('#id_coluna_qrcode').val(data.ID_COLUNA_QRCODE);
        $('#replace_double_comma').val(data.REPLACE_DOUBLE_COMMA);

        $('#atualizarModal').modal('show');
    });

    $('#salvarBtn').on('click', function () {
        var formData = $('#atualizarForm').serialize();

        $.ajax({
            url: '/trabalho-dsw-ads6/controllers/AtualizarCadastroLabelValidationController.php',
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