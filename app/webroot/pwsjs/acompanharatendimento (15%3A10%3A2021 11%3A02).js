/**
 * Classe responsável pela classe php AcompanharAtendimento
 *
 * @autor Gustavo Silva
 * @since 16/07/19
 */

function acompanharatendimento() {
  (this.__construct = function () {
    this.index();

    this.header();
  }),
    (this.index = function () {
      $("body").css("background", "#eeeeee");

      // define os calendários
      $("#periodoIni").datetimepicker({
        lang: "pt",
        mask: true,
        timepicker: false,
        format: "d/m/Y",
      });
      $("#periodoFim").datetimepicker({
        lang: "pt",
        mask: true,
        timepicker: false,
        format: "d/m/Y",
      });

      // monta o grid
      var action = function () {
        var grid = $("#grid-selection");

        var methodPost = function () {
          // monta os dados de retorno do filtro
          return {
            json: {
              "AcompanharAtendimento.chamado_id": {
                value: $("#chamado_id").val(),
                operator: "=",
              },
              "AcompanharAtendimento.SEQOS": {
                value: $("#SEQOS").val(),
                operator: "=",
              },
              "AcompanharAtendimento.ANDAMENTO_CHAMADO_APP": {
                value: $("#ANDAMENTO_CHAMADO_APP").val(),
                operator: "=",
              },
              "Cliente.CDCLIENTE": {
                value: $("#CDCLIENTE").val(),
                operator: "=",
              },
              "AcompanharAtendimento.NMATENDENTE": {
                value: $("#NMATENDENTE").val(),
                operator: "=",
              },
              "AcompanharAtendimento.DTATENDIMENTO": {
                item: [
                  { value: $("#periodoIni").val(), operator: ">=" },
                  { value: $("#periodoFim").val(), operator: "<=" },
                ],
              },
            },
          };
        };

        grid
          .bootgrid({
            ajax: true,
            post: methodPost,
            method: "post",
            url: BASE_URL + "AcompanharAtendimento/index/",
            // selection: true,
            // multiSelect: true,
            formatters: {
              timeline: function (column, row) {
                const idChamado = row.idChamado.split("/");

                let data = "";

                data += `<button type="button" onClick="new acompanharatendimento().openTimeline('${row.id}', '${row.hash}', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-map-marker"></span></button>`;
                data += `<button type="button" onClick="new acompanharatendimento().openImage('${row.id}', '${row.hash}', '1', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-picture-o"></span></button>`;
                data += `<button type="button" onClick="new acompanharatendimento().openImage('${row.id}', '${row.hash}', '2', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-file-pdf-o"></span></button>`;
                data += `<button type="button" onClick="new acompanharatendimento().openDetail('${row.id}', '${row.hash}', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-info"></span></button>`;
                data += `<button type="button" onClick="javascript:location.href='Chamados/printPdf/${idChamado[1].trim()}/${row.id.trim()}'" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-file-archive-o"></span></button>`;
                data += `<button type="button" onClick="javascript:location.href='Chamados/view/${idChamado[1].trim()}'" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-clone"></span></button>`;
                

                return data;
              },
            },
          })
          .on("selected.rs.jquery.bootgrid", function (e, rows) {
            var rowIds = [];
            for (var i = 0; i < rows.length; i++) {
              rowIds.push(rows[i].id);
            }
          })
          .on("deselected.rs.jquery.bootgrid", function (e, rows) {
            var rowIds = [];
            for (var i = 0; i < rows.length; i++) {
              rowIds.push(rows[i].id);
            }
          });

        // Após iniciar o grid
        grid.ready(function () {
          $("button[title|='Atualizar']").css({
            "padding-bottom": "5px",
            "margin-right": "0px",
          });
          $(".dropdown.btn-group").css({ "margin-left": "1px" });

          $("#buttonFilter").click(function () {
            grid.bootgrid("reload");
          });

          // limpa os campos do filtro
          $("#buttonFilterClear").click(function () {
            $("#chamado_id").val("");
            $("#SEQOS").val("");
            $("#ANDAMENTO_CHAMADO_APP").val("");
            $("#CDCLIENTE").val("");
            $("#NMATENDENTE").val("");
            $("#periodoIni").val("");
            $("#periodoFim").val("");
          });
        });
      };

      new loadFileJs().load(
        "/pws/app/webroot/bootgrid/jquery.bootgrid.min.js",
        action
      );
    }),
    (this.header = function () {
      setInterval(function () {
        $.ajax({
          url: BASE_URL + "/AcompanharAtendimento/getDataHeader",
          async: true,
          type: "GET",
        }).done(function (jsonResponse) {
          var result = eval("(" + jsonResponse + ")");

          $("#atendente_rota").html("");
          $("#atendente_cliente").html("");
          $("#atendente_atendimento").html("");
          $("#atendente_finalizado").html("");

          $("#value_rota").text(result.content.rota.amount);

          result.content.rota.atendente.map(function (item) {
            $("#atendente_rota").append(
              "<span style='background:#666;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                item +
                "</span>"
            );
          });

          $("#value_cliente").text(result.content.cliente.amount);

          result.content.cliente.atendente.map(function (item) {
            $("#atendente_cliente").append(
              "<span style='background:#b78a5c;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                item +
                "</span>"
            );
          });

          $("#value_atendimento").text(result.content.atendimento.amount);

          result.content.atendimento.atendente.map(function (item) {
            $("#atendente_atendimento").append(
              "<span style='background:#5BB75B;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                item +
                "</span>"
            );
          });

          $("#value_finalizado").text(result.content.finalizado.amount);

          result.content.finalizado.atendente.map(function (item) {
            $("#atendente_finalizado").append(
              "<span style='background:#5c73b7;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                item +
                "</span>"
            );
          });
        });
      }, 3000);
    }),
    (this.openTimeline = function (id, hash, labelChamado) {
      var objModal = new modal();

      var action = function () {
        $("#map_canvas").text("carregando mapa...");

        $.ajax({
          url:
            BASE_URL +
            "/AcompanharAtendimento/getLocations?id=" +
            $("#idTimeline").val(),
          async: true,
          type: "GET",
        }).done(function (jsonResponse) {
          
          var locations = eval("(" + jsonResponse + ")");

          var map;
          var directionsDisplay;
          var directionsService = new google.maps.DirectionsService();

          var colorsMap = Array('#6A5ACD', '#836FFF', '#6959CD', '#483D8B', '#191970', '#000080', '#00008B', '#0000CD', '#0000FF', '#6495ED', '#4169E1', '#1E90FF', '#00BFFF', '#87CEFA', '#87CEEB', '#ADD8E6');

          // GOOGLE MAPS
          function init_map(locations) {
            
            var latlng = new google.maps.LatLng(
              locations.origin.latitude,
              locations.origin.longitude
            );

            var options = {
              zoom: 10,
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            map = new google.maps.Map(
              document.getElementById("map_canvas"),
              options
            );

            new google.maps.Marker({
              position: new google.maps.LatLng(
                locations.origin.latitude,
                locations.origin.longitude,
              ),
              map,
              title: "Início da Viagem",
            });

            new google.maps.Marker({
              position: new google.maps.LatLng(
                locations.destination.latitude,
                locations.destination.longitude,
              ),
              map,
              title: "Fim da viagem",
            });

            google.maps.event.addListenerOnce(map, "tilesloaded", function () {
              event.preventDefault();

              var prevLast = 0;

              var prevDistKm = 0;
              var prevDistMin = 0

              for(var i = 0; i <= locations.waypoints.length; i++){

                // pega os dados do grupo
                var data = locations.waypoints[i];
  
                // remove o primeiro e último
                var first = i == 0 ? data[0] : prevLast;
                var last = data[data.length - 1];

                prevLast = last;
  
                var waypoints = Array();
  
                for(var ii = 0; ii < data.length; ii++){
                  
                  var {latitude, longitude} = data[ii];
  
                  waypoints.push({
                    location: new google.maps.LatLng(latitude, longitude), stopover: false,
                  });
  
                }

                var request = {
                  // origin: locations.origin.location,
                  origin: new google.maps.LatLng(
                    first.latitude,
                    first.longitude
                  ),
                  // destination: locations.destination.location,
                  destination: new google.maps.LatLng(
                    last.latitude,
                    last.longitude
                  ),
                  waypoints: waypoints,
                  travelMode: google.maps.TravelMode.DRIVING,
                };

                // ====================================
                directionsService.route(request, function (result, status) {
                  var distkm = 0;
                  var distmin = 0;

                  // calcula a distância em KM
                  $.each(result.routes[0].legs, function (index, value) {
                    distkm += value.distance.value;
                    distmin += value.duration.value;
                  });

                  prevDistKm += distkm;
                  prevDistMin += distmin;

                  // define a distância
                  $("#distkm").text(prevDistKm / 1000 + " Km");

                  // calcula o tempo de atendimento
                  var calcHour = prevDistMin / 3600;

                  if (Math.round(calcHour) > 0) {
                    $("#distmin").text(Math.round(prevDistMin / 3600) + " horas");
                  } else {
                    $("#distmin").text(
                      "(" +
                        (prevDistMin / 3600).toFixed(2).replace("0.", "") +
                        " minutos)"
                    );
                  }

                  var directionsDisplay = new google.maps.DirectionsRenderer();
                  directionsDisplay.setMap(map);
                  directionsDisplay.setOptions({ suppressMarkers: true, preserveViewport: true });
                  if (status == google.maps.DirectionsStatus.OK) { directionsDisplay.setDirections(result); }

                });

              }

            });

          }

          init_map(locations);
        });
      };

      objModal.modalAjax({
        title: `Timeline Chamado - ${labelChamado}`,
        url: `AcompanharAtendimento/timeline?id=${id}&hash=${hash}`,
        ajaxAction: action,
        size: "2",
      });
    });

  this.openImage = function (id, hash, type, labelChamado) {
    var objModal = new modal();
    var action = function () {};

    objModal.modalAjax({
      title: `Chamado - ${labelChamado}`,
      url: `AcompanharAtendimento/image?id=${id}&hash=${hash}&pictureType=${type}`,
      ajaxAction: action,
      size: "2",
    });
  };

  this.openDetail = function (id, hash, labelChamado) {
    var action = function () {};

    new modal().modalAjax({
      title: `Detalhes do atendimento - Chamado ${labelChamado}`,
      url: `AcompanharAtendimento/detail?id=${id}&hash=${hash}`,
      ajaxAction: action,
      size: "2",
    });
  };
}
