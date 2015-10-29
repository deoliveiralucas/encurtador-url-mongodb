<?php

namespace Unisal\Encurtador;

use Unisal\Encurtador\Controller\ControllerManager;
use Unisal\Encurtador\Controller\Home\HomeController;
use Unisal\Encurtador\Controller\Sobre\SobreController;
use Unisal\Encurtador\Controller\Erro\ErroController;
use Unisal\Encurtador\Controller\Encurtar\EncurtarController;
use Unisal\Encurtador\Controller\Detalhes\DetalhesController;
use Unisal\Encurtador\Controller\Acessar\AcessarController;

/**
 * Classe responsável por iniciar a aplicação
 * @author Lucas de Oliveira
 */
class Application
{
    /**
     * @var Application
     */
    private static $instance;

    /**
     * @var ControllerManager
     */
    private $controllerManager;

    private function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/views/');
        \Zend_Registry::set('twig', new \Twig_Environment($loader));
        
        $this->controllerManager = new ControllerManager();
        $this->controllerManager->addController(new HomeController());
        $this->controllerManager->addController(new EncurtarController());
        $this->controllerManager->addController(new SobreController());
        $this->controllerManager->addController(new DetalhesController());
        $this->controllerManager->addController(new AcessarController());
    }

    /**
     * Chama o gerenciador de controller para que ele possa
     * encontrar o Controller responsável por manipular a requisição
     * do usuário, caso não encontre, a view de erro é exibida.
     */
    public function handle()
    {
        try {
            $this->controllerManager->handle();
        } catch (\Exception $e) {
            $erro = new ErroController();
            $erro->setMensagemErro($e->getMessage());
            $erro->handle();
        }
    }

    /**
     * Retorna a instância da aplicação.
     * @return Application
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    /**
     * Executa a aplicação.
     * @see Application::handle()
     */
    public static function run()
    {
        self::getInstance()->handle();
    }
}
