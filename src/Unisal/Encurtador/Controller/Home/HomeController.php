<?php

namespace Unisal\Encurtador\Controller\Home;

use Unisal\Encurtador\Controller\IController;
use Unisal\Encurtador\Factory\ServiceFactory;

/**
 * @author Lucas Oliveira
 */
class HomeController implements IController
{
    public function canHandle()
    {
        return !isset($_GET['c']) || $_GET['c'] == 'home';
    }
    
    public function handle()
    {
        $encurtadorService = ServiceFactory::createEncurtadorService();
        
        $urls = $encurtadorService->getUltimasUrls();
        $host = $_SERVER['HTTP_HOST'];
        
        $twig = \Zend_Registry::get('twig');
        echo $twig->render('index.twig', [
            'urls' => $urls,
            'host' => $host
        ]);
    }
}
