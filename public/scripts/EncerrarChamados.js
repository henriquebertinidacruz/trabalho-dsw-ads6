function validarFormulario() {
    var idDoChamado = document.getElementById('idDoChamado').value;
    var solucaoProblema = document.getElementById('solucaoProblema').value;

    if (idDoChamado === '') {
        document.getElementById('validationLabel').innerText = 'Selecione um ID de chamado válido.';
        return false;
    }

    if (solucaoProblema.trim() === '') {
        document.getElementById('validationLabel').innerText = 'Informe a solução do problema.';
        return false;
    }

    return true;
}

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

$('#encerrarChamadoForm').submit(function (event) {
    event.preventDefault();

    swalLoading.fire();

    $.ajax({
        url: '/trabalho-dsw-ads6/models/EncerrarChamadosModel.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize() + '&registrarAtendimento=true',
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
            console.error('Erro ao registrar o chamado: ' + errorMessage);
            Toast.fire({
                icon: 'error',
                title: 'Erro ao registrar o chamado'
            });
        }
    });
});