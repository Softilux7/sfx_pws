/**
 * Classe Javascript de incialização dos módulo do sistema
 *
 * @autor Gustavo Silva
 * @since 20/10/2017
 *
 */
function init() {
  /**
   * Método responsável por chamar a classe javascript
   *
   * @param className
   * @private
   */
  this.__construct = function (className) {
    this.FrontController(className);
  };

  /**
   * Inclui o arquivo Javascript e invoca o método
   *
   * @param className
   * @param methodName
   * @constructor
   */
  this.FrontController = function (className, methodName) {
    try {
      // carrega o arquivo
      code = document.createElement("script");
      code.src =
        "/pws/app/webroot/pwsjs/" +
        className +
        ".js?v=" +
        Math.floor(Math.random() * 10000 + 1);
      document.head.appendChild(code);

      // após carregar o arquivo, será instaciado a classe e chamado o método
      jQuery
        .getScript("/pws/app/webroot/pwsjs/" + className + ".js")
        .done(function (e) {
          if (methodName === undefined) {
            methodName = "__construct";
          }

          // invoca o método
          eval("new " + className + "()." + methodName + "()");
        })
        .fail(function (e) {
          console.log("Não foi possível instanciar a classe" + e);
        });
    } catch (e) {
      console.log("Não foi possível carregar o arquivo js" + e);
    }
  };
}
