<?php

namespace Unisal\Encurtador\Controller\Sobre;

use Unisal\Encurtador\Controller\IController;

/**
 * @author Lucas Oliveira
 */
class SobreController implements IController
{
    public function canHandle()
    {
        return isset($_GET['c']) && $_GET['c'] == 'sobre';
    }
    
    public function handle()
    {
        $twig = \Zend_Registry::get('twig');
        echo $twig->render('sobre.twig');
    }
}
