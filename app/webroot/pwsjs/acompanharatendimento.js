/**
 * Classe responsável pela classe php AcompanharAtendimento
 *
 * @autor Gustavo Silva
 * @since 16/07/19
 */
 function acompanharatendimento() {
    (this.__construct = function() {
        this.index();

        this.header();
    }),
    (this.index = function() {
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
        var action = function() {
            var grid = $("#grid-selection");

            var methodPost = function() {
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
                            item: [{
                                    value: $("#periodoIni").val(),
                                    operator: ">="
                                },
                                {
                                    value: $("#periodoFim").val(),
                                    operator: "<="
                                },
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
                        timeline: function(column, row) {
                            const idChamado = row.idChamado.split("/");

                            let data = "";

                            data += `<button type="button" onClick="new acompanharatendimento().openTimeline('${row.id}', '${row.hash}', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-map-marker"></span></button>`;
                            data += `<button type="button" onClick="new acompanharatendimento().openImage('${row.id}', '${row.hash}', '1', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-picture-o"></span></button>`;
                            data += `<button type="button" onClick="new acompanharatendimento().openImage('${row.id}', '${row.hash}', '2', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-file-pdf-o"></span></button>`;
                            data += `<button type="button" onClick="new acompanharatendimento().openDetail('${row.id}', '${row.hash}', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-file-archive-o"></span></button>`;
                            data += `<button type="button" onClick="new acompanharatendimento().openFormOs('${row.id}', '${row.idChamado}')" class="btn btn-xs btn-default command-edit" data-row-id="${row.id}"><span class="fa fa-info"></span></button>`;
                            data += `<button type="button" onClick="javascript:location.href='Chamados/view/${idChamado[1].trim()}'" class="btn btn-xs btn-default command-edit" data-row-id="${
					row.id
				  }"><span class="fa fa-clone"></span></button>`;

                            return data;
                        },
                    },
                })
                .on("selected.rs.jquery.bootgrid", function(e, rows) {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++) {
                        rowIds.push(rows[i].id);
                    }
                })
                .on("deselected.rs.jquery.bootgrid", function(e, rows) {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++) {
                        rowIds.push(rows[i].id);
                    }
                });

            // Após iniciar o grid
            grid.ready(function() {
                $("button[title|='Atualizar']").css({
                    "padding-bottom": "5px",
                    "margin-right": "0px",
                });
                $(".dropdown.btn-group").css({
                    "margin-left": "1px"
                });

                $("#buttonFilter").click(function() {
                    grid.bootgrid("reload");
                });

                // limpa os campos do filtro
                $("#buttonFilterClear").click(function() {
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
    (this.header = function() {
        setInterval(function() {
            $.ajax({
                url: BASE_URL + "/AcompanharAtendimento/getDataHeader",
                async: true,
                type: "GET",
            }).done(function(jsonResponse) {
                var result = eval("(" + jsonResponse + ")");

                $("#atendente_rota").html("");
                $("#atendente_cliente").html("");
                $("#atendente_atendimento").html("");
                $("#atendente_finalizado").html("");

                $("#value_rota").text(result.content.rota.amount);

                result.content.rota.atendente.map(function(item) {
                    $("#atendente_rota").append(
                        "<span style='background:#666;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                        item +
                        "</span>"
                    );
                });

                $("#value_cliente").text(result.content.cliente.amount);

                result.content.cliente.atendente.map(function(item) {
                    $("#atendente_cliente").append(
                        "<span style='background:#b78a5c;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                        item +
                        "</span>"
                    );
                });

                $("#value_atendimento").text(result.content.atendimento.amount);

                result.content.atendimento.atendente.map(function(item) {
                    $("#atendente_atendimento").append(
                        "<span style='background:#5BB75B;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                        item +
                        "</span>"
                    );
                });

                $("#value_finalizado").text(result.content.finalizado.amount);

                result.content.finalizado.atendente.map(function(item) {
                    $("#atendente_finalizado").append(
                        "<span style='background:#5c73b7;font-size:9px;padding:2px 5px 2px 5px;color:#fff;border-radius:5px; margin-right:2px'>" +
                        item +
                        "</span>"
                    );
                });
            });
        }, 3000);
    }),
    (this.openFormOs = function(id, idChamado) {
        const chamado = idChamado.split('/ ');
        window.location.href = 'Chamados/printPdf/' + chamado[1] + '/' + id;
    }),
    (this.openTimeline = function(id, hash, labelChamado) {
        var objModal = new modal();

        var action = function() {
            $("#map_canvas").text("carregando mapa...");

            $.ajax({
                url: BASE_URL +
                    "/AcompanharAtendimento/getLocations?id=" +
                    $("#idTimeline").val(),
                async: true,
                type: "GET",
            }).done(function(jsonResponse) {

                var locations = eval("(" + jsonResponse + ")");

                var map;
                var directionsDisplay;
                var directionsService = new google.maps.DirectionsService();

                // mantem o formato antigo dos mapas
                if (parseInt(locations.date) < 20210114) {
                    //   if(parseInt(locations.date) < 20300114){

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

                        google.maps.event.addListenerOnce(map, "tilesloaded", function() {
                            event.preventDefault();

                            var prevLast = 0;

                            var prevDistKm = 0;
                            var prevDistMin = 0

                            for (var i = 0; i <= locations.waypoints.length; i++) {

                                // pega os dados do grupo
                                var data = locations.waypoints[i];

                                // remove o primeiro e último
                                var first = i == 0 ? data[0] : prevLast;
                                var last = data[data.length - 1];

                                prevLast = last;

                                var waypoints = Array();

                                for (var ii = 0; ii < data.length; ii++) {

                                    var {
                                        latitude,
                                        longitude
                                    } = data[ii];

                                    waypoints.push({
                                        location: new google.maps.LatLng(latitude, longitude),
                                        stopover: true,
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
                                    optimizeWaypoints: true,
                                };

                                // ====================================
                                directionsService.route(request, function(result, status) {
                                    var distkm = 0;
                                    var distmin = 0;

                                    // calcula a distância em KM
                                    $.each(result.routes[0].legs, function(index, value) {
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
                                    directionsDisplay.setOptions({
                                        suppressMarkers: true,
                                        preserveViewport: true
                                    });
                                    if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(result);
                                    }

                                });

                            }

                        });

                    }

                } else {

                    // novo formato de montar os mapas
                    const createMarker = (position, title, pinColor, map) => {

                        var markerImage = {
                            path: "M 12,2 C 8.1340068,2 5,5.1340068 5,9 c 0,5.25 7,13 7,13 0,0 7,-7.75 7,-13 0,-3.8659932 -3.134007,-7 -7,-7 z",
                            anchor: new google.maps.Point(12, 17),
                            fillOpacity: 1,
                            fillColor: pinColor,
                            strokeWeight: 1,
                            strokeColor: "white",
                            scale: 1.3,
                            labelOrigin: new google.maps.Point(12, 9)
                        };

                        new google.maps.Marker({
                            position,
                            icon: markerImage,
                            map,
                            title,
                            animation: google.maps.Animation.DROP,
                        });

                    }

                    function init_map(locations) {

                        var latlng = new google.maps.LatLng(
                            locations.origin.latitude,
                            locations.origin.longitude
                        );

                        const map = new google.maps.Map(document.getElementById("map_canvas"), {
                            zoom: 14,
                            center: latlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                        });

                        createMarker(new google.maps.LatLng(
                            locations.origin.latitude,
                            locations.origin.longitude,
                        ), 'Início da Viagem', '#008000', map);

                        createMarker(new google.maps.LatLng(
                            locations.destination.latitude,
                            locations.destination.longitude,
                        ), 'Fim da viagem', '#000', map);

                        var waypoints = locations.waypoints; //.slice(4,5)
						var snappedCoordinates = [];
						var lastlatLng = null;

                        for (var i = 0; i < waypoints.length; i++) {

                            var data = waypoints[i];
							var path = [];

                            for (var ii = 0; ii < data.length; ii++) {

                                var {
                                    latitude,
                                    longitude
                                } = data[ii];

								var dataLatlng = parseFloat(latitude)+','+parseFloat(longitude)

                                path.push(dataLatlng);

                            }

							if(lastlatLng != null){
								path.unshift(lastlatLng);
							}

							lastlatLng = dataLatlng;

							$.ajax({
								type: 'GET',
								async: false,
								url: 'https://roads.googleapis.com/v1/snapToRoads',
								data: {
									interpolate: true,
									key: 'AIzaSyAJzqCIQ3uPa_gK3-VG3LhHNDB-pWL09ho',
									path: path.join('|')
								},
								success: function(data) {
									console.log(data);
									placeIdArray = [];
									for (var i = 0; i < data.snappedPoints.length; i++) {
										var latlng = new google.maps.LatLng(data.snappedPoints[i].location.latitude, data.snappedPoints[i].location.longitude);
										snappedCoordinates.push(latlng);
										// placeIdArray.push(data.snappedPoints[i].placeId);
									}
								}
							});
                        }

                        var iconsetngs = {
                            path: 'M491.858,442.461c0,13.931-11.293,25.224-25.224,25.224L245.93,373.097L25.224,467.686' +
                                'C11.292,467.686,0,456.392,0,442.461L227.011,32.58c0,0,18.918-18.918,37.834,0C283.764,51.499,491.858,442.461,491.858,442.461z',
                            fillColor: '#008000',
                            fillOpacity: 1,
                            scale: 0.03,
                            strokeColor: '#fff',
                            strokeWeight: 2,
                            anchor: new google.maps.Point(300, -100),
                        };

                        const drivingPathLine = new google.maps.Polyline({
                            path: snappedCoordinates,
                            strokeColor: "#008000",
                            strokeOpacity: 0.8,
                            strokeWeight: 3,
                            icons: [{
                                icon: iconsetngs,
                                repeat: '70px',
                            }],
                        });

                        $("#distkm").text(locations.calc + ' km');

                        drivingPathLine.setMap(map);

                    }

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

    this.openImage = function(id, hash, type, labelChamado) {
        var objModal = new modal();
        var action = function() {};

        objModal.modalAjax({
            title: `Chamado - ${labelChamado}`,
            url: `AcompanharAtendimento/image?id=${id}&hash=${hash}&pictureType=${type}`,
            ajaxAction: action,
            size: "2",
        });
    };

    this.openDetail = function(id, hash, labelChamado) {
        var action = function() {};

        new modal().modalAjax({
            title: `Detalhes do atendimento - Chamado ${labelChamado}`,
            url: `AcompanharAtendimento/detail?id=${id}&hash=${hash}`,
            ajaxAction: action,
            size: "2",
        });
    };
}
