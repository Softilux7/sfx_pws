<?php
App::uses('PwsAppModel', 'Pws.Model');
App::uses('BrValidation', 'Localized.Validation');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeSession', 'Model/Datasource');

/**
 * Solicitacao Model
 *
 * @property Solicitacao $Solicitacao
 */
class Solicitacao extends PwsAppModel
{

   var $useTable = 'solicitacoes';

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Equipamento' => array(
            'className' => 'Pws.Equipamento',
            'foreignKey' => false,
            'conditions' => array(
                'Solicitacao.equipamento_id = Equipamento.cdequipamento',
                'Solicitacao.ID_BASE = Equipamento.ID_BASE',
            ),
            'fields' => '',
            'order' => ''
        ),
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'Solicitacao.cliente_id = Cliente.cdcliente',
                'Solicitacao.ID_BASE = Cliente.ID_BASE',
            ),
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */

    public $hasMany = array(
        'SolicitacaoSuprimento' => array(
            'className' => 'SolicitacaoSuprimento',
            'foreignKey' => 'solicitacao_id'
        )
    );


//    /**
//     * Verifica se foi salvo o registro e dispara os emails
//     * @autor Wagner Martins
//     */
//
//    public function afterSave($created, $options = [])
//    {
//        parent::afterSave($created, $options);
//        if ($created === true) {
//            $solicitacao = $this->findById($this->id);
//
//
//            // Get all users with an email address.
//            $emails = ClassRegistry::init('User')->find(
//                'all',
//                array(
//                    'fields' => array(
//                        'User.user_email'
//                    ),
//                    'contain' => array(
//                        '_UsersTpemail',
//                        '_Tpemail'
//                    ),
//                    'conditions' => array(
//                        '_Tpemail.id' => 2 // Tipo solicitação de suprimentos
//                    )
//                )
//            );
//            // Lista os suprimentos solicitados
//            $suprimentos = ClassRegistry::init('SolicitacaoSuprimento')->find('all', array('conditions' => array('solicitacao_id' => $this->id)));
//
//
//            // Inicio envio de email
//            $enviado = 0;
//            //forech usuários
//            foreach ($emails as $tpemail) {
//                if (self::enviaEmail($tpemail['User']['user_email'], 'Solicitação de Suprimento Nº ' . $this->id, $solicitacao, $this->id, $suprimentos)) {
//                    $enviado++;
//                }
//            }
//            // envio de email copia do cliente
//            if ($enviado > 0) {
//                self::enviaEmail($solicitacao['Solicitacao']['email'], 'Solicitação de Suprimento Nº ' . $this->id, $solicitacao, $this->id, $suprimentos);
//            }
//
//        }
//    }
//
//
//    /**
//     * Enviar email
//     * @autor Wagner Martins
//     */
//
//    private function enviaEmail($to = null, $subject = null, $dados, $numero, $suprimentos)
//    {
//        $auth_user = CakeSession::read('auth_user');
//
//        $general = ClassRegistry::init('AuthAcl.Setting')->find('first', array(
//            'conditions' => array(
//                'setting_key' => sha1('general')
//            )
//        ));
//        if (!empty ($general)) {
//            $general = unserialize($general ['Setting'] ['setting_value']);
//        }
//
//        $email = new CakeEmail ();
//
//        $email->addTo($to);
//        $email->config('default');
//        $email->emailFormat('html');
//        $email->template('suprimento', 'suprimento');
//
//        $email->from(array(
//            $general ['Setting'] ['email_address'] => __('Portal Web')
//        ));
//        $email->subject($subject);
//
//
//        $email->viewVars(array('solicitacao' => $dados, 'numero' => $numero, 'suprimentos' => $suprimentos, 'auth_user' => $auth_user));
//        try {
//            return $email->send();
//        } catch (Exception $exception) {
//            $this->log($exception);
//        }
//
//    }


}
