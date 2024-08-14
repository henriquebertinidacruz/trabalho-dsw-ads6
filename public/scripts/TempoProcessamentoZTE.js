$(document).ready(function () {
    const swalLoading = Swal.mixin({
        title: 'Carregando...',
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    swalLoading.fire();

    var table = $('#timesTable').DataTable({
        "serverSide": true,
        ajax: {
            url: "/trabalho-dsw-ads6/controllers/TempoProcessamentoZTEController.php",
            contentType: "application/json",
            type: "POST",
            data: d => JSON.stringify(d),
            dataSrc: json => {
                Swal.close();
                return json;
            }
        },
        "processing": true,
        "serverSide": false,
        "paginType": "numbers",
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
        "columns": [
            { title : "ID", "data": "ID" },
            { title : "LINHA", "data": "LINHA" },
            { title : "item", "data": "item" },
            { title : "OPERADOR", "data": "OPERADOR" },
            { title : "MACHINE_NAME", "data": "MACHINE_NAME" , visible: false},
            { title : "DSN", "data": "D_SN" },
            { title : "SISTEMA", "data": "SISTEMA" },
            { title : "TEMPO", "data": "TEMPO_PROCESSO" },
            { title : "DATA HORA", "data": "DATA_HORA_INSERCAO_REGISTRO" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-atualizar" data-id="' + row.id + '"><i class="bi bi-sliders"></i></button>';
                }
            }
        ]
    });
});
