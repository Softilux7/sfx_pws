<?php
App::uses('PwsAppController', 'Pws.Controller');
App::uses('Chamado', 'Pws.Model' );
App::uses('Cliente', 'Pws.Model' );

/**
 * Classe responsável pelo controle dos arquivo de demonstrativo de faturamentos
 *
 * @autor Gustavo Silva
 * @since 27/10/2017
 */
class DFaturamentosController extends PwsAppController
{
    public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow('downloadFile');

    }

    /**
     * Mostra o grid com os arquivos
     *
     * @autor Gustavo Silva
     * @since 27/10/2017
     */
    public function index(){

        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->Filter->addFilters('filter1');

        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->DFaturamnto->recursive = 0;

        if(in_array($auth_user_group['id'], array(1, 6))) {
            $paginate ['conditions'] = array($this->Filter->getConditions(), 'Empresa.id' => $this->verifyActiveCompany(), 'DFaturamento.status' => 1);
        }else{
            $paginate ['conditions'] = array($this->Filter->getConditions(), 'Cliente.CDCLIENTE' => $this->cdCliente,  'DFaturamento.status' => 1);
        }

        $paginate ['order'] = 'DFaturamento.id DESC';
        $paginate ['group'] = array('DFaturamento.id_fk_cliente', 'DFaturamento.seqcontrato', 'DFaturamento.mes', 'DFaturamento.ano');
        $paginate ['limit'] = 15;
        $paginate ['recursive'] = '0';
        $this->paginate = $paginate;

        $this->set('DFaturamento', $this->paginate());

    }

    /**
     * Método responsável pelo upload od arquivos
     *
     * @autor Gustavo Silva
     * @since 27/11/2017
     */
    public function uploadModal(){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        // verificase é um método POST
        if($this->request->is('POST')){

            // trata os dados do POST
            $jsonResult = $this->uploadModalPost($jsonResult);

        }else{

            // monta a tela
            $jsonResult->setContent($this->uploadModalView());

        }

        return $jsonResult->result();

    }

    /**
     * Verifica as empresas ativas e visiveis para o usuário
     * e retorna uma string com o id. ex: 1,2
     *
     * @autor Gustavo Silva
     * @since 20/12/2017
     */
    private function verifyActiveCompany(){

        // pega a/as empresa selecionadas
        return  is_array($this->empresa) ? $this->empresa : array($this->empresa);

    }

    /**
     * Método responsável por criar o view
     *
     * @autor Gustavo Silva
     * @since 27/12/2017
     */
    private function uploadModalView(){

        $arrEmpresa = array(0 => '--- SELECIONE ---');

        // pega a/as empresa selecionadas
        $idEmpresa = implode($this->verifyActiveCompany(), ",");

        // remontar o array para fazer a comparação dos dados
        $arrIdEmpresa = explode(",", $idEmpresa);

        // TODO:: veriricar se vai ser liberado todas empresa conforme selecionado
        // consulta na sessão as empresas
        foreach ($this->Session->read('auth_user')['Empresa'] as $key => $data){

            if(in_array($data['id'], $arrIdEmpresa)){

                // define as empresas que vão aparecer no combo
                $arrEmpresa[$data['id']] = $data['empresa_fantasia'];

            }

        }

        $moth = array(  0 => '--- SELECIONE ---',
                        1 => 'Janeiro', 2     => 'Fevereiro', 3 => 'Março',
                        4 => 'Abril', 5       => 'Maio', 6      => 'Junho',
                        7 => 'Julho', 8       => 'Agosto', 9    => 'Setembro',
                        10 => 'Outubro', 11   => 'Novembro', 12 => 'Dezembro');

        $year = array(0 => '--- SELECIONE ---',
                      date(Y) - 1   => date('Y') - 1,
                      date(Y)       => date('Y'),
                      date(Y) + 1   => date('Y') + 1);

        $view = new View($this);

        $view->set(compact('arrEmpresa', $arrEmpresa));
        $view->set(compact('moth', $moth));
        $view->set(compact('year', $year));

        return $view->render('view_upload_modal');

    }

    /**
     * Consulta os clientes da empresa
     *
     * @autor Gustavo Silva
     * @since 12/01/2018
     */
    public function selectCliente($idEmpresa){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        $data = $this->Cliente->find('all', array('conditions' => array('empresa_id' => $idEmpresa)));

        $arr = array();

        foreach ($data as $key => $value){

            $arr[$value['Cliente']['id']] = array('id' => $value['Cliente']['id'], 'name' => $value['Cliente']['FANTASIA']);

        }

        $jsonResult->setContent($arr);

        return $jsonResult->result();

    }

    /**
     * Consulta os clientes da empresa
     *
     * @autor Gustavo Silva
     * @since 12/01/2018
     */
    public function selectContrato($idCliente, $idEmpresa){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        $data = $this->Cliente->query("SELECT SEQCONTRATO
                                            FROM contratos
                                            WHERE CDCLIENTE = (SELECT CDCLIENTE FROM clientes WHERE id = {$idCliente} limit 1)
                                            AND empresa_id = {$idEmpresa}");

        $arr = array();

        foreach ($data as $key => $value){

            $arr[$value['contratos']['SEQCONTRATO']] = array('id' => $value['contratos']['SEQCONTRATO'], 'name' => $value['contratos']['SEQCONTRATO']);

        }

        $jsonResult->setContent($arr);

        return $jsonResult->result();

    }

    /**
     * Método responsável pelo action POST
     *
     * @autor Gustavo Silva
     * @since 27/12/2017
     */
    private function uploadModalPost($jsonResult){

        $files       = $_FILES['files'];
        // verifica o total de arquivos
        $amountFiles = isset($files['name']) ? count($files['name']) : 0;
        // define os dados do POST
        $request     = $this->request->data['Upload'];
        // tipos de arquivo permitidos
        $fAllowed    = array('application/pdf');

        if($request['idCliente']    <= 0){ $jsonResult->setError('Selecione o cliente'); }
        if($request['idMoth']       <= 0){ $jsonResult->setError('Selecione o mês'); }
        if($request['idYear']       <= 0){ $jsonResult->setError('Selecione o ano'); }
        if($request['idContrato']   <= 0){ $jsonResult->setError('Selecione um contrato'); }

        if($amountFiles > 0){

            $countError   = 0;
            $countWarning = 0;
            $arrWarning   = array();
            $countSuccess = 0;

            $objCliente = $this->Cliente->find('first', array('conditions' => array('Cliente.id' => $request['idCliente'])));

            if($request['sendemail'] == 1){

                // normalizados os emails
                $emails = $this->normalizeEmail($objCliente['Cliente']['EMAILCOBRANCA']);

            }

            for($i = 0; $i <= $amountFiles - 1; $i++){

                // verifica se exteção do arquivo é permitida
                if(in_array($files['type'][$i], $fAllowed)){

                    // cria um hash para renomear o arquivo
                    $nmFile = md5(date('YmdHis') . $this->empresa. $i) . ".pdf";

                    // define o caminho do arquivo com o novo nome; (PRODUÇÃO)
                    $pathFileProducao = $_SERVER['DOCUMENT_ROOT'] . "/pws/app/Plugin/Pws/files/upload/";
                    // densenvolvimento
                    $pathFileDev      = $_SERVER['DOCUMENT_ROOT'] . "/app/Plugin/Pws/files/upload/";
                    // caminho de upload
                    $pathFile         = file_exists($pathFileProducao) ?  $pathFileProducao : $pathFileDev;
                    // define o caminho e o nome do arquivo
                    $pathFile = $pathFile . $nmFile;

                    // verifica o tamanho do arquivo
                    if(move_uploaded_file($files['tmp_name'][$i], $pathFile)){

                        $dateUpload = date('Y-m-d H:i:s');
                        $idCliente  = $request['idCliente'];
                        $idMoht     = $request['idMoth'];
                        $idYear     = $request['idYear'];
                        $seqcontrato= $request['idContrato'];
                        $obs        = $request['obs'];
                        $nameFile   = $files['name'][$i];
                        $dataEmails = implode(";", $emails);

                        // grava os dados do arquivo no banco
                        $sql  = " INSERT INTO d_faturamentos";
                        $sql .= " (id_fk_cliente, mes, ano, seqcontrato, observacao, nome_arquivo, nome_arquivo_sistema, data_upload, emails)";
                        $sql .= " VALUES ('{$idCliente}', '{$idMoht}', '{$idYear}', '{$seqcontrato}', '{$obs}', '{$nameFile}', '{$nmFile}', '{$dateUpload}', '{$dataEmails}')";

                        $this->DFaturamento->query($sql);

                        $countSuccess++;

                    }else{

                        // não foi possível mover o arquivo
                        $jsonResult->setError(sprintf(" Não foi possível salvar o arquivo <strong><em>%s</em></strong>%s", $files['name'][$i], $pathFile));

                    }

                }else{

                    // arquivo no formato inválido
                    $arrWarning[$i] = sprintf(" O arquivo <strong><em>%s</em></strong> não é um formato válido", $files['name'][$i]);
                    $countWarning++;

                }

            }

        }else{

            $jsonResult->setError('Selecione um arquivo');

        }

        $sucess = sprintf("Arquivos importados com sucesso: <strong>%s</strong></br>", $countSuccess);

        $sucess .= sprintf("Arquivos com erro: <strong>%s</strong> <em>%s</em></br>", $countWarning, implode(",", $arrWarning));

        if($countSuccess > 0 and $request['sendemail'] == 1 and $jsonResult->hasError() == false){

            // busca os dados refente a empresa
            $sqlEmpresa  = $this->DFaturamento->query("SELECT email, empresa_fantasia FROM empresas WHERE id = {$objCliente['Cliente']['empresa_id']}");

            $emailEmpresa = $sqlEmpresa[0]['empresas']['email'];
            $nameEmpresa  = $sqlEmpresa[0]['empresas']['empresa_fantasia'];

            // monta o título do email
            $subject  = sprintf("({$nameEmpresa}) - Faturamento: %s/%s", $request['idMoth'],$request['idYear']);

            if(trim($objCliente['Cliente']['EMAILCOBRANCA']) != '' ) {

                $condition = array( 'DFaturamento.id_fk_cliente' => $idCliente,
                                    'DFaturamento.mes' => $idMoht,
                                    'DFaturamento.ano' => $idYear,
                                    'DFaturamento.seqcontrato' => $seqcontrato,
                                    'DFaturamento.status' => 1);

                $sqlFiles     = $this->DFaturamento->find('all', array('conditions' => $condition));
                $fileUpload[] = array();

                foreach ($sqlFiles as $key => $data){

                    // monta a url do arquivo
                    $url = sprintf("%s/%s/%s/%s",    $data['DFaturamento']['id'],
                                                            $data['DFaturamento']['nome_arquivo_sistema'],
                                                            $data['DFaturamento']['nome_arquivo'],
                                                            Security::hash($data['DFaturamento']['id'].$data['DFaturamento']['nome_arquivo_sistema']));

                    $fileUpload[] = array('name' => $data['DFaturamento']['nome_arquivo'], 'url' => $url);

                }

                // envia email para o cliente informando que os arquivos já estão disponíveis
                $this->sendEmailclient($emails, $subject, $fileUpload, $nameEmpresa, $emailEmpresa);

                $sucess .= sprintf("Enviado para os e-mails: <strong>%s</strong></br>", implode(";", $emails));

            }

            $jsonResult->setMensage('Sucesso', $sucess);
            $jsonResult->setClose(true);
        }

        return $jsonResult;

    }

    /**
     * Faz um tratamento para campos que possuiem mais de um email cadastrado
     *
     * @autor Gustavo Silva
     * @since 20/03/2018
     */
    private function normalizeEmail($data){

        // verifica primeiro com o delimitador ;
        $emails = explode(";", $data);

        if(count($emails) <= 1){

            // verifica com o delimitador ,
            $emails = explode(",", $data);

            if(count($emails) <= 1){

                // verifica com o delimitador espaço
                $emails = explode(" ", $data);

            }

        }

        $dataReturn = array();

        // verifica se e o email é valido
        foreach ($emails as $value => $key){

            if(filter_var(trim($key), FILTER_VALIDATE_EMAIL)){

                $dataReturn[] = trim($key);

            }

        }

        return $dataReturn;

    }

    /**
     * Método responsável por mostrar os arquivos de upload
     *
     * @autor Gustavo Silva
     * @since 10/01/2018
     */
    public function viewFiles($idCliente, $moth, $year, $seqcontrato, $hash){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        if($hash == Security::hash($idCliente.$moth.$year.$seqcontrato)) {

            $condition = array('DFaturamento.id_fk_cliente' => $idCliente,
                                'DFaturamento.mes' => $moth,
                                'DFaturamento.ano' => $year,
                                'DFaturamento.seqcontrato' => $seqcontrato,
                                'DFaturamento.status' => 1);

            $data = $this->DFaturamento->find('all', array('conditions' => $condition));

            $dataDetail = "select * from d_faturamento_details where id_fk_cliente = {$idCliente} and seqcontrato = {$seqcontrato} and mes = {$moth} and ano = {$year}";

            $view = new View($this);

            $view->set('arrData', $data);

            $jsonResult->setContent($view->render('view_files'));

        }else{

            $jsonResult->setMensage('Acesso negados', 'Informações inválidas');

        }

        return $jsonResult->result();

    }

    /**
     * Método responsável por excluir viurtal mente o arquivo
     *
     * @autor Gustavo Silva
     * @since 11/01/2018
     */
    public function deleteFile($id, $idCliente, $hash){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        if($hash == Security::hash($id.$idCliente)) {

            // muda o status do arquivo para 0
            $sql = "UPDATE d_faturamentos SET status = 0 WHERE id = {$id}";

            $this->DFaturamento->query($sql);

        }else{

            $jsonResult->setMensage('Acesso negados', 'Informações inválidas');

        }

        return $jsonResult->result();

    }

    /**
     * Método responsável por excluir viurtal mente o arquivo
     *
     * @autor Gustavo Silva
     * @since 11/01/2018
     */
    public function downloadFile($id, $filenamesys, $filename, $hash){

        $this->autoRender   = false;
        $this->layout       = false;

        // classe de retorno para ajax
        $jsonResult = new JsonResult();

        if($hash == Security::hash($id.$filenamesys)) {

            // define o caminho do arquivo com o novo nome; (PRODUÇÃO)
            $pathFileProducao = $_SERVER['DOCUMENT_ROOT'] . "/pws/app/Plugin/Pws/files/upload/";
            // densenvolvimento
            $pathFileDev      = $_SERVER['DOCUMENT_ROOT'] . "/app/Plugin/Pws/files/upload/";
            // caminho de upload
            $pathFile         = file_exists($pathFileProducao) ?  $pathFileProducao : $pathFileDev;
            // define o caminho e o nome do arquivo para upload
            $pathFile = $pathFile . $filenamesys;

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($filename)));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($pathFile));
            ob_clean();
            flush();

            readfile($pathFile);
            exit;

        }else{

            echo "Acesso negado";

        }

    }

    /**
     * envia email para o cliente informando que os arquivos ja estão no sistema
     *
     * @autor Gustavo Silva
     * @since 22/01/2018
     */
    private function sendEmailclient($to, $subject, $data, $nameEmpresa, $replyTo = null){

        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');

        $Setting    = new Setting ();
        $auth_user  = $this->Session->read('auth_user');
        $general    = $Setting->find('first', array( 'conditions' => array( 'setting_key' => sha1('general'))));

        if (!empty ($general)) {
            $general = unserialize($general ['Setting'] ['setting_value']);
        }

        $email = new CakeEmail ();

        $email->addTo($to);
        $email->replyTo($replyTo);
        $email->config('default');
        $email->emailFormat('html');

        $email->from(array($general ['Setting'] ['email_address'] => __('Pws - Portal Web')));
        $email->subject($subject);

        $email->template('dfaturamento', 'dfaturamento');
        $email->viewVars(array('data' => $data, 'nameEmpresa' => $nameEmpresa));

        return $email->send();

    }
}