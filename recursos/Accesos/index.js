function llenarCBO(){
    var param_opcion='llenarCboEmpresa';
    $.ajax({
      type: 'POST',
      data: 'param_opcion='+param_opcion, 
      url: 'controlador/controlAcceso/controlUsuario.php',
      success: function(data){    
        $('#cboEmpresa').html(data);
      },
      error:function(data){
        alert('Error al mostrar');
      }
    });
  }
  function alCargarDocumento(){
    llenarCBO(); 
  }
  //EVENTOS
  window.addEventListener("load", alCargarDocumento);