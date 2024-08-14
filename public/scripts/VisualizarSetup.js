$(document).ready(function () {
  const table = $("#setupTable").DataTable({
    serverSide: true,
    processing: true,
    language: {
      paginate: {
        previous: '<i class="ti-angle-left"></i>',
        next: '<i class="ti-angle-right"></i>',
      },
      search: "Pesquisar",
      lengthMenu: "Exibindo _MENU_ registros por página.",
      zeroRecords: "Dados não encontrados!",
      info: "_MAX_ registros encontrados.",
      infoEmpty: "",
      infoFiltered: "(filtro aplicado)",
    },
    ajax: {
      url: "/trabalho-dsw-ads6/models/VisualizarSetupModel.php",
      type: "POST",
      dataSrc: "data",
    },
    columns: [
      { data: "id" },
      { data: "solicitante" },
      { data: "linha" },
      { data: "item" },
      { data: "tempo_setup" },
      { data: "observacao" },
      {
        data: "departamentos_solicitados",
        render: function (data) {
          return Array.isArray(data) ? data.join(", ") : data;
        },
      },
      {
        data: "documentos",
        render: function (data) {
          return data
            .map(function (doc) {
              return doc.split("/").pop();
            })
            .join("<br>");
        },
      },
      { data: "data_hora_abertura" },
      { data: "status_setup" },
      {
        data: null,
        defaultContent:
          '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"><i class="fas fa-cog"></i></button><div class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton"><a class="dropdown-item btn-documentos">Documentos</a><a class="dropdown-item btn-departamentos">Departamentos</a></div></div>',
        orderable: false,
      },
    ],
  });

  $("#setupTable tbody").on("click", "a.btn-documentos", function () {
    const data = table.row($(this).parents("tr")).data();
    let documentosHtml = "";

    data.documentos.forEach((doc, index) => {
      documentosHtml += `
          <div class="mb-2">
            <strong>Documento ${index + 1}:</strong>
            <a href="${doc}" class="btn waves-effect m-2 text-white waves-light d-flex btn-large justify-content-between align-items-center" style="background-color: #08253F" download>
              <span>${doc.split("/").pop()}</span>
              <i class="bi bi-download"></i>
            </a>
          </div>`;
    });

    Swal.fire({
      title: "Download de Documentos",
      html: documentosHtml,
      showCancelButton: true,
      showConfirmButton: false,
      showCancelText: "Fechar",
      icon: "info",
      customClass: {
        popup: "swal2-popup",
        title: "swal2-title",
        htmlContainer: "swal2-html-container",
      },
    });
  });

  $("#setupTable tbody").on("click", "a.btn-departamentos", function () {
    const data = table.row($(this).parents("tr")).data();
    const departamentos = data.departamentos_solicitados
      ? data.departamentos_solicitados.split(";")
      : [];
    const setupId = data.id;

    function buscarDadosAceite(setupId) {
      const data = { setupId: setupId, action: "buscarDadosAceite" };

      return $.ajax({
        url: "/egp/models/VisualizarSetupModel.php",
        method: "POST",
        data: data,
        dataType: "json",
      });
    }

    function mostrarModal(dadosAceite) {
      // Converta os dados de aceite em um mapa para acesso rápido
      const dadosAceiteMap = dadosAceite.reduce((map, item) => {
        map[item.departamento] = { status: item.status, tecnico: item.tecnico };
        return map;
      }, {});

      const statusDepartamento = departamentos
        .map((dep, index) => {
          const { status = "Aguardando", tecnico = "Não definido" } =
            dadosAceiteMap[dep.trim()] || {};

          const isDisabled = status === "ACEITO" ? "disabled" : "";

          return `
              <tr>
                  <td>${dep.trim()}</td>
                  <td>${tecnico}</td>
                  <td id="status-${index}">${status}</td>
                  <td>
                      <button class="btn btn-success btn-sm" data-setup-id="${setupId}" data-departamento="${dep.trim()}" data-index="${index}" ${isDisabled}>Aceitar</button>
                  </td>
              </tr>
          `;
        })
        .join("");

      const departamentosHtml = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Técnico</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                ${statusDepartamento}
            </tbody>
        </table>
      `;

      Swal.fire({
        title: "Departamentos Solicitados",
        html: departamentosHtml,
        icon: "info",
        confirmButtonText: "Fechar",
        customClass: {
          popup: "swal2-popup swal2-custom",
          title: "swal2-title",
          htmlContainer: "swal2-html-container",
        },
        didOpen: () => {
          const popup = Swal.getPopup();
          popup.style.width = "40vw";
        },
      });
    }

    $.when(buscarDadosAceite(setupId))
      .done(function (response) {
        if (response.success) {
          mostrarModal(response.data);
        } else {
          console.error(
            "Falha ao mostrar modal - Erro ao buscar dados de aceite: ",
            response.message
          );
        }
      })
      .fail(function (xhr, status, error) {
        console.error("Erro ao buscar dados de aceite: ", error);
      });

    function aceitarDepartamento(button) {
      const setupId = button.data("setup-id");
      const departamento = button.data("departamento");
      const index = button.data("index");

      $.ajax({
        url: "/egp/models/VisualizarSetupModel.php",
        method: "POST",
        data: {
          setupId: setupId,
          departamento: departamento,
          action: "aceitarDepartamento",
        },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            $(`#status-${index}`).text("ACEITO");
            button.prop("disabled", true);
          } else {
            console.error(
              "Erro ao aceitar departamento: ",
              response.message || "Erro desconhecido"
            );
          }
        },
        error: function (xhr, status, error) {
          console.error("Erro ao aceitar departamento: ", error);
        },
      });
    }

    $(document).on("click", "button[data-setup-id]", function () {
      const button = $(this);
      const status = $(`#status-${button.data("index")}`).text();

      if (status !== "ACEITO") {
        aceitarDepartamento(button);
      }
    });
  });

  function aceitarDepartamento(button) {
    const setupId = button.data("setup-id");
    const departamento = button.data("departamento");
    const index = button.data("index");

<<<<<<< HEAD:public/scripts/VisualizarSetup.js
    $.post(
      "/trabalho-dsw-ads6/models/AceitarSetupModel.php",
      { id: setupId, departamento: departamento },
      function (response) {
        const data = JSON.parse(response);
        if (data.status === "success") {
          $(`#status-${index}`).text("ACEITO");
          Swal.fire({
            title: "Departamento Aceito!",
            text: `O departamento ${departamento} foi aceito com sucesso.`,
            icon: "success",
            confirmButtonText: "OK",
          });
        } else {
          Swal.fire({
            title: "Erro!",
            text: "Houve um erro ao aceitar o departamento.",
            icon: "error",
            confirmButtonText: "OK",
          });
=======
    $.ajax({
      url: "/egp/models/VisualizarSetupModel.php",
      method: "POST",
      data: {
        setupId: setupId,
        departamento: departamento,
        action: "aceitarDepartamento",
      },
      success: function (response) {
        try {
          const data = JSON.parse(response);
          if (data.success) {
            $(`#status-${index}`).text("ACEITO");
            button.prop("disabled", true);
          } else {
            console.error(
              "Erro ao aceitar departamento: ",
              data.message || "Erro desconhecido"
            );
          }
        } catch (e) {
          console.error("Erro ao processar a resposta: ", e);
>>>>>>> 7cf1c77d1513f5af13f3e5e730f67583bc70ff97:src/public/scripts/VisualizarSetup.js
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro ao aceitar departamento: ", error);
      },
    });
  }

  setInterval(function () {
    table.ajax.reload(null, false);
  }, 40000);
});
