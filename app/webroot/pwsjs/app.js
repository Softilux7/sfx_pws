// /**
//  * Classe responsável pelas modais
//  *
//  * @author Gustavo Silva
//  * @since 23/10/2017
//  */
// function modal() {
//   (this.mensage = function (dataTitle, dataContent) {
//     //TODO:: passar os parametros
//     this.__content({ title: dataTitle, content: dataContent });
//   }),
//     /**
//      * Monta o conteúdo da janela
//      *
//      * @autor Gustavo Silva
//      * @since 20/10/2017
//      *
//      */
//     (this.__content = function (data) {
//       $("#exampleModal")
//         .on(
//           "show",
//           $.proxy(function (event) {
//             var button = $(event.relatedTarget);
//             var recipient = button.data("whatever");
//             var modal = $(this);

//             $(".modal-title").text(data.title);
//             $("#content-data-modal").empty();
//             $("#content-data-modal").append(data.content);
//           }, data)
//         )
//         .on("hidden", function () {
//           $("#buttonActionModal").css("display", "none");
//         });

//       $("#exampleModal").modal();
//     }),
//     (this.modalAlert = function (title, content, type) {
//       if (type != undefined) {
//         if (type == "error")
//           $("#modalAlert modal-header").css("background", "#cc0000");
//         if (type == "warning")
//           $("#modalAlert modal-header").css("background", "#cc0000");
//       }

//       $("#modalAlert")
//         .on(
//           "show",
//           $.proxy(function (event) {
//             var button = $(event.relatedTarget);
//             var recipient = button.data("whatever");
//             var modal = $(this);

//             $("#modalAlertLabel").text(title);
//             $("#content-data-modalAlert").empty();
//             $("#content-data-modalAlert").append(content);

//             $(".modal-backdrop").css("z-index", "1080");
//           })
//         )
//         .on("hidden", function () {
//           $(".modal-backdrop").css("z-index", "1040");
//         });

//       $("#modalAlert").modal();
//     }),
//     /**
//      * Carrega uma janela ajax e monta uma view
//      *
//      * @autor Gustavo Silva
//      * @since 20/10/17
//      */
//     (this.modalAjax = function (json) {
//       var param = "";

//       var objModal = new modal();

//       // monta a janela com a VIEW
//       objModal.mensage(json.title, "Carregando...");

//       $.ajax({ url: BASE_URL + json.url, async: false, type: "GET" })
//         .done(function (jsonResponse) {
//           // faz o parte do json
//           var response = JSON.parse(jsonResponse);

//           // monta a janela com a VIEW
//           objModal.mensage(json.title, response.content);

//           // chama o método que faz o tratamento dos dados
//           objModal.modalHandleAjax(jsonResponse, json.ajaxAction);
//         }, json)
//         .fail(function (e) {
//           // remove a máscara
//           objModal.loadingModal(false);
//           // seta mensage na tela
//           objModal.mensage("Erro", "Erro inesperado");
//         })
//         .always(function () {});
//     }),
//     /**
//      * Método responsável por tratar de post de arquivo via Ajax
//      *
//      * @author Gustavo Silva
//      * @since 17/12/2017
//      */
//     (this.modalPostFilesAjax = function () {
//       var objModal = new modal();

//       $("form").ajaxForm({
//         resetForm: false,
//         beforeSend: function () {
//           $("#progressBar")
//             .css("width", 0 + "%")
//             .attr("aria-valuenow", 0)
//             .text(0 + "%");
//         },
//         uploadProgress: function (event, position, total, percentComplete) {
//           var percent = Math.round((position / total) * 100) - 1;

//           // animação progressbar
//           $("#progressBar")
//             .css("width", percent + "%")
//             .attr("aria-valuenow", percent)
//             .text(percent + "%");
//         },
//         success: function (response) {
//           // animação progressbar
//           $("#progressBar")
//             .css("width", "100%")
//             .attr("aria-valuenow", 100)
//             .text("100%");

//           objModal.modalHandleAjax(response, function () {});
//         },
//         complete: function (xhr) {},
//       });
//     }),
//     /**
//      * Responsável por tratar os dados vindos de uma requisição ajax
//      * O método trata as mensagens e ações de GET e POST
//      *
//      * @autor Gustavo Silva
//      * @since 17/12/2017
//      *
//      * @param jsonResponse dados que são enviados pelo PHP
//      * @param action método enviado via Javascript para executar uma ação
//      */
//     (this.modalHandleAjax = function (jsonResponse, action) {
//       var objModal = new modal();

//       // faz o parte do json
//       var response = JSON.parse(jsonResponse);

//       // executa a função e retorna a resposta
//       var callback = eval.call(null, "(" + action + "(" + jsonResponse + "))");

//       // remove a máscara
//       objModal.loadingModal(false);

//       // verifica se possui algum erro de tela
//       if (response.error != null) {
//         // seta a mensagem de erro
//         objModal.modalAlert(response.error.title, response.error.data, "error");
//       }

//       // verifica se possui algum warning de tela
//       if (response.warning != null) {
//         // seta a mensagem de warning
//         objModal.modalAlert(
//           response.warning.title,
//           response.warning.data,
//           "warning"
//         );
//       }

//       // verifica se é para fechar a janela
//       if (response.close == true) {
//         $("#exampleModal").modal("hide");
//       }

//       // verifica se possui alguma mensagem para mostrar na tela
//       if (response.mensage != null) {
//         // seta mensage na tela
//         objModal.modalAlert(
//           response.mensage.title,
//           response.mensage.data,
//           "sucess"
//         );
//       }

//       // verificar se é para redicionar todo::
//     }),
//     /**
//      * Cria a máscara de loagind modal
//      *
//      * @author Gustavo Silva
//      * @since 23/10/2017
//      */
//     (this.loadingModal = function (status) {
//       var data = "";

//       if (status == false) {
//         $("#loadingModal").modal("hide");
//       } else {
//         $("#loadingModal").modal({ keyboard: false });

//         // animação progressbar
//         $("#progressBar")
//           .css("width", "50%")
//           .attr("aria-valuenow", 50)
//           .text("50% Complete");

//         var current_progress = 50;
//         var interval = setInterval(function () {
//           current_progress += 10;
//           $("#progressBar")
//             .css("width", current_progress + "%")
//             .attr("aria-valuenow", current_progress)
//             .text(current_progress + "% Complete");
//           if (current_progress >= 100) clearInterval(interval);
//         }, 400);
//       }
//     });

//   /**
//    * Cria notificações no sistema
//    *
//    * @author Gustavo Silva
//    * @since 23/10/2017
//    *
//    * @param message
//    * @param type
//    */
//   this.notify = function (message, type) {
//     var html =
//       '<div class="alert alert-' + type + ' alert-dismissable page-alert">';
//     html +=
//       '<button type="button" class="close"><span aria-hidden="true">×</span></button>';
//     html += message;
//     html += "</div>";
//     $(html).hide().prependTo("#barNotify").slideDown();

//     $(".page-alert .close").click(function (e) {
//       e.preventDefault();
//       $(this).closest(".page-alert").slideUp();
//     });
//   };
// }

// function actionForm() {
//   (this.__contruct = function () {}),
//     (this.post = function (action) {
//       //id form
//       // TODO:: se passar o id ele faz pelo id do fomr passado
//       // TODO:: POST via ajax

//       var objThis = this;

//       $("#submitForm").click(function () {
//         var url = $("#submitForm").context.URL;

//         return objThis.handleAjax({ ajaxUrl: url, ajaxAction: action });
//       });
//     }),
//     /**
//      * Método responsável por fazer uma requisição ajax
//      *
//      * @author Gustavo Silva
//      * @since 23/10/2017
//      * @param json
//      */
//     (this.handleAjax = function (json) {
//       // habilita máscara na tela
//       var objModal = new modal();
//       objModal.loadingModal();

//       // serealiza os parametros do post
//       var param = $(".form-horizontal").serialize();

//       $.ajax({ url: json.ajaxUrl, async: false, data: param, type: "POST" })
//         .done(function (jsonResponse) {
//           // faz o parte do json
//           var response = JSON.parse(jsonResponse);

//           // executa a função e retorna a resposta
//           // TODO:: COLOCAR O RETORNO PARA SER TRATADO NO FORM
//           var callback = eval.call(
//             null,
//             "(" + json.ajaxAction + "(" + jsonResponse + "))"
//           );

//           // remove a máscara
//           objModal.loadingModal(false);

//           // verifica se possui algum erro de tela
//           if (response.error != null) {
//             // seta a mensagem de erro
//             objModal.mensage(response.error.title, response.error.data);
//           }

//           // verifica se possui alguma mensagem para mostrar na tela
//           if (response.mensage != null) {
//             // seta mensage na tela
//             objModal.mensage(response.mensage.title, response.mensage.data);
//           }

//           // verificar se é para redicionar
//         }, json)
//         .fail(function () {
//           // remove a máscara
//           objModal.loadingModal(false);
//           // seta mensage na tela
//           objModal.mensage("Erro", "Erro inesperado na execução");
//         })
//         .always(function () {});
//     });
// }

// function view() {
//   this.__contruct = function (action) {
//     try {
//       // classe responsável pelo post
//       var objActionForm = new actionForm();
//       objActionForm.post(action);
//     } catch (e) {
//       alert(e);
//     }

//     try {
//       $('[data-toggle="popover"]').popover();
//     } catch (e) {
//       alert(e);
//     }

//     try {
//       $('[data-toggle="tooltip"]').tooltip();
//     } catch (e) {
//       alert(e);
//     }
//   };
// }

// function loadFileJs() {
//   /**
//    * Carrega arquivo js e css e executa uma ação após carregar
//    * @author Gustavo Silva
//    * @since 23/10/2017
//    *
//    * @param {type} urlJs
//    * @param {type} urlCss
//    * @param {type} action
//    * @returns void
//    */
//   this.load = function (urlJs, action) {
//     // carrega o arquivo
//     code = document.createElement("script");
//     code.src = urlJs;
//     document.head.appendChild(code);

//     jQuery
//       .getScript(urlJs)
//       .done(function (e) {
//         eval.call(null, "(" + action + "())");
//       })
//       .fail(function (e) {
//         console.log("Não foi possível instanciar a classe" + e);
//       });
//   };
// }

/**
 * Classe responsável pelas modais
 *
 * @author Gustavo Silva
 * @since 23/10/2017
 */
function modal() {
  (this.mensage = function (dataTitle, dataContent, size) {
    //TODO:: passar os parametros
    this.__content({ title: dataTitle, content: dataContent, size: size });
  }),
    /**
     * Monta o conteúdo da janela
     *
     * @autor Gustavo Silva
     * @since 20/10/2017
     *
     */
    (this.__content = function (data) {
      // REFATORAR PARA INCLUIR QUALQUER CLASSE
      if (data.size == undefined) {
        $("#exampleModal").removeClass("modal2");
        $("#exampleModal").addClass("modal");
      } else {
        $("#exampleModal").removeClass("modal");
        $("#exampleModal").addClass("modal2");
      }

      $("#exampleModal")
        .on(
          "show",
          $.proxy(function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data("whatever");
            var modal = $(this);

            $(".modal-title").text(data.title);
            $("#content-data-modal").empty();
            $("#content-data-modal").append(data.content);
          }, data)
        )
        .on("hidden", function () {
          $("#buttonActionModal").css("display", "none");
        });

      $("#exampleModal").modal();
    }),
    (this.modalAlert = function (title, content, type) {
      if (type != undefined) {
        if (type == "error")
          $("#modalAlert modal-header").css("background", "#cc0000");
        if (type == "warning")
          $("#modalAlert modal-header").css("background", "#cc0000");
      }

      $("#modalAlert")
        .on(
          "show",
          $.proxy(function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data("whatever");
            var modal = $(this);

            $("#modalAlertLabel").text(title);
            $("#content-data-modalAlert").empty();
            $("#content-data-modalAlert").append(content);

            $(".modal-backdrop").css("z-index", "1080");
          })
        )
        .on("hidden", function () {
          $(".modal-backdrop").css("z-index", "1040");
        });

      $("#modalAlert").modal();
    }),
    /**
     * Carrega uma janela ajax e monta uma view
     *
     * @autor Gustavo Silva
     * @since 20/10/17
     */
    (this.modalAjax = function (json) {
      var param = "";

      var objModal = new modal();

      // monta a janela com a VIEW
      objModal.mensage(json.title, "Carregando...");

      $.ajax({ url: BASE_URL + json.url, async: false, type: "GET" })
        .done(function (jsonResponse) {
          // faz o parte do json
          var response = JSON.parse(jsonResponse);

          // monta a janela com a VIEW
          objModal.mensage(json.title, response.content, json.size);

          // chama o método que faz o tratamento dos dados
          objModal.modalHandleAjax(jsonResponse, json.ajaxAction);
        }, json)
        .fail(function (e) {
          // remove a máscara
          objModal.loadingModal(false);
          // seta mensage na tela
          objModal.mensage("Erro", "Erro inesperado");
        })
        .always(function () {});
    }),
    /**
     * Método responsável por tratar de post de arquivo via Ajax
     *
     * @author Gustavo Silva
     * @since 17/12/2017
     */
    (this.modalPostFilesAjax = function () {
      var objModal = new modal();

      $("form").ajaxForm({
        resetForm: false,
        beforeSend: function () {
          $("#progressBar")
            .css("width", 0 + "%")
            .attr("aria-valuenow", 0)
            .text(0 + "%");
        },
        uploadProgress: function (event, position, total, percentComplete) {
          var percent = Math.round((position / total) * 100) - 1;

          // animação progressbar
          $("#progressBar")
            .css("width", percent + "%")
            .attr("aria-valuenow", percent)
            .text(percent + "%");
        },
        success: function (response) {
          // animação progressbar
          $("#progressBar")
            .css("width", "100%")
            .attr("aria-valuenow", 100)
            .text("100%");

          objModal.modalHandleAjax(response, function () {});
        },
        complete: function (xhr) {},
      });
    }),
    /**
     * Responsável por tratar os dados vindos de uma requisição ajax
     * O método trata as mensagens e ações de GET e POST
     *
     * @autor Gustavo Silva
     * @since 17/12/2017
     *
     * @param jsonResponse dados que são enviados pelo PHP
     * @param action método enviado via Javascript para executar uma ação
     */
    (this.modalHandleAjax = function (jsonResponse, action) {
      var objModal = new modal();

      // faz o parte do json
      var response = JSON.parse(jsonResponse);

      // executa a função e retorna a resposta
      var callback = eval.call(null, "(" + action + "(" + jsonResponse + "))");

      // remove a máscara
      objModal.loadingModal(false);

      // verifica se possui algum erro de tela
      if (response.error != null) {
        // seta a mensagem de erro
        objModal.modalAlert(response.error.title, response.error.data, "error");
      }

      // verifica se possui algum warning de tela
      if (response.warning != null) {
        // seta a mensagem de warning
        objModal.modalAlert(
          response.warning.title,
          response.warning.data,
          "warning"
        );
      }

      // verifica se é para fechar a janela
      if (response.close == true) {
        $("#exampleModal").modal("hide");
      }

      // verifica se possui alguma mensagem para mostrar na tela
      if (response.mensage != null) {
        // seta mensage na tela
        objModal.modalAlert(
          response.mensage.title,
          response.mensage.data,
          "sucess"
        );
      }

      // verificar se é para redicionar todo::
    }),
    /**
     * Cria a máscara de loagind modal
     *
     * @author Gustavo Silva
     * @since 23/10/2017
     */
    (this.loadingModal = function (status) {
      var data = "";

      if (status == false) {
        $("#loadingModal").modal("hide");
      } else {
        $("#loadingModal").modal({ keyboard: false });

        // animação progressbar
        $("#progressBar")
          .css("width", "50%")
          .attr("aria-valuenow", 50)
          .text("50% Complete");

        var current_progress = 50;
        var interval = setInterval(function () {
          current_progress += 10;
          $("#progressBar")
            .css("width", current_progress + "%")
            .attr("aria-valuenow", current_progress)
            .text(current_progress + "% Complete");
          if (current_progress >= 100) clearInterval(interval);
        }, 400);
      }
    });

  /**
   * Cria notificações no sistema
   *
   * @author Gustavo Silva
   * @since 23/10/2017
   *
   * @param message
   * @param type
   */
  this.notify = function (message, type) {
    var html =
      '<div class="alert alert-' + type + ' alert-dismissable page-alert">';
    html +=
      '<button type="button" class="close"><span aria-hidden="true">×</span></button>';
    html += message;
    html += "</div>";
    $(html).hide().prependTo("#barNotify").slideDown();

    $(".page-alert .close").click(function (e) {
      e.preventDefault();
      $(this).closest(".page-alert").slideUp();
    });
  };
}

function actionForm() {
  (this.__contruct = function () {}),
    (this.post = function (action) {
      //id form
      // TODO:: se passar o id ele faz pelo id do fomr passado
      // TODO:: POST via ajax

      var objThis = this;

      $("#submitForm").click(function () {
        var url = $("#submitForm").context.URL;

        return objThis.handleAjax({ ajaxUrl: url, ajaxAction: action });
      });
    }),
    /**
     * Método responsável por fazer uma requisição ajax
     *
     * @author Gustavo Silva
     * @since 23/10/2017
     * @param json
     */
    (this.handleAjax = function (json) {
      // habilita máscara na tela
      var objModal = new modal();
      objModal.loadingModal();

      // serealiza os parametros do post
      var param = $(".form-horizontal").serialize();

      $.ajax({ url: json.ajaxUrl, async: false, data: param, type: "POST" })
        .done(function (jsonResponse) {
          // faz o parte do json
          var response = JSON.parse(jsonResponse);

          // executa a função e retorna a resposta
          // TODO:: COLOCAR O RETORNO PARA SER TRATADO NO FORM
          var callback = eval.call(
            null,
            "(" + json.ajaxAction + "(" + jsonResponse + "))"
          );

          // remove a máscara
          objModal.loadingModal(false);

          // verifica se possui algum erro de tela
          if (response.error != null) {
            // seta a mensagem de erro
            objModal.mensage(response.error.title, response.error.data);
          }

          // verifica se possui alguma mensagem para mostrar na tela
          if (response.mensage != null) {
            // seta mensage na tela
            objModal.mensage(response.mensage.title, response.mensage.data);
          }

          // verificar se é para redicionar
        }, json)
        .fail(function () {
          // remove a máscara
          objModal.loadingModal(false);
          // seta mensage na tela
          objModal.mensage("Erro", "Erro inesperado na execução");
        })
        .always(function () {});
    });
}

function view() {
  this.__contruct = function (action) {
    try {
      // classe responsável pelo post
      var objActionForm = new actionForm();
      objActionForm.post(action);
    } catch (e) {
      alert(e);
    }

    try {
      $('[data-toggle="popover"]').popover();
    } catch (e) {
      alert(e);
    }

    try {
      $('[data-toggle="tooltip"]').tooltip();
    } catch (e) {
      alert(e);
    }
  };
}

function loadFileJs() {
  /**
   * Carrega arquivo js e css e executa uma ação após carregar
   * @author Gustavo Silva
   * @since 23/10/2017
   *
   * @param {type} urlJs
   * @param {type} urlCss
   * @param {type} action
   * @returns void
   */
  this.load = function (urlJs, action) {
    // carrega o arquivo
    code = document.createElement("script");
    code.src = urlJs;
    document.head.appendChild(code);

    jQuery
      .getScript(urlJs)
      .done(function (e) {
        eval.call(null, "(" + action + "())");
      })
      .fail(function (e) {
        console.log("Não foi possível instanciar a classe" + e);
      });
  };
}
