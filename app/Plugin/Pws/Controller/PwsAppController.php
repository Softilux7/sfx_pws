<?php
App::uses('AdminController', 'Controller');
App::uses('JsonResult', 'Pws.Model');

class PwsAppController extends AdminController {
    
    /**
     * Verifica se estão todas empresa visíveis ou não
     * 
     * @autor Gustavo Silva
     * @since 28/09/2019
     * int (-1 para todas)
     */
    public function AllActiveCompany(){
        
        return is_array($this->empresa) ? -1 : $this->empresa;
        
    }
    
    /**
     * Verifica as empresas ativas e visiveis para o usuário
     * e retorna uma string com o id. ex: 1,2
     *
     * @autor Gustavo Silva
     * @since 28/09/2019
     * @return 1,2 etc...
     */
    public function getActiveCompany(){

        // pega a/as empresa selecionadas
        $data =  is_array($this->empresa) ? $this->empresa : array($this->empresa);
        
        return implode(",", $data);

    }
    
    /**
     * Pega da sessão as informações de uma determindada empresa e retorna null caso não encontre
     * 
     * @autor Gustavo Silva
     * @since 28/09/2019
     * @param type $id
     * @return array
     */
    public function getInfoCompany($id){
        
        $return = null;
        
        foreach ($this->Session->read('auth_user')['Empresa'] as $key => $data){
            
            if($data['id'] == $id){

               $return =  $data;
               
               break;

            }

        }
        
        return $return;

    }
    
    /**
     * Retorna um array com todas as empresas visíveis ao usuário ativo
     * 
     * @autor Gustavo Silva
     * @since 29/09/2019
     * @return array
     */
    public function getAllCompany(){
        
        return $this->Session->read('auth_user')['Empresa'];
        
    }

}

