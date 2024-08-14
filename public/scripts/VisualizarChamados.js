$(document).ready(function () {
    const userNivelAcesso = $('#userNivelAcesso').text();

    const toastLiveExample = document.getElementById('liveToast');
    const toastBody = document.getElementById('toastBody');

    let displayedChamados = new Set();

    const swalLoading = Swal.mixin({
        title: 'Carregando...',
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const table = $('#tableChamados').DataTable({
        "serverSide": true,
        "processing": true,
        "paging": false,
        "scrollY": "400px",
        "scrollCollapse": true,
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
            "url": "/trabalho-dsw-ads6/models/VisualizacaoChamadosModel.php",
            "type": "POST",
            "beforeSend": function() {
                swalLoading.fire();
            },
            "complete": function() {
                Swal.close();
            },
            "dataSrc": function (json) {
                let novosChamados = 0;
                json.data.forEach(chamado => {
                    if ((chamado.status === 'PENDENTE' || chamado.status === 'ACEITO') && !displayedChamados.has(chamado.id)) {
                        displayedChamados.add(chamado.id);
                        novosChamados++;
                    }
                });

                if (novosChamados > 0) {
                    const mensagem = `Time, temos ${novosChamados} novos chamados.`;
                    speak(mensagem);
                }

                return json.data;
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "solicitante" },
            { "data": "linha" },
            { "data": "local" },
            { "data": "item" },
            { "data": "descricao_problema" },
            { "data": "observacao" },
            { "data": "status" },
            { "data": "data_hora_abertura" },
            { "data": "tecnico_responsavel" },
            {
                "data": null,
                "render": function (data, type, row) {
                    const disableAction = userNivelAcesso === 'Operacional';
                    const isAccepted = data.status === 'ACEITO';

                    return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-settings"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item option-btn ${isAccepted || disableAction ? 'disabled' : ''}" data-id="${data.id}" data-action="accept">${isAccepted ? 'Chamado Aceito' : 'Aceitar Chamado'}</a>
                                <a class="dropdown-item option-btn ${disableAction ? 'disabled' : ''}" data-id="${data.id}" data-action="transfer">Transferir Chamado</a>
                            </div>
                        </div>
                    `;
                }
            }
        ],
    });

    $('#tableChamados').on('click', '.dropdown-item.option-btn', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }

        const id = $(this).data('id');
        const action = $(this).data('action');

        if (action === 'accept') {
            aceitarChamado(id);
        } else if (action === 'transfer') {
            transferirChamado(id);
        }
    });

    function aceitarChamado(chamadoId) {
        axios.post('/trabalho-dsw-ads6/models/AceitarChamadoModel.php', {
            chamadoId: chamadoId,
            action: 'aceitar'
        })
            .then(response => {
                $('#tableChamados').DataTable().ajax.reload(null, false);
            })
            .catch(error => {
                console.error('Error accepting chamado:', error);
            });
    }

    function transferirChamado(chamadoId) {
        const tecnicoResponsavel = prompt('Por favor, informe o nome do técnico responsável:');
        if (tecnicoResponsavel) {
            axios.post('/trabalho-dsw-ads6/models/AceitarChamadoModel.php', {
                chamadoId: chamadoId,
                action: 'transferir',
                tecnicoResponsavel: tecnicoResponsavel
            })
                .then(response => {
                    $('#tableChamados').DataTable().ajax.reload(null, false);
                })
                .catch(error => {
                    console.error('Error transferring chamado:', error);
                });
        }
    }

    function speak(text) {
        const msg = new SpeechSynthesisUtterance(text);
        msg.lang = 'pt-BR';
        window.speechSynthesis.speak(msg);
    }

    setInterval(function () {
        $('#tableChamados').DataTable().ajax.reload(null, false);
    }, 40000);
});
