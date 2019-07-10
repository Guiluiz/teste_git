<?php

class UsuarioController extends Zend_Controller_Action
{

  public function init() {
        $this->view->controller = "usuario";
    }

    public function indexAction() {
        $this->view->title = "Projeto Incluir - Gerenciamento de Usuários";
        $form_consulta = new Application_Form_FormConsultaUsuario();
        $this->view->form = $form_consulta;

        if ($this->getRequest()->isPost()) {
            $dados = $this->getRequest()->getPost();
            $pagina = 1;
        } else {
            $dados = $this->getRequest()->getParams();
            $pagina = $this->_getParam('pagina');
        }

        
    }


    public function cadastrarAction()
    {
        // action body
    }


}



