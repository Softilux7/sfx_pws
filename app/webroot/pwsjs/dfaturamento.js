/**
 * Classe responsável pela classe php DFaturamento
 *
 * @autor Gustavo Silva
 * @since 08/12/17
 */
function dfaturamento() {

    this.__construct = function () {

        $('#info').popover('show');

    },

    this.uploadFile = function (id) {

        var objModal =  new modal();

        // action da view
        var action  = function(){

            $('#UploadIdEmpresa').change(function(e){

                $('#UploadIdCliente').children('').remove(); //option:not(:first)
                $('#UploadIdContrato').children('').remove();

                if (e.currentTarget.value !== "0") { //Opção Selecione

                    //$('#UploadIdCliente').append($("<option></option>").attr("value", 0).text(""));

                    //Mensagem de carregando no select de clientes
                    $('#UploadIdCliente').empty().append('<option value="0">Aguarde...</option>');

                    $.ajax({
                        url    : BASE_URL + "DFaturamentos/selectCliente/" + e.currentTarget.value,
                        async  : true,
                        type    : "GET"})
                        .done(function(jsonResponse) {
                            const response = JSON.parse(jsonResponse);

                            $('#UploadIdCliente').empty();

                            $.each(response.content, function(id, valor) {
                                $('#UploadIdCliente').append($("<option></option>").attr("value", valor.id).text(valor.name));
                            });

                        })
                        .fail(function(e) {})
                        .always(function() {});
                } else {
                    $('#UploadIdCliente').empty();
                }

            });

            $('#UploadIdCliente').change(function(e){

                $('#UploadIdContrato').children('').remove();

                var idEmpresa = $('#UploadIdEmpresa').val();

                $.ajax({
                    url    : BASE_URL + "DFaturamentos/selectContrato/" + e.currentTarget.value + "/" + idEmpresa,
                    async  : true,
                    type    : "GET"})
                    .done(function(jsonResponse) {

                        var response = JSON.parse(jsonResponse);

                        $.each(response.content, function(id, valor) {
                            $('#UploadIdContrato').append($("<option></option>").attr("value", valor.id).text(valor.name));
                        });

                    })
                    .fail(function(e) {})
                    .always(function() {});

            });

            $('#buttonActionModal').remove();

            // adiciona o botão de salvar
            $("#bar-button-modal").append('<button type="button" id="buttonActionModal" class="btn btn-success" >Salvar</button>');

            $('#buttonActionModal').click(function(){

                // submeti o form
                $('#UploadUploadModalForm').submit();

            });

            var objModal =  new modal();

            // método responsável pelo post
            objModal.modalPostFilesAjax();

        }

        // cria view do upload
        objModal.modalAjax({title : 'Upload de arquivos', url : '/DFaturamentos/uploadModal?id=' + id, ajaxAction : action});

    },

    this.viewFiles = function(idCliente, moth, year, seqcontrato, hash){

        var objModal =  new modal();

        // define os parametros de consulta
        var params = "/" + idCliente + "/" + moth + "/" + year + "/" + seqcontrato  + "/" + hash;

        // cria view do upload
        objModal.modalAjax({title : 'Arquivos de Faturamento', url : '/DFaturamentos/viewFiles/' + params, ajaxAction : function(){}});

    },

    this.deleteFile = function(id, idCliente, hash){

        // define os parametros de consulta
        var params = "/" + id + "/" + idCliente + "/" + hash;

        if(confirm('Deseje excluir o arquivo?')){

            $("#modal-body-message").css('display', 'block');
            $("#modal-body-message").text("Excluindo arquivo...");

            $.ajax( {url    : BASE_URL + "DFaturamentos/deleteFile/" + params,
                async  : false,
                type    : "GET"})
                .done(function(jsonResponse) {

                    // TODO:: verificar retorno do json
                    // faz o parte do json
                    //var response = JSON.parse(jsonResponse);

                    $('#data-grid-' + id).remove();

                    $("#modal-body-message").css('display', 'none');

                }, id)
                .fail(function(e) {})
                .always(function() {});

        }

    },

    this.downloadFile = function(id, filenamesys, filename, hash){

        // define os parametros de consulta
        var params = "/" + id + "/" + filenamesys +  "/" + filename + "/" + hash;

        window.location = "DFaturamentos/downloadFile/" + params;

    }

}