<?php

namespace Unisal\Encurtador\Controller\Acessar;

use Unisal\Encurtador\Controller\IController;
use Unisal\Encurtador\Factory\ServiceFactory;

/**
 * @author Lucas Oliveira
 */
class AcessarController implements IController
{
    public function canHandle()
    {
        return isset($_GET['c']) && $_GET['c'] == 'acessar';
    }
    
    public function handle()
    {
        $encurtadorService = ServiceFactory::createEncurtadorService();
        
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $detalhesURL = $encurtadorService->getDetalhesURL($url);
        if (! $encurtadorService->atualizarAcessoURL($url)) {
            throw new \RuntimeException(
                'Ocorreu um problema ao atualizar acesso na URL'
            );
        }
        
        header("Location: " . $detalhesURL['detalhe']['url'], null, 301);
    }
}
