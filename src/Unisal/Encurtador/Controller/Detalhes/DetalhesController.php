<?php

namespace Unisal\Encurtador\Controller\Detalhes;

use Unisal\Encurtador\Controller\IController;
use Unisal\Encurtador\Factory\ServiceFactory;

/**
 * @author Lucas Oliveira
 */
class DetalhesController implements IController
{
    public function canHandle()
    {
        return isset($_GET['c']) && $_GET['c'] == 'detalhes';
    }
    
    public function handle()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        
        $encurtadorService = ServiceFactory::createEncurtadorService();
        $urlService = ServiceFactory::createURLService();
        $graficoGoogleService = ServiceFactory::createGraficoGoogleService();
        
        $detalhesURL = $encurtadorService->getDetalhesURL($url);
        $infoURL = $urlService->getURLInfo($detalhesURL['detalhe']['url']);
        $graficoGoogle = $graficoGoogleService->getGrafico($detalhesURL['dias']);
        $urlAcesso = 'http://' . $_SERVER['HTTP_HOST'] . '?c=acessar&url=' . $url;
        
        $dadosView = [
            'url_acesso'     => $urlAcesso,
            'visualizacoes'  => $detalhesURL['visualizacoes'],
            'info_url'       => $infoURL,
            'grafico_google' => $graficoGoogle,
            'url'            => $detalhesURL['detalhe']
        ];
        
        $twig = \Zend_Registry::get('twig');
        echo $twig->render('detalhes.twig', $dadosView);
    }
}
