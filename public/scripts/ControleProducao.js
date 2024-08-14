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

    var table = $('#ordensTable').DataTable({
        "serverSide": true,
        ajax: {
            url: "/egp/controllers/ControleProducaoController.php?action=getData",
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
            {title: "ID", "data": "id"},
            {title: "Responsável", "data": "responsavel"},
            {title: "Linha", "data": "linha"},
            {title: "Produto", "data": "produto"},
            {title: "Ordem Produção", "data": "ordem_producao"},
            {title: "QTD Alocada", "data": "quantidade_alocada"},
            {title: "QTD Atual", "data": "quantidade_atual"},
            {title: "Status Ordem", "data": "status_producao"},
            {title: "DATA HORA", "data": "data_hora"},
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-atualizar" data-id="' + row.id + '"><i class="bi bi-sliders"></i></button>';
                }
            }
        ]
    });

    $('#cadastrarBtn').click(function () {
        $('#cadastrarModal').modal('show');
    });

    $('#novoCadastroForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/egp/controllers/ControleProducaoController.php?action=createOrdem',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: response.message,
                        confirmButtonColor: '#08253F'
                    }).then(function () {
                        $('#novoCadastroForm')[0].reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: response.message,
                        confirmButtonColor: '#08253F'
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro na solicitação: ' + error,
                    confirmButtonColor: '#08253F'
                });
            }
        });
    });


    $('#ordensTable tbody').on('click', '.btn-atualizar', async function () {
        const id = $(this).data('id');

        const {value: password} = await Swal.fire({
            title: "Digite sua senha",
            input: "password",
            inputLabel: "Senha",
            inputPlaceholder: "Digite sua senha",
            inputAttributes: {
                maxlength: "10",
                autocapitalize: "off",
                autocorrect: "off"
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        });

        if (password === 'joelminha') {
            $('#id').val(id);
            $('#atualizarModal').modal('show');
        } else if (password) {
            Swal.fire({
                icon: 'error',
                title: 'Senha incorreta',
                text: 'Por favor, tente novamente.'
            });
        }
    });

    const opSelect = document.getElementById('opSelect');
    const linhaSelect = document.getElementById('linhaSelect');
    const produtoSelect = document.getElementById('produtoSelect');
    const serialNumber = document.getElementById('serialNumber');
    const serialNumberContainer = serialNumber.parentElement;

    function checkSelects() {
        const opLabel = document.querySelector('label[for="opSelect"]');
        const linhaLabel = document.querySelector('label[for="linhaSelect"]');
        const produtoLabel = document.querySelector('label[for="produtoSelect"]');

        if (opSelect.value && linhaSelect.value && produtoSelect.value) {
            serialNumberContainer.style.display = 'block';
            opSelect.style.display = 'none';
            linhaSelect.style.display = 'none';
            produtoSelect.style.display = 'none';
            opLabel.style.display = 'none';
            linhaLabel.style.display = 'none';
            produtoLabel.style.display = 'none';
            serialNumber.focus();
        } else {
            serialNumberContainer.style.display = 'none';
            opSelect.style.display = 'block';
            linhaSelect.style.display = 'block';
            produtoSelect.style.display = 'block';
            opLabel.style.display = 'block';
            linhaLabel.style.display = 'block';
            produtoLabel.style.display = 'block';
        }
    }

    linhaSelect.addEventListener('change', checkSelects);
    opSelect.addEventListener('change', checkSelects);
    produtoSelect.addEventListener('change', checkSelects);

    function showToast(message, type) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "toastClass": type === 'success' ? 'toast-success' : 'toast-error'
        };

        toastr[type](message);
    }

    function validateSerialNumber(event) {
        const input = event.target;
        let value = input.value;

        if (event.keyCode === 13) {
            input.disabled = true;

            if (!value.startsWith('ZTE') || value.length !== 15) {
                showToast('O número de série deve começar com "ZTE" e ter exatamente 15 caracteres.', 'error');
                input.disabled = false;
                input.value = '';
                input.focus();
            } else {
                $.ajax({
                    url: '/egp/controllers/ControleProducaoController.php?action=createApontamento',
                    type: 'POST',
                    data: {
                        action: 'insertApontamento',
                        responsavel: $('#responsavel').val(),
                        linha: $('#linhaSelect').val(),
                        produto: $('#produtoSelect').val(),
                        ordem_producao: $('#opSelect').val(),
                        numero_serie: value,
                        data_hora: new Date().toISOString()
                    },
                    success: function (response) {
                        if (response.success) {
                            showToast('Número de série aceito e dados inseridos!', 'success');
                            input.disabled = false;
                            input.value = '';
                            input.focus();
                            table.ajax.reload();
                        } else {
                            // showToast('Número de série duplicado!', 'erro');
                            showToast(response.message, 'error');
                            input.disabled = false;
                            input.value = '';
                            input.focus();
                        }
                    },
                    dataType: 'json',
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        showToast('aqui!', 'error');
                        input.disabled = false;
                        input.value = '';
                        input.focus();
                    }
                });
            }

            event.preventDefault();
        } else {
            input.disabled = false;
        }
    }

    serialNumber.addEventListener('keydown', validateSerialNumber);
    serialNumberContainer.style.display = 'none';
});
