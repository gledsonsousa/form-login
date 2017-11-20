<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        /*
         * Definições do formulário
         */
        $this->setName('login');
        $this->setMethod('post');
        $this->setAttrib('id', 'login');
        
        $no_usuario = new Nasp_Form_Element_Text('no_usuario');
        $no_usuario->setLabel('Usuário')
            ->setAttrib('class', 'col-sm-7')
            ->setRequired(true);
        
        $ds_senha = new Nasp_Form_Element_Password('ds_senha');
        $ds_senha->setLabel('Senha')
            ->setAttrib('class', 'col-sm-7')
            ->setRequired(true);
        
        $entrar = new Nasp_Form_Element_Submit('entrar');
        $entrar->setLabel('Entrar')
            ->setAttrib('class', 'btn btn-md btn-success ');
        
        $this->addElements(array(
            $no_usuario,
            $ds_senha,
            $entrar
        ));
        
        $this->addDisplayGroup(array(
            'no_usuario',
            'ds_senha',
        ),  'dadosLogin');
        
        $this->addDisplayGroup(array(
            'entrar'
        ),  'btAcoes');
    }
}
