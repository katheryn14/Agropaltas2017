$(function() {

            $("#jsGridRubros").jsGrid({
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
                       url: "../tabsAcceso/cargarDatos.php",
                       dataType: "json"
                       }).done(function(response){
                         data.resolve(response);
                     });
                      return data.promise();
                    }
                },
                 fields: [
                    { name: "ID",width: 150, align: "center" },
                    { name: "Descripcion", type: "text", width: 200},
                    { name: "Abreviatura", type: "text", width: 100, align: "center" },
                    { name: "Etiqueta", type: "text",width: 30, align:"center"},
                    { type: "control", editButton: false, modeSwitchButton: false }
                ]
            });

        });


