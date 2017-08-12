$(function() {

            $("#jsGridActividades").jsGrid({
                height: "auto",
                width: "100%",
                inserting: true,
                editing: true,
                sorting: true,
                paging: false,
                autoload: true,
                controller: {
                    loadData: function (filter) {
                     var data = $.Deferred();
                     $.ajax({
                       type: "GET",
                       contentType: "application/json; charset=utf-8",
                       url: "../../controlador/controlRubros/controlActividad.php",
                       dataType: "json"
                       }).done(function(response){
                         data.resolve(response);
                     });
                      return data.promise();
                    }
                },
                 fields: [
                   //{ name: "ID",width: 150, align: "center" },
                    { name: "Actividad", type: "text" },
                    { name: "Rubro", type: "select", items: db, valueField: "Id", textField: "name" },
                    { name: "Abreviatura", type: "text"},
                    { type: "control", editButton: false, modeSwitchButton: false }
                ]
            });

        });
  var db = [
        { name: "-- SELECCIONE RUBRO --", Id: 0 },
        { name: "United States", Id: 1 },
        { name: "Canada", Id: 2 },
        { name: "United Kingdom", Id: 3 },
        { name: "France", Id: 4 },
        { name: "Brazil", Id: 5 }
    ];

