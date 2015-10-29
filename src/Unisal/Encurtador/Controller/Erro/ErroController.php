<?php

namespace Unisal\Encurtador\Controller\Erro;

use Unisal\Encurtador\Controller\IController;

/**
 * @author Lucas Oliveira
 */
class ErroController implements IController
{
    protected $messagemErro;
    
    public function setMensagemErro($msg)
    {
        $this->messagemErro = $msg;
    }
    
    public function canHandle()
    {
        // Manipula apenas quando ocorre algum erro
    }
    
    public function handle()
    {
        $twig = \Zend_Registry::get('twig');
        echo $twig->render('erro.twig', ['erro' => $this->messagemErro]);
    }
}
