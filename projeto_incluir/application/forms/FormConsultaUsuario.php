<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_FormConsultaUsuario extends Zend_Form {

    public function init() {
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'Decorators/form-consulta-usuario.phtml')))
        );
        
        $string_filter = new Aplicacao_Filtros_StringFilter();
        
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login:')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addFilter($string_filter)
                ->setDecorators(array(
                    'ViewHelper',
                    'Errors',
                    'Label'
                ));


        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setDecorators(array(
                    'ViewHelper',
                    'Errors',
                    'Label'
                ));


        $buscar = new Zend_Form_Element_Submit('buscar');
        $buscar->setLabel('Buscar')
                ->setDecorators(array(
                    'ViewHelper'
                ));

        $this->addElements(array(
            $login,
            $nome,
            $buscar
        ));
    }

}


