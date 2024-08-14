$(document).ready(function () {
    $('#item').select2({
        placeholder: 'Selecione uma opção',
        minimumInputLength: 3,
        width: '100%',
        ajax: {
            url: 'https://spm.multilaser.com.br/prod/api/sb1.php?acao=pesquisar-sb1-nova-parcial',
            dataType: 'json',
            method: 'POST',
            delay: 250,
            data: function (params) {
                return {
                    codigo: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.item,
                            text: item.item
                        };
                    })
                };
            },
            cache: false
        }
    });

    $('#setupForm').submit(function (event) {
        event.preventDefault();
        swalLoading.fire();
        $('#alert-button').prop("disabled",true);

        var formData = new FormData(this);

        $.ajax({
            url: '/trabalho-dsw-ads6/models/AberturaSetupModel.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                console.error('Erro ao registrar o setup: ' + errorMessage);
                Toast.fire({
                    icon: 'error',
                    title: 'Erro ao registrar o setup'
                });
            }
        });
    });

    const swalLoading = Swal.mixin({
        title: 'Carregando...',
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    window.adicionarDepartamento = function () {
        var container = document.getElementById('departamentosAdicionais');
        var div = document.createElement('div');
        div.className = 'd-flex mb-2';
        div.innerHTML = `
        <select class="form-control" name="departamento[]">
            <option value="Eng. Automação">Eng. Automação</option>
            <option value="Eng. Teste">Eng. Teste</option>
            <option value="Eng. Processos">Eng. Processos</option>
            <option value="Eng. Industrial">Eng. Industrial</option>
            <option value="Producao">Produção</option>
            <option value="Qualidade">Qualidade</option>
            <option value="Manutencao">Manutenção</option>
        </select>
        <button type="button" class="btn btn-remove ml-2" onclick="removerDepartamento(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
        container.appendChild(div);
    }

    window.removerDepartamento = function (button) {
        var container = document.getElementById('departamentosAdicionais');
        container.removeChild(button.parentElement);
    }

    window.adicionarDocumento = function () {
        var container = document.getElementById('documentosAdicionais');
        var div = document.createElement('div');
        div.className = 'd-flex mb-2';
        div.innerHTML = `
        <input type="file" class="form-control-file" name="documentos_adicionais[]">
        <button type="button" class="btn btn-remove ml-2" onclick="removerDocumento(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
        container.appendChild(div);
    }

    window.removerDocumento = function (button) {
        var container = document.getElementById('documentosAdicionais');
        container.removeChild(button.parentElement);
    }
});
