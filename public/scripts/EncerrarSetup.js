function concluirSetup(setupId, departamento, tecnico) {
  console.log('Setup ID:', setupId);
  console.log('Departamento:', departamento);
  console.log('Técnico:', tecnico);

  $.ajax({
    url: '/egp/controllers/EncerrarSetupController.php',
    type: 'POST',
    data: {
      setup_id: setupId,
      departamento: departamento,
      tecnico: tecnico
    },
    success: function(response) {
      console.log(response);
      Swal.fire('Sucesso!', 'Setup concluído com sucesso.', 'success');
    },
    error: function(xhr, status, error) {
      console.error('Erro ao concluir o setup:', error);
      Swal.fire('Erro!', 'Ocorreu um erro ao concluir o setup.', 'error');
    }
  });
}
