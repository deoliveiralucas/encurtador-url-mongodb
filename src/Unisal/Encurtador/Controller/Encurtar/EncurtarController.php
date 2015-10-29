<?php

namespace Unisal\Encurtador\Controller\Encurtar;

use Unisal\Encurtador\Controller\IController;
use Unisal\Encurtador\Factory\ServiceFactory;

/**
 * @author Lucas Oliveira
 */
class EncurtarController implements IController
{
    public function canHandle()
    {
        return isset($_GET['c']) && $_GET['c'] == 'encurtar';
    }
    
    public function handle()
    {
        if (! isset($_GET['url'])) {
            throw new \InvalidArgumentException(
                'Ops.. não foi possível encontrar a URL'
            );
        }
        $url = $_GET['url'];
        
        $encurtadorService = ServiceFactory::createEncurtadorService();
        
        header('Content-type: application/json');
        echo json_encode($encurtadorService->encurtar($url));
    }
}
