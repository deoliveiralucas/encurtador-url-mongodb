<?php

namespace Unisal\Encurtador\Controller;

use Unisal\Encurtador\Controller\IController;

/**
 * O gerenciador de Controllers é responsável por encontrar
 * qual Controller consegue manipular a requisição do usuário.
 * @author Lucas de Oliveira
 */
class ControllerManager
{
    /**
     * Lista de Controllers.
     * @var array
     */
    protected $controllers = [];

    /**
     * Adiciona um Controller.
     * @param IController $controller
     * @return boolean.
     */
    public function addController(IController $controller)
    {
        $exists = false;
        foreach ($this->controllers as $c) {
            if ($c == $controller) {
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            $this->controllers[] = $controller;
            return true;
        }
        return false;
    }

    /**
     * Identifica o Controller adequado para manipular a requisição do usuário.
     * @throws RuntimeException Caso não encontre nenhum Controler para
     *         manipular a requisição.
     */
    public function handle()
    {
        $found = false;
        foreach ($this->controllers as $controller) {
            if ($controller->canHandle()) {
                $controller->handle();
                $found = true;
                break;
            }
        }
        
        if (! $found) {
            throw new \RuntimeException('Ops.. não entendi sua requisição.');
        }
    }
}
