<?php

class AutenticacaoController extends Zend_Controller_Action {

    
    public function indexAction()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $form = new Application_Form_Login();
        $this->view->form = $form;
        
        if ( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            if ( $form->isValid($data) ) {
                $no_usuario = $form->getValue('no_usuario');
                $ds_senha = $form->getValue('ds_senha');

                //Obter o objeto do adaptador para autenticar usando banco de dados
                $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                
                //Seta qual tabela e colunas procurar o usuário
                $authAdapter->setTableName('tb_usuario')
                    ->setIdentityColumn('no_usuario')
                    ->setCredentialColumn('ds_senha')
                    ->setCredentialTreatment('MD5(?)');

                //Seta as credenciais com dados vindos do formulário de login
                $authAdapter->setIdentity($no_usuario)->setCredential($ds_senha);
               
                $auth = Zend_Auth::getInstance();
                
                //Realiza autenticação
                $result = $auth->authenticate($authAdapter);
                
                //Verifica se a autenticação foi válida
                if ( $result->isValid() ) {
                    
                    //Obtém dados do usuário
                    $info = $authAdapter->getResultRowObject(null, 'ds_senha');
                    
                    //Armazena seus dados na sessão
                    $storage = Zend_Auth::getInstance()->getStorage();
                    $storage->write($info);
                 
                    //Redireciona para o Controller protegido
                    return $this->_helper->redirector->goToRoute( array('controller' => 'painel'), null, true);
                }else{
                    $this->_redirect('autenticacao/falha');
                }
            }else {
                $form->populate($data);
            }
            
       
        }
    }

    //Erro na Autenticação
    public function falhaAction()
    {
        
    }
}
  

