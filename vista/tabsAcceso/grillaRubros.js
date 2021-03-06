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
                       url: "../../controlador/controlRubros/controlRubro.php",
                       dataType: "json"
                       }).done(function(response){
                         data.resolve(response);
                     });
                      return data.promise();
                    }
                },
                 fields: [
                   //{ name: "ID",width: 150, align: "center" },
                    { name: "Rubro", type: "text" },
                    { name: "Abreviatura", type: "text", align: "center" },
                    { name: "Etiqueta", type: "text"},
                    { type: "control", editButton: false, modeSwitchButton: false }
                ]
            });

        });


