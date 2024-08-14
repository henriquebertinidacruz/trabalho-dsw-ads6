$(document).ready(function () {
    $('#departamento').change(function () {
        var departamento_id = $(this).val();

        if (departamento_id !== '') {
            $.ajax({
                url: '/trabalho-dsw-ads6/models/AbrirChamadosModel.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    departamento_id: departamento_id
                },
                success: function (response) {
                    var options = '<option value="">Selecione o local</option>';
                    $.each(response, function (key, value) {
                        options += '<option value="' + value.id + '">' + value.local + '</option>';
                    });
                    $('#local').html(options);
                    $('#form-fields').show();
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    console.error('Erro ao carregar locals: ' + errorMessage);
                    $('#local').html('<option value="">Erro ao carregar locals</option>');
                }
            });
        } else {
            $('#local').html('<option value="">Selecione o departamento primeiro</option>');
            $('#form-fields').hide();
        }
    });

    $('#local').change(function () {
        var local = $(this).val();
        $('#descricaoProblema').html('<option value="">Carregando...</option>');
        $.ajax({
            url: '/trabalho-dsw-ads6/models/AbrirChamadosModel.php',
            type: 'POST',
            dataType: 'json',
            data: {
                local: local
            },
            success: function (response) {
                if (response.success) {
                    var options = '';
                    $.each(response.falhas, function (key, value) {
                        options += '<option value="' + value.falha + '">' + value.falha + '</option>';
                    });
                    $('#descricaoProblema').html(options);
                } else {
                    $('#descricaoProblema').html('<option value="">Nenhuma falha encontrada para este local</option>');
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                console.error('Erro ao carregar falhas: ' + errorMessage);
                $('#descricaoProblema').html('<option value="">Erro ao carregar falhas</option>');
            }
        });
    });

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

    $('#chamadoForm').submit(function (event) {
        event.preventDefault();
        swalLoading.fire();
        $('#alert-button').prop("disabled",true)

        $.ajax({
            url: '/trabalho-dsw-ads6/models/AbrirChamadosModel.php',
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
});
