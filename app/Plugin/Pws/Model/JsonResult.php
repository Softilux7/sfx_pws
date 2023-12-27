<?php
/**
 * Retorno padrão de json para o sistema
 *
 * @autor Gustavo Silva
 * @since: 24/10/17
 */

class JsonResult {

    private $content;

    private $mensage    = null;

    private $error      = array();

    private $warning    = array();

    private $notify     = null;

    private $redirect   = null;

    private $close      = false;

    /**
     * Retorno em json
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     *
     * @return JSON
     */
    public function result(){

        return json_encode(array(   'content'   => $this->content,
                                    'mensage'   => $this->mensage,
                                    'error'     => $this->rederToHtml($this->error),
                                    'warning'   => $this->rederToHtml($this->warning),
                                    'notify'    => $this->notify,
                                    'redirect'  => $this->redirect,
                                    'close'     => $this->close));

    }

    /**
     * Seta o valor do conteúdo que será exibido
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     */
    public function setContent($data = ''){

        $this->content = $data;

    }

    /**
     * Seta mensagens
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     *
     * @param $title
     * @param $data
     */
    public function setMensage($title, $data){

        $this->mensage = array('title' => $title, 'data' => $data);

    }

    /**
     * Seta os erros
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     *
     * @param $title
     * @param $data
     */
    public function setError($data, $title = 'Erro'){

        $this->error[] = array('title' => $title, 'data' => $data);

    }

    /**
     * Seta os warning
     *
     * @autor Gustavo Silva
     * @since 20/12/2017
     *
     * @param $title
     * @param $data
     */
    public function setWarning($data, $title = 'Warning'){

        $this->warning[] = array('title' => $title, 'data' => $data);

    }

    /**
     * Renderiza para o html
     *
     * @autor Gustavo Silva
     * @since 25/10/2017
     *
     * @param $data
     * @return array
     *
     */
    private function rederToHtml($data){

        $return = '';
        $title  = '';

        foreach ($data as $i => $k){

            $return .= "<div>" . $k['data']."</div>";
            $title   = $k['title'];

        }

        if($return != '') {
            return array('title' => $title, 'data' => $return);
        }else{
            return null;
        }

    }

    /**
     * Retorn se possui algum erro setado
     *
     * @autor Gustavo Silva
     * @since 25/10/2017
     *
     * @return boolean
     */
    public function hasError(){

        return count($this->error) > 0 ? true : false;

    }

    /**
     * Retorn se possui algum warning setado
     *
     * @autor Gustavo Silva
     * @since 20/12/2017
     *
     * @return boolean
     */
    public function hasWarning(){

        return count($this->warning) > 0 ? true : false;

    }

    /**
     * Seta os tipos de alert
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     *
     * @param $type
     * @param $data
     */
    public function setNotify($type, $data, $time = 100){

        $this->notify[] = array('type' => $type, 'data' => $data, 'time' => $time);

    }

    /**
     * Seta o um redirect de página
     *
     * @autor Gustavo Silva
     * @since 24/10/2017
     *
     * @param $url
     * @param $time
     */
    public function setRedirect($url, $time = 100){

        $this->redirect = array('url' => $url, 'time' => $time);

    }

    /**
     * Seta para fechar a janela
     *
     * @autor Gustavo Silva
     * @since 12/01/2018
     *
     * @param $url
     * @param $time
     */
    public function setClose($status = false){

        $this->close = $status;

    }

}