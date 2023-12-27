/**
 * Classe responsável pela classe php Chamado
 *
 * @autor Gustavo Silva
 * @since 20/10/17
 */
function chamado(){

    this.__construct = function () {

        this.index();

    },

    /**
     * Método inicializa por Padrão
     *
     * @author Gustavo Silva
     * @since 23/10/2017
     */
    this.index = function(){

        $('#tabAvaliacao a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        /**
         * método para tratamento de retorno do ajax
         *
         * response: é o retorno dos dados do ajax
         * callback: devolve para a classe form para tratar parametros
         */
        var action = function(jsonResponse) {

            // se não tiver erro ele direciona para o login
            if (jsonResponse.error == null){

                var json = jsonResponse;

                $('#buttonCloseModal').click(function() {

                    // redireciona
                    window.location.href = json.redirect.url;

                });

            }

            var callback ='';

            return callback;

        }

        // classe responsável pelo view
        var objView = new view();
        objView.__contruct(action);

        // elemento de avaliação
        this.__rating();

    }

    /**
     * Método responsável por criar o componente de avaliação
     *
     * @author Gustavo Silva
     * @since 23/10/2017
     * @private
     */
    this.__rating = function(){

        /**
         *   @autor Gustavo Silva
         *   validação da avaliação de atendimento
         */
        $('.rate-avaliacao li').click(function(e){

            // limpas as classes ativas
            $('.rate-avaliacao li').each(function(){
                $(this).removeClass("rate-avaliacao-active");
            });

            // valor do elemento
            var value = e.currentTarget.id;

            // seta o id para o hidden
            $('#avaliacaoScore').val(value);

            // adiciona a classe ativa
            $(this).addClass("rate-avaliacao-active");


        });

        /**
         *   @autor Gustavo Silva
         *   validação
         */
        $('#avaliacaoIdResolvido').click(function(e){

            // valor do elemento
            var value = $(this).val();

            if(value != 0) {
                // remove a mascara
                $('.mask-score').css('display', 'none');
            }else if(value == '0'){
                // remove a mascara
                $('.mask-score').css('display', 'block');
            }

            // esconde o elemento texarea
            $('#resolvidoStatus').css('display', 'none');

            if(value != 1 && value != 0){

                // habilita o elemento textarea
                $('#resolvidoStatus').css('display', 'block');

            }

        });

    }

}

new chamado().__construct();